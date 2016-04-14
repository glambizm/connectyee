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
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="受信メール" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'displayReceivingMailList')); ?>">
                <span class="connectyee-icons icon-email-inbox" aria-hidden="true"></span>
            </a>
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="送信メール" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'displaySendingMailList')); ?>">
                <span class="connectyee-icons icon-email-outbox" aria-hidden="true"></span>
            </a>
        </div>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="メール転送" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'forwardMail', $SendingMail->getId())); ?>">
                <span class="connectyee-icons icon-arrow-right" aria-hidden="true"></span>
            </a>
            <a type="button" class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="新規作成" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'makeNewMail')); ?>">
                <span class="connectyee-icons icon-email-edit" aria-hidden="true"></span>
            </a>
        </div>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="削除" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'deleteSendingMail', $SendingMail->getId())); ?>">
                <span class="connectyee-icons icon-delete-button" aria-hidden="true"></span>
            </a>
        </div>
    </div>
<?php
    $SendingTime = $SendingMail->getSendingTime();
    $ReceivingUserList = $SendingMail->getReceivingUserList();
    $ReceivingUserNameList = array();
    foreach ($ReceivingUserList as $val) {
        $ReceivingUserNameList[] = $val->getFullName(true);
    }

    $ReceivingUserNames = '&nbsp;';
    if (count($ReceivingUserNames) > 0) {
        $ReceivingUserNames = 'TO:　' . implode(';　', $ReceivingUserNameList) . ';';
    }
    $SendingUser = $SendingMail->getSendingUser();
?>
    <div id="mail-wrapper" class="panel panel-default">
        <div id="mail-container" class="container-fluid">
            <div class="row">
                <div class="mail-subject col-sm-7"><?php echo $SendingMail->getSubject(true) === '' ? '（件名なし）' : $SendingMail->getSubject(true); ?></div>
                <div class="mail-date col-sm-5"><?php echo $SendingTime->format('Y/n/j(D) G:i'); ?></div>
            </div>
            <div class="row">
                <div class="mail-receiving-users col-xs-12"><?php echo $ReceivingUserNames; ?></div>
            </div>
            <div class="row">
                <div class="mail-body col-xs-12"><?php echo $SendingMail->getBody(true); ?></div>
            </div>
        </div>
    </div>
</div>
