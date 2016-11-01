<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.dashboard.css', array('inline' => false));
$this->Html->css('connectyee.calendar.css', array('inline' => false));
$this->Html->script('connectyee.dashboard.js', array('inline'=>false));
?>

<div id="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div id="date-info-wrapper" class="clearfix">
                <div class="col-md-4">
                    <div id="calendar-header" class="clearfix">
                        <span id="btn-prev-month" class="glyphicon icon-circle-left" aria-hidden="true"></span>
                        <span id="display-year-month">2016/03</span>
                        <span id="btn-next-month" class="glyphicon icon-circle-right" aria-hidden="true"></span>
                    </div>
                    <div id="calendar-body">
                        <table></table>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="list-group">
                        <div id="date-name" class="list-group-item">
                        </div>
                        <div id="schedule-wrapper" class="list-group-item">
                        </div>
                        <div id="attendance-wrapper" class="list-group-item">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div id="webmail-heading" class="panel-heading">
                        WebMail
                    </div>
                    <div class="list-group">
<?php if (count($MailList) > 0): ?>
    <?php foreach ($MailList as $key=>$val): ?>
        <?php $sendingUser = $val->getSendingUser(); ?>
        <?php $unread = $val->getUnreadKubun($LoginUser->getUserId()) === 1 ? 'true' : 'false'; ?>
                        <div class="webmail-body hvr-shadow list-group-item">
                            <a href="<?php echo Router::url(array('controller'=>'WebMails', 'action'=>'displayReceivingMail', $val->getId())); ?>" class="panel-link" data-unread="<?php echo $unread; ?>">
                                <p class="WebMail-title"><?php echo $val->getSubject(true) === '' ? '&nbsp;' : $val->getSubject(true); ?></p>
                                <p class="WebMail-from">from:<?php echo $sendingUser->getFullName(true); ?></p>
                            </a>
                        </div>
    <?php endforeach; ?>
<?php else: ?>
                        <div class="webmail-body list-group-item">
                            <div class="panel-link">
                                <p class="webmail-title">&nbsp;</p>
                                <p class="wemail-from">&nbsp;</p>
                            </div>
                        </div>
<?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div id="bbs-heading" class="panel-heading">
                        BBS
                    </div>
                    <div class="list-group">
<?php if (count($PostList) > 0): ?>
    <?php foreach ($PostList as $key=>$val): ?>
        <?php $postsUser = $val->getPostsUser(); $postDate = $val->getPostDate(); ?>
                        <div class="bbs-body hvr-shadow list-group-item">
                            <a href="#" class="panel-link">
                                <p class="bbs-title"><?php echo $val->getTitle(true); ?></p>
                                <p class="bbs-post-info">@<?php echo $postsUser->getFullName(true); ?>:<?php echo $postDate->format('Y/m/d'); ?></p>
                            </a>
                        </div>
    <?php endforeach; ?>
<?php else: ?>
                        <div class="bbs-body list-group-item">
                            <div class="panel-link">
                                <p class="bbs-title">&nbsp;</p>
                                <p class="bbs-post-info">&nbsp;</p>
                            <div>
                        </div>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
