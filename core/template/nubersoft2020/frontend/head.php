<head profile="http://www.w3.org/2005/10/profile">
<?php echo $this->getTitle($this->siteUrl($this->getPage('full_path'))) ?>
<?php echo $this->getMeta(['viewport' => 'width=device-width', 'Author' => 'Rasclatt']) ?>
<?php echo $this->Helpers->Html->createMeta('charset', 'utf-8', true) ?>
<?php echo $this->styleSheets() ?>
<!-- CREATE BOOTSTRAP -->
<?php echo $this->Helpers->Html->createLinkRel('//stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',null,null,null,' integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"') ?>

<?php echo $this->headerStyleSheets() ?>
<?php echo $this->Helpers->Html->createScript('https://code.jquery.com/jquery-3.3.1.min.js',null,null,null,'integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"') ?>
<?php echo $this->Helpers->Html->createScript('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',null,null,null,'integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"') ?>
<?php echo $this->getPlugin('widget_csrf') ?>
<?php echo $this->javaScript() ?>
<!-- CREATE BOOTSTRAP -->
<?php echo $this->Helpers->Html->createScript('//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',null,null,null,' integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"') ?>
<?php echo $this->headerJavaScript() ?>
<?php echo $this->getHeader() ?>
</head>