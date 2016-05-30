<?php
Configure::load("connectyee_config.php");
$side_bar_info = Configure::read('menu-info');

$this_path = Router::url(array('controller'=>$this->name, 'action'=>$this->action));
foreach ($side_bar_info as $val) {
    if ($val['child'] !== null) {
        foreach ($val['child'] as $val_child) {
            if ($val_child['href'] === $this_path) {
                $this->assign('title', $val_child['sub-title']);
                $this->assign('icon', str_replace('[icon-class]', 'header-icon', $val_child['icon']));
                break;
            }
        }
    } else {
        if ($val['href'] === $this_path) {
            $this->assign('title', $val['sub-title']);
            $this->assign('icon', str_replace('[icon-class]', 'header-icon', $val['icon']));
            break;
        }
    }
}
?>

<?php $this->start('over-lay'); ?>
<div id="loader" class="pageload-overlay" data-opening="M 40 -21.875 C 11.356078 -21.875 -11.875 1.3560784 -11.875 30 C -11.875 58.643922 11.356078 81.875 40 81.875 C 68.643922 81.875 91.875 58.643922 91.875 30 C 91.875 1.3560784 68.643922 -21.875 40 -21.875 Z">
    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 80 60" preserveAspectRatio="xMidYMid slice">
        <path d="M40,30 c 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 0,0 Z"/>
    </svg>
</div>
<div id="over-lay"></div>
<?php $this->end('over-lay'); ?>

<?php $this->start('header'); ?>
<header>
    <div id="header-container" class="clearfix">
        <div id="header-brand-container" class="pull-left">
            <div id="menu-btn-wrapper" class="visible-xs-block">
                <span id="menu-btn-top" class="menu-btn"></span>
                <span id="menu-btn-middle" class="menu-btn"></span>
                <span id="menu-btn-bottom" class="menu-btn"></span>
            </div>
        </div>
        <div id="header-main-container">
            <div id="page-title-container" class="pull-left"><?php echo $this->fetch('icon'); ?><span id="page-title"><?php echo $this->fetch('title'); ?></span></div>
            <div id="logout-container" class="pull-right">
                <a id="logout-btn" class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="left" title="ログアウト" href="<?php echo Router::url(array('controller'=>$this->name, 'action'=>'logout')); ?>"><span id="logout-img" class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a>
            </div>
            <div id="user-name-container" class="pull-right"><span id="user-name"><?php echo $LoginUser->getFullName(true); ?></span></div>
        </div>
    </div>
</header>
<?php $this->end('header'); ?>

<?php $this->start('sidebar'); ?>
<div id="side-bar-desktop-wrapper" class="hidden-xs hidden-sm">
    <div id="side-bar-desktop" class="list-group">
<?php foreach ($side_bar_info as $key=>$val): ?>
    <?php if ($val['display'] !== true) {continue;} ?>
    <?php if ($val['authority'] > $LoginUser->getAuthority()) {continue;} ?>
        <a class="<?php echo $key===0 ? 'side-bar-top ' : ''; ?>side-bar-item list-group-item" href="<?php echo $val['href']; ?>"<?php echo $val['menu-parent']>0 ? ' data-menu-parent="' . $val['menu-parent'] . '"' : ''; ?>>
            <span class="ripple-effect"></span>
            <?php echo str_replace('[icon-class]', 'side-bar-icon', $val['icon']); ?>
            <h6 class="side-bar-desktop-heading list-group-item-heading"><?php echo $val['title']; ?></h6>
            <p class="side-bar-desktop-text list-group-item-text"><?php echo $val['sub-title']; ?></p>
    <?php if ($val['child'] !== null): ?>
            <span class="side-bar-collapse-icon glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
    <?php endif; ?>
        </a>
    <?php if ($val['child'] !== null): ?>
        <div data-menu-child="<?php echo $val['menu-parent'] ?>">
        <?php foreach ($val['child'] as $child_key=>$child_val): ?>
            <?php if ($child_val['display'] !== true) {continue;} ?>
            <a class="side-bar-item side-bar-item-open list-group-item" href="<?php echo $child_val['href']; ?>">
                <span class="ripple-effect"></span>
                <?php echo str_replace('[icon-class]', 'side-bar-icon', $child_val['icon']); ?>
                <h6 class="side-bar-desktop-heading list-group-item-heading"><?php echo $child_val['title']; ?></h6>
                <p class="side-bar-desktop-text list-group-item-text"><?php echo $child_val['sub-title']; ?></p>
            <?php if ($child_val['name'] === 'ReceivingMails'): ?>
                <span class="web_mail_badge badge"><?php if ($unreadMailCount > 0) { echo $unreadMailCount; } ?></span>
            <?php endif; ?>
            </a>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
    </div>
</div>
<div id="side-bar-tablet-wrapper" class="visible-sm-block">
    <div id="side-bar-tablet" class="list-group">
<?php foreach ($side_bar_info as $key=>$val): ?>
    <?php if ($val['display'] !== true) {continue;} ?>
    <?php if ($val['authority'] > $LoginUser->getAuthority()) {continue;} ?>
        <a class="<?php echo $key===0 ? 'side-bar-top ' : ''; ?>side-bar-item list-group-item" href="<?php echo $val['href']; ?>"<?php echo $val['menu-parent']>0 ? ' data-menu-parent="' . $val['menu-parent'] . '"' : ''; ?>>
            <span class="ripple-effect"></span>
            <?php echo str_replace('[icon-class]', 'side-bar-icon', $val['icon']); ?>
        </a>
    <?php if ($val['child'] !== null): ?>
        <div data-menu-child="<?php echo $val['menu-parent'] ?>">
        <?php foreach ($val['child'] as $child_key=>$child_val): ?>
            <?php if ($child_val['display'] !== true) {continue;} ?>
            <a class="side-bar-item side-bar-item-open list-group-item" href="<?php echo $child_val['href']; ?>">
                <span class="ripple-effect"></span>
                <?php echo str_replace('[icon-class]', 'side-bar-icon', $child_val['icon']); ?>
            </a>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
    </div>
</div>
<?php $this->end('sidebar'); ?>

<?php echo $this->fetch('content'); ?>

