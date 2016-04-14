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
    <?php echo $this->Html->css('page-loading-effects.css'); ?>
    <?php echo $this->Html->css('connectyee.login.css'); ?>
    <?php echo $this->Html->script('snap.svg-min.js', array('inline'=>true)); ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <?php echo $this->Html->script('//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('//oss.maxcdn.com/respond/1.4.2/respond.min.js', array('inline'=>true)); ?>
    <![endif]-->
</head>

<body>
    <div id="over-lay"></div>
    <div id="loader" class="pageload-overlay" data-opening="M 40 -21.875 C 11.356078 -21.875 -11.875 1.3560784 -11.875 30 C -11.875 58.643922 11.356078 81.875 40 81.875 C 68.643922 81.875 91.875 58.643922 91.875 30 C 91.875 1.3560784 68.643922 -21.875 40 -21.875 Z">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="xMidYMid slice">
            <path d="M40,30 c 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 Z"/>
        </svg>
    </div>

    <div class="container">
        <div class="card card-container">
            <?php echo $this->Html->image('login.logo-img.png', array('alt'=>'logo-img', 'id'=>'logo-img', 'class'=>'logo-img-card')); ?>
            <?php echo $this->Form->create('DashBoards', array('action'=>'login', 'class'=>'form-login')); ?>
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" name="account" id="inputAccount" class="form-control" maxlength="15" placeholder="account" value="<?php echo htmlentities($input_account, ENT_QUOTES, 'UTF-8'); ?>" required autofocus>
                <input type="password" name="password" id="inputPassword" class="form-control" maxlength="15" placeholder="password" required>
                <span class="error-msg"><?php echo htmlentities($loginMsg, ENT_QUOTES, 'UTF-8'); ?></span>
                <button type="submit" class="btn btn-success btn-block btn-login">LOGIN</button>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <?php echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array('inline'=>true)); ?>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <?php echo $this->Html->script('bootstrap.min.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('connectyee.common.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('classie.js', array('inline'=>true)); ?>
    <?php echo $this->Html->script('svgLoader.js', array('inline'=>true)); ?>
</body>

</html>

