<?php
use \phpseclib3\Crypt\PublicKeyLoader as RSA;
use \phpseclib3\Net\SFTP;
use \Nubersoft\nForm as Form;
use \Widget\WidgetFtp;
use \Nubersoft\JWTFactory;

spl_autoload_register(function ($class) {
    if (preg_match('/^Widget/', $class)) {
        $path = __DIR__ . DS . str_replace('\\', DS, preg_replace('/^Widget/', 'src', $class)) . '.php';
        if (is_file($path))
            include($path);
    }
});
$Settings = new WidgetFtp($this);
# Set define for the remote system
define('SFTP_SERVER_ROOT', $Settings->getSettings()->remoteftproot);
define('REMOTE_FTPSSERVER', $Settings->getSettings()->remoteftpuri);
define('REMOTE_FTPSIP', $Settings->getSettings()->remoteftpip);
?>
<h3 class="tag-beta">sFTP Downloader</h3>
<p>This plugin is meant to download your your live content to your local folder to mirror your live site. Requires a local copy of your RSA private key.</p>
<?php if (empty(REMOTE_FTPSIP || empty(REMOTE_FTPSSERVER))) : ?>
    <div class="alert alert-danger">Ip Address is missing for remote host.</div>
    <p>In order to create a file mirror, you must create system components (4) with the following attributes:</p>
    <code>
        <?php if (empty($Settings->getSettings()->remoteftpip)) : ?>
            category_id = remoteftpip | option_attribute = {{the ip of your server}}<br />
        <?php endif ?>
        <?php if (empty($Settings->getSettings()->remoteftproot)) : ?>
            category_id = remoteftproot | option_attribute = {{the server root path to your domain root}}<br />
        <?php endif ?>
        <?php if (empty($Settings->getSettings()->remoteftppriv)) : ?>
            category_id = remoteftppriv | option_attribute = {{the local path to the private key}}<br />
        <?php endif ?>
        <?php if (empty($Settings->getSettings()->remoteftpuri)) : ?>
            category_id = remoteftpuri | option_attribute = {{https://www.example.com}}
        <?php endif ?>
        <?php if (empty($Settings->getSettings()->remoteftpuser)) : ?>
            category_id = remoteftpuser | option_attribute = {{username}}
        <?php endif ?>
    </code>
<?php
    return false;
endif;
# If the copy request is made
if ($this->getPost('action') == 'copyftp') {
    $page = $this->getPost('dir');

    if ($page == 'dump') {
        $database = @json_decode(file_get_contents(REMOTE_FTPSSERVER, false, stream_context_create([
            'http' => [
                'method' => 'POST',
                'header' => [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer '.\NubersoftCms\Model\Api::generateKey()
                ],
                'content' => [
                    'service' => 'Admin.generateKey'
                ]
            ]
        ])), 1);

        if (!empty($database) && empty($database['alert'])) {
            $nQuery = $this->nQuery();
            foreach ($nQuery->query("show tables")->getResults() as $table) {
                $table = array_values($table)[0];
                $nQuery->query("DROP TABLE `{$table}`");
            }

            foreach ($database as $insert) {
                $nQuery->query($insert);
            }
        }
    } else {
        $key = __DIR__.DS.'remotekey.pem';
        if(is_file($key) && !is_readable($key)) {
            throw new \Exception('You need to make your key readable.', 403);
        }
        $sftp = new SFTP(REMOTE_FTPSIP);
        $key = RSA::loadPrivateKey(file_get_contents($key));
        if (!$sftp->login($Settings->getSettings()->remoteftpusername, $key)) {
            throw new Exception('Login failed');
        }
        $pg = str_replace('//', '/', SFTP_SERVER_ROOT . '/' . ltrim($page, '/'));
        $Ftp = new \Widget\Ftp($sftp, $pg);
        //$Ftp//->addIgnore('path', '/domain/phpMyAdmin')
        //->addIgnore('path', '/client/settings/cache')->fetch()
        //->setRoot(SFTP_SERVER_ROOT.$page);//->fetch();
        $response = $Ftp->addIgnore('path', '/domain/phpMyAdmin')->fetch()->toLocal(NBR_ROOT_DIR, $this);
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