<?php
use \Nubersoft\{
    JWTFactory as JWT
};

$JWT = JWT::get();
$toMessages = function ($array) {
    if (!empty($array)) {
        $new = [];
        \Nubersoft\ArrayWorks::extractAll($array, $new);
        return $new;
    }
    return $array;
};
$success = $toMessages(array_unique($this->getSystemMessages('success')));
$errors = $toMessages(array_unique($this->getSystemMessages('errors')));
$msg = (!empty($this->getRequest('msg'))) ? $this->getRequest('msg') : false;
try {
    $data   =   $JWT->get($msg);
    $expire    =   ($data['expire']) ?? false;
    if ($expire) {
        $expired    =   ($expire < time());
        $msg    =   ($data['msg']) ?? false;
    }
} catch (\Exception $e) {
}
$hasAlert   =   (!empty($errors) || !empty($success));
?>

<?php if ($hasAlert) : ?>
    <div class="start2 align-middle alert-wrapper">
        <span class="alert-dismissible">
        <?php endif ?>

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger pointer dismiss-parent" role="alert"><?php echo implode('</div><div class="alert alert-danger pointer" role="alert">', $errors) ?></div>
        <?php elseif (!empty($success)) : ?>
            <div class="alert alert-success pointer dismiss-parent" role="alert"><?php echo implode('</div><div class="alert alert-success pointer" role="alert">', $success) ?></div>
        <?php endif ?>

        <?php if ($hasAlert) : ?>
        </span>
    </div>
<?php endif ?>

<?php if (isset($expired)) : ?>
    <?php if (!$expired) : ?>

        <div class="start2 align-middle alert-wrapper">
            <div class="alert alert-warning alert-dismissible fade show pointer<?php if (!empty($delay) && ($delay == 'off')) echo ' stay' ?>" role="alert"><?php
                                                                                                                                                            echo $this->getHelper('ErrorMessaging')->getMessageAuto($msg);
                                                                                                                                                            ?><button class="close-x close" data-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        </div>

    <?php endif ?>
<?php endif ?>