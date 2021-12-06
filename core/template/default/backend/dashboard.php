<?php 
# Stop if not admin
if (!$this->isAdmin())
	return false;
?>
<!-- Tool bar -->
<div class="admintools-interface">
    <?php echo $this->getBackEnd('tools.php') ?>
</div>
<h2>Dashboard</h2>
<p>Welcome to your dashboard.</p>