<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.user.css', array('inline' => false));
$this->Html->script('connectyee.user.js', array('inline'=>false));
?>

<div id="page-content-wrapper">
    <div id="completed-msg" class="panel panel-default">
        以下のとおり、ユーザー情報を変更しました。
    </div>
    <div id="input-user-info-wrapper" class="panel panel-default">
        <form>
            <div class="container-fluid">
                <div id="full-name-wrapper" class="row">
                    <div id="full-name-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">氏名</div>
                    <div id="full-name-body" class="input-user-info-body col-xxs-12 col-xs-9 col-sm-10">
                        <?php echo $LoginUser->getFullName(true); ?>
                    </div>
                </div>
                <div id="full-name-kana-wrapper" class="row">
                    <div id="full-name-kana-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">氏名カナ</div>
                    <div id="full-name-kana-body" class="input-user-info-body completed col-xxs-12 col-xs-9 col-sm-10">
                        <?php echo $LoginUser->getFullNameKana(true); ?>
                    </div>
                </div>
                <div id="account-wrapper" class="row">
                    <div id="account-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">アカウント</div>
                    <div id="account-body" class="input-user-info-body completed col-xxs-12 col-xs-9 col-sm-10">
                        <?php echo $LoginUser->getAccount(true); ?>
                    </div>
                </div>
                <div id="mailaddress-wrapper" class="row">
                    <div id="mailaddress-header" class="input-user-info-header col-xxs-12 col-xs-3 col-sm-2">メールアドレス</div>
                    <div id="mailaddress-body" class="input-user-info-body completed col-xxs-12 col-xs-9 col-sm-10">
                        <?php echo $LoginUser->getMailAddress(true); ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
