<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.post.css', array('inline' => false));
$this->Html->script('connectyee.post.js', array('inline'=>false));
Configure::load("connectyee_config.php");
$initial_color = Configure::read('initial_color');
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="記事一覧" href="<?php echo Router::url(array('controller'=>'Posts', 'action'=>'displayPostList')); ?>">
                <span class="connectyee-icons glyphicon glyphicon-list-alt" aria-hidden="true"></span>
            </a>
        </div>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="記事投稿" href="<?php echo Router::url(array('controller'=>'Posts', 'action'=>'submissionPost')); ?>">
                <span class="connectyee-icons icon-interface" aria-hidden="true"></span>
            </a>
<?php if ($Post->checkUser($LoginUser->getUserId()) === true): ?>
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="記事編集" href="<?php echo Router::url(array('controller'=>'Posts', 'action'=>'editPost', $Post->getId())); ?>">
                <span class="connectyee-icons icon-edit" aria-hidden="true"></span>
            </a>
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="記事削除" href="<?php echo Router::url(array('controller'=>'Posts', 'action'=>'deletePost', $Post->getId())); ?>">
                <span class="connectyee-icons icon-delete-button" aria-hidden="true"></span>
            </a>
<?php endif; ?>
        </div>
    </div>
<?php
    $SubmissionUser = $Post->getSubmissionUser();
    $initial = '&nbsp;';
    $initial_class = '';
    $fullName = '&nbsp';
    if ($SubmissionUser !== null) {
        $initial = $SubmissionUser->getInitial();
        $initial_class = $initial_color[$SubmissionUser->getInitial()];
        $fullName = $SubmissionUser->getFullName(true);
    }
    $SubmissionUser = $Post->getPostDate();
?>
    <div id="post-wrapper" class="panel panel-default">
        <div id="post-container" class="container-fluid">
            <div id="post-id" class="hidden"><?php echo $Post->getId(); ?></div>
            <div class="row">
                <div class="post-name col-xs-12">
                    <span class="<?php echo $initial_class ?> text-center"><?php echo $initial; ?></span><span class="full-name"><?php echo $fullName; ?><span>
                </div>
            </div>
            <div class="row">
                <div class="post-date col-sm-5 col-sm-push-7">
                    <?php echo $SendingTime->format('Y/n/j(D) G:i') ?>
                </div>
                <div class="post-title col-sm-7 col-sm-pull-5">
                    <?php echo $Post->getTitle(true); ?>
                </div>
            </div>
            <div class="row">
                <div class="post-body col-xs-12">
                    <?php echo $Post->getBody(true); ?>
                </div>
            </div>
        </div>
    </div>
<?php foreach ($Post->Comments as $val): ?>
    <?php
        $SendingUser = $val->getSubmissionUser();
        $initial = '&nbsp;';
        $initial_class = '';
        $fullName = '&nbsp';
        if ($SendingUser !== null) {
            $initial = $SendingUser->getInitial();
            $initial_class = $initial_color[$SendingUser->getInitial()];
            $fullName = $SendingUser->getFullName(true);
        }
        $SendingTime = $val->getPostDate();
    ?>
    <div class="comment-wrapper panel panel-default">
        <div class="row">
            <div class="comment-name col-sm-2 col-xs-12">
                <span class="<?php echo $initial_class ?> text-center"><?php echo $initial; ?></span><span class="full-name"><?php echo $fullName; ?><span>
            </div>
            <div class="comment-main col-sm-8 col-xs-10">
                <div class="row">
                    <div class="comment-date col-sm-5 col-sm-push-7">
                        <?php echo $SendingTime->format('Y/n/j(D) G:i') ?>
                    </div>
                    <div class="comment-body-title col-sm-7 col-sm-pull-5">
                        <div class="comment-title">
                            <?php echo $val->getTitle(true); ?>
                        </div>
                        <div class="comment-body">
                            <?php echo $val->getBody(true); ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php if ($val->checkUser($LoginUser->getUserId()) === true): ?>
            <div class="comment-delete col-sm-2 col-xs-2">
                <a class="comment-delete-button btn btn-success glyphicon glyphicon-remove" data-toggle="tooltip"data-container="body" data-placement="top" data-comment-id="<?php echo $val->getId(); ?>" title="削除"></a>
            </div>
    <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
    <div id="comment-input-container" class="panel panel-default">
        <input type="text" id="comment-title-input" maxlength="50" class="form-control" placeholder="コメントタイトルを入力してください。">
        <textarea id="comment-body-input" rows="1" class="form-control" placeholder="コメント本文を入力してください。"></textarea>
        <div class="clearfix">
            <button id="btn-comment-regist" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-placement="top" title="登録"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
        </div>
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