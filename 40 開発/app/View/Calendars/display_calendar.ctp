<?php
$this->extend('/Common/common');
$this->Html->css('connectyee.calendar.css', array('inline' => false));
$this->Html->script('connectyee.calendar.js', array('inline'=>false));
?>

<div id="page-content-wrapper" class="calendar-wrapper">
    <div class="container calendar-container">
        <div id="calendar-wrapper" class="row panel panel-default">
            <div id="calendar-header" class="clearfix">
                <span id="btn-prev-month" class="glyphicon icon-circle-left" aria-hidden="true"></span>
                <span id="display-year-month"></span>
                <span id="btn-next-month" class="glyphicon icon-circle-right" aria-hidden="true"></span>
            </div>
            <div id="calendar-body">
                <table></table>
            </div>
        </div>
        <div id="calendar-edit-wrapper" class="row panel panel-default">
            <div id="target-date-wrapper" class="calendar-edit-parts-wrapper">
                <span class="label-input-header">日　　付</span>
                <span id="select-target-date"></span>
            </div>
            <div id="date-kubun-wrapper" class="calendar-edit-parts-wrapper">
                <span class="label-input-header">日付区分</span>
                <select id="select-date-kubun" class="form-control" name="date_kubun">
                    <option value="0" selected="selected">　</option>
                    <option value="1">出社日</option>
                    <option value="2">その他</option>
                </select>
            </div>
            <div id="date-name-wrapper" class="calendar-edit-parts-wrapper calendar-parts-wrapper-last">
                <span class="label-input-header">日付名称</span>
                <input type="text" id="input-date-name" class="form-control" name="date_name" maxlength="10"></input>
            </div>
            <div id="btn-regist-wrapper" class="clearfix">
                <button id="btn-regist" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-placement="top" title="登録"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
            </div>
        </div>
    </div>
</div>
