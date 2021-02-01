<head profile="http://www.w3.org/2005/10/profile">
<?php echo $this->getTitle($this->siteUrl($this->getPage('full_path'))) ?>
<?php echo $this->getMeta(['viewport' => 'width=device-width', 'Author' => 'Rasclatt']) ?>
<?php echo $this->Html->createMeta('charset', 'utf-8', true) ?>
<script>
    // Example shopping cart
	var itemList = function(){
        return {	
            "1011400": {
            title: "Widget Express",
            description: "This widget is the product for you and is clearly awesome",
                cv: 100,
                sh: 17.99,
                price: 99.99
            }
        }
    };
</script>
<?php echo $this->styleSheets() ?>
<?php echo $this->headerStyleSheets() ?>
<?php echo $this->Html->createScript('https://code.jquery.com/jquery-3.3.1.min.js',null,null,null,'integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"') ?>
<?php echo $this->Html->createScript('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',null,null,null,'integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"') ?>
<?php echo $this->javaScript() ?>
<?php echo $this->headerJavaScript() ?>
<?php echo $this->getHeader() ?>
</head>