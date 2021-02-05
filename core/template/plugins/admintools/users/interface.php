
<div class="col-count-5 gapped col-c3-lg col-c1-sm pad-bottom-1 margin-bottom-1">
	<?php if(!empty($this->getRequest('create')) || !empty($this->getRequest('edit'))): ?>
	<div><a class="nbr button green small" href="?table=users&subaction=interface">Users</a></div>
	<?php endif ?>
	<?php if(empty($this->getRequest('create'))): ?>
	<div><a class="nbr button green small" href="?table=users&create=true&subaction=interface">New User</a></div>
	<?php endif ?>
</div>