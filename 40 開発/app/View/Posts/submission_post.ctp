<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.post.css', array('inline' => false));
$this->Html->script('connectyee.post.js', array('inline'=>false));
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="記事一覧" href="<?php echo Router::url(array('controller'=>'Posts', 'action'=>'displayPostList')); ?>">
                <span class="connectyee-icons glyphicon glyphicon-list-alt" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div id="post-submission-wrapper" class="panel panel-default">
<?php echo $this->Form->create('Posts', array('action'=>'submissionPost')); ?>
        <div id="input-wrapper">
            <input type="hidden" id="id" name="id" value="<?php echo $Post->getId(); ?>">
            <input type="text" id="title" name="title" maxlength="50" class="form-control" placeholder="タイトルを入力してください。" value="<?php echo $Post->getTitle(true); ?>">
            <textarea id="body" name="body" rows="10" class="form-control" placeholder="本文を入力してください。"><?php echo $Post->getBody(true); ?></textarea>
        </div>
        <div class="clearfix">
            <button type="submit" id="btn-submission" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-placement="top" title="投稿"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>