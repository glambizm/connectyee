<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.user.css', array('inline' => false));
$this->Html->script('connectyee.user.js', array('inline'=>false));
$selected = '';
if (intval($User->getAuthority()) === 1) {
    $selected = 'selected';
}
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="ユーザー一覧" href="<?php echo Router::url(array('controller'=>'Users', 'action'=>'displayUserList')); ?>">
                <span class="connectyee-icons-larger icon-folder2" aria-hidden="true"></span>
            </a>
        </div>
<?php if ($User->isExist() === true): ?>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="ユーザー削除" href="<?php echo Router::url(array('controller'=>'Users', 'action'=>'deleteUser', $User->getUserId())); ?>">
                <span class="connectyee-icons icon-delete-button" aria-hidden="true"></span>
            </a>
        </div>
<?php endif; ?>
    </div>
    <div id="input-user-info-wrapper" class="panel panel-default">
<?php echo $this->Form->create('Users', array('action'=>$this->action)); ?>
        <div class="container-fluid">
            <div id="full-name-wrapper" class="row">
                <div id="full-name-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">氏名</div>
                <div id="full-name-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="full_name" class="form-control" name="full_name" maxlength="30" value="<?php echo $User->getFullName(); ?>" />
                </div>
            </div>
            <div id="full-name-kana-wrapper" class="row">
                <div id="full-name-kana-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">氏名カナ</div>
                <div id="full-name-kana-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="full_name_kana" class="form-control" name="full_name_kana" maxlength="30" value="<?php echo $User->getFullNameKana(); ?>" />
                </div>
            </div>
            <div id="account-wrapper" class="row">
                <div id="account-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">アカウント</div>
                <div id="account-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="account" class="form-control" name="account" maxlength="30" value="<?php echo $User->getAccount(); ?>" />
                </div>
            </div>
            <div id="password-wrapper" class="row">
                <div id="password-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">パスワード</div>
                <div id="password-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="password" id="password" class="form-control" name="password" maxlength="30" value="<?php echo $User->getPassword(); ?>" />
                </div>
            </div>
            <div id="mailaddress-wrapper" class="row">
                <div id="mailaddress-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">メールアドレス</div>
                <div id="mailaddress-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <input type="text" id="mail_address" class="form-control" name="mail_address" maxlength="256" value="<?php echo $User->getMailAddress(); ?>" />
                </div>
            </div>
            <div id="authority-wrapper" class="row">
                <div id="authority-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">権限</div>
                <div id="authority-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                    <select class="form-control" name="authority">
                        <option value="0"></option>
                        <option value="1" <?php echo $selected; ?>>管理者</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $User->getUserId(); ?>">
            <div id="submit-wrapper" class="row">
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
