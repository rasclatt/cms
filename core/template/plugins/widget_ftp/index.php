<?php
use \phpseclib3\Crypt\PublicKeyLoader as RSA;
use \phpseclib3\Net\SFTP;
use \Widget\WidgetFtp;
use \Nubersoft\{
    nQuery,
    nForm as Form,
    Settings
};

$plugin_id = basename(__DIR__);

if ($this->getPost('action') == 'widget_admin_ftp_settings') {
    foreach ($this->getPost('settings') as $k => $v) {
        (new Settings)->deleteOption($k, 'system')->setOption($k, $v, 'system');
    }
    $this->redirect('?load=' . $plugin_id);
}

spl_autoload_register(function ($class) {
    if (preg_match('/^Widget/', $class)) {
        $path = __DIR__ . DS . str_replace('\\', DS, preg_replace('/^Widget/', 'src', $class)) . '.php';
        if (is_file($path))
            include($path);
    }
});
$Settings = new WidgetFtp($this);
$form = $Settings->getSettings();

# Set define for the remote system
define('SFTP_SERVER_ROOT', $form->remoteftproot);
define('REMOTE_FTPSSERVER', $form->remoteftpuri);
define('REMOTE_FTPSIP', $form->remoteftpip);
?>
<h3>sFTP Downloader</h3>
<p>This plugin is meant to download your your live content to your local folder to mirror your live site.</p>
<div class="alert alert-info">In order for the database to be copied, the local JWT and remote JWT secret needs to be the same.</div>
<?php if (count(array_filter($form->toArray())) != 5) : ?>
    <div class="alert alert-danger">Ip Address is missing for remote host.</div>
    <p>In order to create a file mirror, you must create <a href="?table=system_settings">system settings</a> with the following attributes:</p>
    <code>
        <?php if (empty($form->remoteftpip)) : ?>
            category_id = remoteftpip | option_attribute = {{the ip of your server}}<br />
        <?php endif ?>

        <?php if (empty($form->remoteftproot)) : ?>
            category_id = remoteftproot | option_attribute = {{the server root path to your domain root}}<br />
        <?php endif ?>

        <?php if (empty($form->remoteftppriv)) : ?>
            category_id = remoteftppriv | option_attribute = {{the local path to the private key}}<br />
        <?php endif ?>

        <?php if (empty($form->remoteftpuri)) : ?>
            category_id = remoteftpuri | option_attribute = {{https://www.example.com}}<br />
        <?php endif ?>

        <?php if (empty($form->remoteftpuser)) : ?>
            category_id = remoteftpuser | option_attribute = {{username}}<br />
        <?php endif ?>

    </code>

<?php return false;
endif;
?>
<?php echo Form::getOpen(['action' => '#', 'enctype' => 'multipart/form-data']) ?>
<?php echo Form::getFullhide(['name' => 'action', 'value' => 'widget_admin_ftp_settings']) ?>

<?php echo Form::getText(['label' => 'Remote Ip', 'name' => 'settings[remoteftpip]', 'value' => $form->remoteftpip, 'class' => 'nbr']) ?>

<?php echo Form::getText(['label' => 'Remote FTP Root', 'name' => 'settings[remoteftproot]', 'value' => $form->remoteftproot, 'class' => 'nbr']) ?>

<?php echo Form::getText(['label' => 'Private Key', 'name' => 'settings[remoteftppriv]', 'value' => $form->remoteftppriv, 'class' => 'nbr']) ?>

<?php echo Form::getText(['label' => 'Remote Username', 'name' => 'settings[remoteftpuser]', 'value' => $form->remoteftpuser, 'class' => 'nbr']) ?>

<?php echo Form::getText(['label' => 'Remote URI', 'name' => 'settings[remoteftpuri]', 'value' => $form->remoteftpuri, 'class' => 'nbr']) ?>

<?php echo Form::getSubmit(['value' => 'Save', 'class' => 'button standard mt-4']) ?>
<?php echo Form::getClose() ?>

<?php # If the copy request is made
if ($this->getPost('action') == 'copyftp') {
    $page = $this->getPost('dir');
    if ($page == 'dump') {
        $fetch = file_get_contents(REMOTE_FTPSSERVER, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer ' . \NubersoftCms\Model\Api::generateKey()
                ],
                'content' => http_build_query([
                    'service' => 'Admin.getDatabaseContents'
                ])
            ]
        ]));
        $database = @json_decode($fetch, 1);
        if (!empty($database) && empty($database['alert'])) {
            $nQuery = new nQuery;
            foreach ($nQuery->query("show tables")->getResults() as $table) {
                $table = array_values($table)[0];
                if ($table != 'system_settings')
                    $nQuery->query("DROP TABLE `{$table}`");
            }

            foreach ($database as $insert) {
                if (strpos($insert, '`system_settings`') !== false)
                    continue;

                $nQuery->query($insert);
            }
        }
    } else {
        $key = $form->remoteftppriv;
        $sftp = new SFTP(REMOTE_FTPSIP);
        if (is_file($key) && !is_readable($key))
            throw new Exception('The key file is unreadable. Requires a permission modification.');
        $key = RSA::load(file_get_contents($key));
        if (!$sftp->login($Settings->getSettings()->remoteftpuser, $key)) {
            throw new Exception('Login failed');
        }
        $pg = str_replace('//', '/', SFTP_SERVER_ROOT . '/' . ltrim($page, '/'));
        $Ftp = new \Widget\Ftp($sftp, $pg);
        $response = $Ftp
            ->addIgnore('path', '/vendor')
            ->addIgnore('path', '/domain/core')
            ->addIgnore('path', '/domain/phpMyAdmin')->fetch()->toLocal(NBR_ROOT_DIR, $this);
        echo '<code>' . printpre($response, 1) . '</code>';
    }
}
?>
<div class="mt-4 col-count-3 gapped">
    <p class="start1 mb-0">Remote Root: <code><?php echo SFTP_SERVER_ROOT ?></code></p>
    <div class="start1 align-middle"><i class="fas fa-arrow-circle-down"></i></div>
    <p class="start1 mb-0">Local Root: <code><?php echo NBR_ROOT_DIR ?></code></p>
</div>

<?php echo Form::getOpen(['action' => '?load=widget_ftp']) ?>
<?php echo Form::getFullhide(['name' => 'action', 'value' => 'copyftp', 'class' => 'nbr']) ?>
<div class="col-count-4 gapped col-c2-lg col-c1-md">
    <?php echo Form::getSelect(['label' => 'Select Subpage to Copy', 'name' => 'dir', 'class' => 'nbr', 'options' => [
        [
            'name' => 'Database Import',
            'value' => 'dump'
        ],
        [
            'name' => 'Domain Root (Frontend)',
            'value' => 'domain'
        ],
        [
            'name' => 'Client Folder (Backend)',
            'value' => 'client'
        ],
        [
            'name' => 'Root',
            'value' => ''
        ]
    ]]) ?>

    <div class="span4 span2-lg span1-md">
        <?php echo Form::getSubmit(['value' => 'Save', 'class' => 'nbr auto']) ?>
    </div>
</div>
<?php echo Form::getClose() ?>

<style>
    #admin-content>div:last-child {
        display: none;
    }
</style>