
<div class="flexor margin-bottom-1 margin-top-0 admintools-subnav-banner" role="navigation">
    <?php
    foreach(\NubersoftCms\Model\AdminTools::pluginsWithButtons() as $btn){
		include($btn);
	}?>
</div>