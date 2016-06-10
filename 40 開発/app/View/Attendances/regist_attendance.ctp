<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.attendance.css', array('inline' => false));
$this->Html->script('connectyee.attendance.regist.js', array('inline'=>false));

$attendance_kubun = array('', '', '', '', '', '', '', '');

if ($Attendance->isExist() === true) {
    $disabled = 'disabled="disabled"';
    $target_date = $Attendance->getTargetDate()->format('Y/m/d');
    $attendance_kubun[$Attendance->getAttendanceKubun()] = 'selected="selected"';
    $attendance_kubun_name = $Attendance->getAttendanceKubunName();
    $memo = $Attendance->getMemo(true);
} else {
    $disabled = '';
    $target_date = '';
    $attendance_kubun_name = '';
    $memo = '';
}
?>

<div id="page-content-wrapper">
    <div id="btn-wrapper" class="panel panel-default">
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="勤怠予定一覧" href="<?php echo Router::url(array('controller'=>'Attendances', 'action'=>'displayAttendanceList')); ?>">
                <span class="connectyee-icons glyphicon glyphicon-list" aria-hidden="true"></span>
            </a>
        </div>
<?php if ($Attendance->isExist() === true): ?>
        <div class="btn-group" role="group" aria-label="...">
            <a class="btn btn-default" data-toggle="tooltip" data-container="body" data-placement="top" title="削除" href="<?php echo Router::url(array('controller'=>'Attendances', 'action'=>'deleteAttendance', $Attendance->getId())); ?>">
                <span class="connectyee-icons icon-delete-button" aria-hidden="true"></span>
            </a>
        </div>
<?php endif; ?>
    </div>
    <div id="regist-attendance-wrapper" class="panel panel-default clearfix">
<?php echo $this->Form->create('Attendances', array('action'=>'registAttendance')); ?>
            <div id="target-users-wrapper">
                <div id="select-target-users-wrapper">
                    <select id="select-target-users" <?php echo $disabled ?>>
                        <option value="-1"></option>
<?php foreach ($UserList as $val): ?>
<?php
        if ($Attendance->isExist() === true) {
            $selected = $Attendance->getTargetUser()->getUserId() === $val->getUserId() ? ' selected' : '';
        } else {
            $selected = '';
        }
?>
                        <option value="<?php echo $val->getUserId(); ?>"<?php echo $selected; ?>><?php echo $val->getFullName(true); ?></option>
<?php endforeach; ?>
                    </select>
                </div>
                <span id="label-target-user"></span>
            </div>
            <div id="target-date-wrapper">
                <div id="target-date-button-wrapper">
                    <button type="button" id="target-date-button" class="btn btn-success" <?php echo $disabled ?>>対象日</button>
                </div>
                <span id="label-target-date"><?php echo $target_date ?></span>
                <input type="hidden" id="target-date" name="target_date" readonly="readonly" value="<?php echo $target_date ?>"></input>
            </div>
            <div id="attendance-kubun-wrapper">
                <div id="select-attendance-kubun-wrapper">
                    <select id="select-attendance-kubun">
                        <option value="0" <?php echo $attendance_kubun[0]; ?>>　</option>
                        <option value="1" <?php echo $attendance_kubun[1]; ?>>休み</option>
                        <option value="2" <?php echo $attendance_kubun[2]; ?>>現場出社</option>
                        <option value="3" <?php echo $attendance_kubun[3]; ?>>午前休</option>
                        <option value="4" <?php echo $attendance_kubun[4]; ?>>午後休</option>
                        <option value="5" <?php echo $attendance_kubun[5]; ?>>遅刻</option>
                        <option value="6" <?php echo $attendance_kubun[6]; ?>>早退</option>
                        <option value="7" <?php echo $attendance_kubun[7]; ?>>その他</option>
                    </select>
                </div>
                <span id="label-attendance-kubun"><?php echo $attendance_kubun_name; ?></span>
            </div>
            <div id="attendance-memo-wrapper">
                <input type="text" id="attendance-memo" class="form-control" name="memo" maxlength="40" placeholder="備考を入力してください。" value="<?php echo $memo; ?>"></input>
            </div>
            <div class="clearfix">
                <button type="submit" id="btn-regist" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-placement="top" title="登録"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
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
