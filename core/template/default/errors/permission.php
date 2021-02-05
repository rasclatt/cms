<!doctype html>
<html>
<?php echo $this->getFrontEnd('head.php') ?>
<body id="permission-page error-403">
<?php echo $this->getPlugin('adminbar') ?>
<div class="col-count-3 offset">
	<div class="start2 align-middle pad-top-3 pad-bottom-3">   
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Error #403: Permission Denied</h4>
            <p class="align-center">Uh-oh...you aren't supposed to be here.</p>
            <div class="align-middle">
                <a href="/" class="button standard">Home Page</a>
            </div>
        </div>
	</div>
</div>
<?php echo $this->getFooter() ?>
</body>
</html>