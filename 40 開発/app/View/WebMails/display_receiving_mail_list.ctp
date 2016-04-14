<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.web_mail.css', array('inline' => false));
$this->Html->script('connectyee.web_mail.js', array('inline'=>false));
Configure::load("connectyee_config.php");
$initial_color = Configure::read('initial_color');
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="送信メール" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'displaySendingMailList')); ?>">
                <span class="connectyee-icons icon-email-outbox" aria-hidden="true"></span>
            </a>
        </div>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="新規作成" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'makeNewMail')); ?>">
                <span class="connectyee-icons icon-email-edit" aria-hidden="true"></span>
            </a>
        </div>
    </div>
<?php if (count($ReceivingMailList) > 0): ?>
    <div id="mail-wrapper" class="panel panel-default">
        <div class="container-fluid">
<?php foreach ($ReceivingMailList as $val): ?>
<?php
    $SendingUser = $val->getSendingUser();
    $initial = '&nbsp;';
    $initial_class = '';
    $fullName = '&nbsp';
    if ($SendingUser !== null) {
        $initial = $SendingUser->getInitial();
        $initial_class = $initial_color[$SendingUser->getInitial()];
        $fullName = $SendingUser->getFullName(true);
    }
    $SendingTime = $val->getSendingTime();
?>
            <a href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'displayReceivingMail', $val->getId())); ?>">
                <div class="mail-list-item<?php if ($val->getUnreadKubun() === 1) {echo ' list-unread';} ?> hvr-shadow row">
                    <div class="col-initial col-md-2 col-sm-12 col-xs-12"><span class="<?php echo $initial_class ?> text-center"><?php echo $initial; ?></span><div class="full-name"><?php echo $fullName; ?></div></div>
                    <div class="col-subject col-md-7 col-sm-9 col-xs-12"><?php echo $val->getSubject(true); ?></div>
                    <div class="col-date col-md-3 col-sm-3 col-xs-12"><?php echo $SendingTime->format('Y/n/j(D)') ?><br><?php echo $SendingTime->format('G:i')?></div>
                </div>
            </a>
<?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
</div>
