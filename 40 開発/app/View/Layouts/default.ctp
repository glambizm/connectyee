<!DOCTYPE html>
<html lang="ja">

<head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>connectyee</title>
    <!-- Bootstrap -->
    <?php echo $this->Html->meta('icon');?>
    <?php echo $this->fetch('meta');?>
    <?php echo $this->Html->css('bootstrap.min.css'); ?>
    <?php echo $this->Html->css('bootstrap.paper.min.css'); ?>
    <?php echo $this->Html->css('bootstrap-multiselect.css'); ?>
    <?php echo $this->Html->css('page-loading-effects.css'); ?>
    <?php echo $this->Html->css('connectyee.icon.css'); ?>
    <?php echo $this->Html->css('connectyee.common.css'); ?>
    <?php echo $this->Html->script('snap.svg-min.js', array('inline'=>true)); ?>
    <?php echo $this->fetch('css'); ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <?php echo $this->Html->script('//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('//oss.maxcdn.com/respond/1.4.2/respond.min.js', array('inline'=>true)); ?>
    <![endif]-->
</head>

<body>
	<?php echo $this->fetch('over-lay'); ?>
    <?php echo $this->fetch('header'); ?>
    <?php echo $this->fetch('sidebar'); ?>
    <?php echo $this->fetch('content'); ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <?php echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array('inline'=>true)); ?>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?php echo $this->Html->script('bootstrap.min.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('bootstrap-multiselect.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('connectyee.common.js', array('inline'=>true)); ?>
    <?php echo $this->fetch('script');?>
    <?php echo $this->Html->script('classie.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('svgLoader.js', array('inline'=>true)); ?>
</body>

</html>

