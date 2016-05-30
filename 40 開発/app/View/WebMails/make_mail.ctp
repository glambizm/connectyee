<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.web_mail.css', array('inline' => false));
$this->Html->script('connectyee.web_mail.js', array('inline'=>false));
$OriginalSendingUser = $OriginalMail->getSendingUser();
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="受信メール" href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'displayReceivingMailList')); ?>">
                <span class="connectyee-icons icon-email-inbox" aria-hidden="true"></span>
            </a>
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="送信メール"  href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'displaySendingMailList')); ?>">
                <span class="connectyee-icons icon-email-outbox" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div id="mail-wrapper" class="panel panel-default">
<?php echo $this->Form->create('WebMails', array('action'=>'sendMail')); ?>
            <div id="receiving-user-wrapper" class="clearfix">
                <div id="select-receiving-users-wrapper">
                    <select id="select-receiving-users" multiple="multiple">
<?php foreach ($UserList as $val): ?>
<?php
        if ($this->action === 'replyMail') {
            $selected = $OriginalSendingUser->getUserId() === $val->getUserId() ? ' selected' : '';
        } else {
            $selected = '';
        }
?>
                        <option value="<?php echo $val->getUserId(); ?>"<?php echo $selected; ?>><?php echo $val->getFullName(); ?></option>
<?php endforeach; ?>
                    </select>
                </div>
                <div id="label-receiving-user-list"></div>
            </div>
            <div id="input-wrapper">
                <input type="text" id="subject" name="subject" maxlength="50" class="form-control" placeholder="件名を入力してください。" value="<?php echo $OriginalMail->getSubject(); ?>">
                <textarea id="body" name="body" rows="10" class="form-control" placeholder="本文を入力してください。"><?php echo $OriginalMail->getBody(); ?></textarea>
            </div>
            <div class="clearfix">
                <button type="submit" id="btn-send" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-placement="top" title="送信"><span class="connectyee-icons icon-email-send" aria-hidden="true"></span></button>
            </div>
<?php echo $this->Form->end(); ?>
    </div>
</div>
<div class="modal fade" id="alertModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <h5 id="modal-body-text">「宛先」を選択してください。</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
