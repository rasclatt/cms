<div class="main-button-nav">
    <?php foreach($this->getDataNode('plugins')['paths'] as $path) {
        if(stripos($path, DS.'core'.DS.'template'.DS.'plugins'))
            continue;
        elseif(!is_dir($path))
            continue;
        foreach(scandir($path) as $pdir) {
            $stop   =   false;
            if(in_array($pdir, ['.','..']))
                continue;

            if(!is_file($ui = $path.DS.$pdir.DS.'admin_ui_button.php'))
                continue;

            \Nubersoft\nApp::createContainer(function() use ($ui){ ?>

                <div class="button-<?php echo basename(pathinfo($ui, PATHINFO_DIRNAME)) ?>"><?php include($ui) ?></div>

            <?php });

            if($this->getDataNode('admin_stop'))
                return false;
        }
    } ?>
    
    <div class="button-media"><a href="?table=media&subaction=interface" class="pointer nFx opacity-hover"><i class="fas fa-photo-video fa-6x pointer"></i><br /><br />Media</a></div>
</div>

<hr />
<style>
    .main-button-nav {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-content: center;
        align-items: flex-end;
        flex-wrap: wrap;
    }
    .main-button-nav a {
        text-align: center;
        font-size: 0.65rem !important;
        width: 7em;
        margin: 0.5em;
        text-transform: uppercase;
    }
    .main-button-nav i.fa-6x {
        font-size: 4em;
        text-align: center;
    }
</style>