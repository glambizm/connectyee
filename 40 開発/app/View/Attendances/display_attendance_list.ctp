<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.attendance.css', array('inline' => false));
$this->Html->script('connectyee.attendance.list.js', array('inline'=>false));
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="新規登録" href="<?php echo Router::url(array('controller'=>'Attendances', 'action'=>'registAttendance')); ?>">
                <span class="connectyee-icons icon-interface" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div id="attendance-wrapper">
        <div id="select-date-wrapper" class="panel panel-default">
            <button type="button" id="select-date-button" class="btn btn-success">対象日</button>
            <span id="select-date-label"></span>
        </div>
    </div>
</div>
