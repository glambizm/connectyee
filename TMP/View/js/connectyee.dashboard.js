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
    changeCalendar(new Date(), true, false);

    /*
     * Datepicker changeDate
     */
    $('#display-year-month').on('changeDate', function() {
        changeCalendar(new Date($('#display-year-month').datepicker('getDate')));
    });

    /*
     * Calendar MoveButton Click
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
        if (typeof parseInt($(this).text(), 10) === 'number') {
            var selYear = parseInt($('#display-year-month').text().substr(0, 4), 10);
            var selMonth = parseInt($('#display-year-month').text().substr(-2), 10) - 1;
            var selDay = parseInt($(this).text(), 10);
            changeCalendar(new Date(selYear, selMonth, selDay), false);
        }
    });

    /*
     * changeCalendar
     */
    function changeCalendar(selDate, remake, loading) {
        remake = remake === undefined ? true : remake;
        loading = loading === undefined ? true : loading;

        if (loading === true) {
            $('div#date-info-wrapper').block({
                message: '<img src="./img/dashboard.date-info-loading.gif">',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.6
                }
            });
            $('.blockElement').css('border', '').css('background-color', '');
        }

        var orgYear = parseInt($('#display-year-month').text().substr(0, 4), 10);
        var orgMonth = $('#display-year-month').text().substr(-2);
        var orgDay = parseInt($('#cal_selected_day').text(), 10);

        var selYear = parseInt(selDate.getFullYear(), 10);
        var selMonth = ('00' + eval(selDate.getMonth() + 1)).substr(-2);
        var selDay = parseInt(selDate.getDate(), 10);

        if ((orgYear === selYear) && (orgMonth === selMonth) && (orgDay === selDay)) {
            return;
        }

        var nowDate = new Date();
        var nowYear = nowDate.getFullYear();
        var nowMonth = ('00' + eval(nowDate.getMonth() + 1)).substr(-2);
        var nowDay = parseInt(nowDate.getDate(), 10);

        $('#display-year-month').text(selYear + '/' + selMonth).datepicker('update', new Date(selYear, selMonth - 1, selDay));

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

        if (loading === true) {
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