/*
 * connectyee.dashboard.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
 */
$(function() {
    'use strict';

    /*
     * init select user
     */
    $('#select-target-users').multiselect({
        maxHeight: 200,
        checkboxName: 'target_user',
        buttonClass: 'select-target-users btn btn-success',
        buttonTitle: function(options, select) {
            var labels = [];
            options.each(function() {
                if ($(this).attr('label') !== undefined) {
                    labels.push($(this).attr('label'));
                } else {
                    labels.push($(this).html());
                }
            });
            $('#label-target-user').text(labels.join('; '));

            return '対象者';
        },
        buttonText: function(options, select) {
            return '対象者';
        },
        enableFiltering: true,
        filterPlaceholder: '検索'
    });

    /*
     * init select attendance kubun
     */
    $('#select-attendance-kubun').multiselect({
        checkboxName: 'attendance_kubun',
        buttonClass: 'select-attendance-kubun btn btn-success',
        buttonTitle: function(options, select) {
            var labels = [];
            options.each(function() {
                if ($(this).attr('label') !== undefined) {
                    labels.push($(this).attr('label'));
                } else {
                    labels.push($(this).html());
                }
            });
            $('#label-attendance-kubun').text(labels.join('; '));

            return '勤怠予定';
        },
        buttonText: function(options, select) {
            return '勤怠予定';
        },
    });

    /*
     * init select date
     */
    $('#target-date-button').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        todayBtn: true,
        todayHighlight: true,
        autoclose: true
    });

    var NowDate = new Date();
    $('#target-date-button').datepicker('update', new Date(NowDate.getFullYear(), NowDate.getMonth(), NowDate.getDate()));
    changeSelectDate(new Date($('#target-date-button').datepicker('getDate')));

    /*
     * Datepicker changeDate
     */
    $('#target-date-button').on('changeDate', function() {
        changeSelectDate(new Date($('#target-date-button').datepicker('getDate')));
    });

    /*
     * select date button click
     */
    $('#target-date-button').on('click', function() {
        $('#target-date-button').datepicker('show');
    });

    $('#btn-regist').on('click', function() {
        var error = false;
        $('.modal-body').empty();
        if (Number($('#select-target-users').val()) === 0) {
            $('.modal-body').append($('<h6 id="modal-body-text">「対象者」を選択してください。</h6>'));
            error = true;
        }
        if (Number($('#select-attendance-kubun').val()) === 0) {
            $('.modal-body').append($('<h6 id="modal-body-text">「勤怠予定」を選択してください。</h6>'));
            error = true;
        }

        if (error === true) {
            $('#alertModal').modal();
            return false;
        }
    });

    /*
     * changeSelectDate
     */
    function changeSelectDate(SelDate) {
        var selYear = ('0000' + eval(SelDate.getFullYear())).substr(-4);
        var selMonth = ('00' + eval(SelDate.getMonth() + 1)).substr(-2);
        var selDay = ('00' + eval(SelDate.getDate())).substr(-2);

        var orgYear = $('#target-date-button').text().substr(0, 4);
        var orgMonth = $('#target-date-button').text().substr(6, 2);
        var orgDay = $('#target-date-button').text().substr(-2);

        if ((parseInt(selYear, 10) === parseInt(orgYear, 10)) &&
            (parseInt(selMonth, 10) === parseInt(orgMonth, 10)) &&
            (parseInt(selDay, 10) === parseInt(orgDay, 10))) {
            return;
        }

        $('#label-target-date').text(selYear + '/' + selMonth + '/' + selDay);
        $('#target-date').val($('#label-target-date').text());
    }
});
