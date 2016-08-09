<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.user.css', array('inline' => false));
$this->Html->script('connectyee.user.js', array('inline'=>false));
$ActiveUserList = $UserList->getActiveUserList();
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="ユーザー追加" href="<?php echo Router::url(array('controller'=>'Users', 'action'=>'registUser')); ?>">
                <span class="connectyee-icons-larger icon-social" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div id="user-list-wrapper">
<?php foreach ($ActiveUserList as $val): ?>
    <?php
        $authority = '&nbsp;';
        if (intval($val->getAuthority()) === 1) {
            $authority = '管理者';
        }
    ?>
        <a href="<?php echo Router::url(array('controller'=>'Users', 'action'=>'editUserInfo', $val->getUserId())); ?>">
            <div class="hvr-shadow">
                <div class="panel panel-default">
                    <div class="list-group">
                        <div class="container-fluid">
                            <div class="user-list-header list-group-item row">
                                <div class="full-name-kana col-xs-7"><?php echo $val->getFullNameKana(true); ?></div>
                                <div class="authority col-xs-5"><?php echo $authority; ?></div>
                                <div class="full-name col-xs-12"><?php echo $val->getFullName(true); ?></div>
                            </div>
                            <div class="user-list-body list-group-item row">
                                <div class="account col-xs-12"><?php echo $val->getAccount(true); ?></div>
                            </div>
                            <div class="user-list-body list-group-item row">
                                <div class="mail-address col-xs-12"><?php echo $val->getMailAddress(true); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
<?php endforeach; ?>
    </div>
</div>
