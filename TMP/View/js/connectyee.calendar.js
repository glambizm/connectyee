/*
 * connectyee.dashboard.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
 */
$(function() {
    'use strict';

    /*
     * Calendar init
     */
    $('#display-year-month').datepicker({
        format: 'yyyy/mm',
        language: 'ja',
        todayBtn: true,
        todayHighlight: true,
        autoclose: true
    });
    $('#select-target-date').datepicker({
        format: 'yyyy/mm',
        language: 'ja',
        todayBtn: true,
        todayHighlight: true,
        autoclose: true
    });
    changeCalendar(new Date(), true, false);

    /*
     * Datepicker changeDate
     */
    $('#display-year-month').on('changeDate', function() {
        changeCalendar(new Date($('#display-year-month').datepicker('getDate')));
    });

    $('#select-target-date').on('changeDate', function() {
        changeCalendar(new Date($('#select-target-date').datepicker('getDate')));
    });

    /*
     * Calendar MoveButton click
     */
    $('#btn-prev-month, #btn-next-month').on('click', function() {
        var selYear = parseInt($('#display-year-month').text().substr(0, 4), 10);
        var selMonth = parseInt($('#display-year-month').text().substr(-2), 10) - 1;

        if ($(this).attr('id') === 'btn-prev-month') {
            selMonth--;
        } else {
            selMonth++;
        }

        changeCalendar(new Date(selYear, selMonth, 1));
    });

    /*
     * td click
     */
    $(document).on('click', '#calendar-body td', function() {
        if ($(this).text() === '') return;

        var selYear = parseInt($('#display-year-month').text().substr(0, 4), 10);
        var selMonth = parseInt($('#display-year-month').text().substr(-2), 10) - 1;
        var selDay = parseInt($(this).text(), 10);
        changeCalendar(new Date(selYear, selMonth, selDay), false);
    });

    /*
     * changeCalendar
     */
   /*
     * changeCalendar
     */
    function changeCalendar(selDate, remake, animate_loading) {
        remake = remake === undefined ? true : remake;
        animate_loading = animate_loading === undefined ? true : animate_loading;

        var orgYear = parseInt($('#display-year-month').text().substr(0, 4), 10);
        var orgMonth = $('#display-year-month').text().substr(-2);
        var orgDay = parseInt($('#cal_selected_day').text(), 10);

        var selYear = parseInt(selDate.getFullYear(), 10);
        var selMonth = ('00' + eval(selDate.getMonth() + 1)).substr(-2);
        var selDay = parseInt(selDate.getDate(), 10);

        if ((orgYear === selYear) && (orgMonth === selMonth) && (orgDay === selDay)) {
            return;
        }

        if (animate_loading === true) {
            $('div#date-info-wrapper').block({
                message: '<img src="./img/common.loading.gif">',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.6
                }
            });
        } else {
            $('div#date-info-wrapper').block({
                message: '',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.6
                }
            });
        }

        $('.blockElement').css('border', '').css('background-color', '');

        var nowDate = new Date();
        var nowYear = nowDate.getFullYear();
        var nowMonth = ('00' + eval(nowDate.getMonth() + 1)).substr(-2);
        var nowDay = parseInt(nowDate.getDate(), 10);

        $('#display-year-month').text(selYear + '/' + selMonth).datepicker('update', new Date(selYear, selMonth - 1, selDay));
        $('#select-target-date').text(selYear + '/' + selMonth + '/' + ('00' + selDay).substr(-2)).datepicker('update', new Date(selYear, selMonth - 1, selDay));;

        if (remake === true) {
            $('#calendar-body table').calendarmaker(selDate);
        }

        // selected day
        $('#cal_selected_day').removeAttr('id');
        var selected = getTargetDateElement(selDay);
        if (selected !== null) {
            selected.attr('id', 'cal_selected_day');
        }

        // today
        $('#cal_today').removeAttr('id');
        if ((nowYear === selYear) && (nowMonth === selMonth) && (parseInt(selected.text(), 10) !== nowDay)) {
            var today = getTargetDateElement(nowDay);
            if (today !== null) {
                today.attr('id', 'cal_today');
            }
        }

        if (remake === true) {
            var ajaxParam = {
                url: location.href + '/displayCalendar',
                dataType: 'json',
                type: 'POST',
                data: { target_date: selYear + '/' + selMonth + '/' + ('00' + selDay).substr(-2) }
            };

            $.ajax(ajaxParam)
                .done(function(result) {
                    $('.cal_named_day').removeClass('cal_named_day');
                    $.each(result, function(i, val) {
                        var TargetObj = getTargetDateElement(i);
                        if (TargetObj === null) {
                            return true;
                        }

                        TargetObj.attr('data-day-kubun', '0');
                        TargetObj.attr('data-day-name', '');

                        if ((parseInt(val.dateKubun, 10) === 0) && (val.dateName === '')) {
                            return true;
                        }

                        TargetObj.addClass('cal_named_day');
                        TargetObj.attr('data-day-kubun', val.dateKubun);
                        TargetObj.attr('data-day-name', val.dateName);

                        var CalDayKbnObj = null;
                        if (parseInt(val.dateKubun, 10) === 1) {
                            TargetObj.attr('data-day-name', '出社日');
                            CalDayKbnObj = $('<p>').text('出社日');
                            TargetObj.append(CalDayKbnObj);
                        } else if (parseInt(val.dateKubun, 10) === 2) {
                            TargetObj.attr('data-day-name', 'その他');
                            CalDayKbnObj = $('<p>').text('その他');
                            TargetObj.append(CalDayKbnObj);
                        }
                    });
                })
                .always(function() {
                    $('#select-date-kubun').val($('#cal_selected_day').attr('data-day-kubun'));
                    $('#input-date-name').val($('#cal_selected_day').attr('data-day-name'));
                    $('div#date-info-wrapper').unblock();
                });
        } else {
            $('#select-date-kubun').val($('#cal_selected_day').attr('data-day-kubun'));
            $('#input-date-name').val($('#cal_selected_day').attr('data-day-name'));
            $('div#date-info-wrapper').unblock();
        }
    }

    /*
     * getTargetDateElement
     */
    function getTargetDateElement(day) {
        day = parseInt(day, 10);
        var returnObj = null;
        $('#calendar-body td').each(function(index, domEle) {
            if (parseInt($(this).text(), 10) === day) {
                returnObj = $(this);
                return;
            }
        });
        return returnObj;
    }
});
