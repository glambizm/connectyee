<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.user.css', array('inline' => false));
$this->Html->script('connectyee.user.js', array('inline'=>false));

if ($inputtedAccount !== '') {
    $account = $inputtedAccount;
} else {
    $account = $LoginUser->getAccount();
}
?>

<div id="page-content-wrapper">
    <div id="input-user-info-wrapper" class="panel panel-default">
<?php echo $this->Form->create('Users', array('action'=>'changeUserProfile')); ?>
        <div class="container-fluid">
            <div id="full-name-wrapper" class="row">
                <div id="full-name-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">氏名</div>
                <div id="full-name-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="full_name" class="form-control" name="full_name" maxlength="30" value="<?php echo $LoginUser->getFullName(); ?>" />
                </div>
            </div>
            <div id="full-name-kana-wrapper" class="row">
                <div id="full-name-kana-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">氏名カナ</div>
                <div id="full-name-kana-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="full_name_kana" class="form-control" name="full_name_kana" maxlength="30" value="<?php echo $LoginUser->getFullNameKana(); ?>" />
                </div>
            </div>
            <div id="account-wrapper" class="row">
                <div id="account-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">アカウント</div>
                <div id="account-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="account" class="form-control" name="account" maxlength="30" value="<?php echo $account; ?>" />
                </div>
            </div>
            <div id="mailaddress-wrapper" class="row">
                <div id="mailaddress-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">メールアドレス</div>
                <div id="mailaddress-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="mail_address" class="form-control" name="mail_address" maxlength="256" value="<?php echo $LoginUser->getMailAddress(); ?>" />
                </div>
            </div>
            <div id="submit-wrapper" class="row">
                <div id="input-user-error-msg"><?php echo $errorMsg; ?></div>
                <button type="submit" id="btn-regist" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-placement="top" title="登録"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
            </div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
