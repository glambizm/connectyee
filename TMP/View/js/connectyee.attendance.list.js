/*
 * connectyee.attendance.list.js
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
 */
$(function() {
    'use strict';

    $('#select-date-label').datepicker({
        format: 'yyyy/mm/dd',
        language: 'ja',
        todayBtn: true,
        todayHighlight: true,
        autoclose: true
    });

    var NowDate = new Date();
    $('#select-date-label').datepicker('update', new Date(NowDate.getFullYear(), NowDate.getMonth(), NowDate.getDate()));
    changeSelectDate(new Date($('#select-date-label').datepicker('getDate')));

    /*
     * Datepicker changeDate
     */
    $('#select-date-label').on('changeDate', function() {
        changeSelectDate(new Date($('#select-date-label').datepicker('getDate')));
    });

    /*
     * Select Date Button click
     */
    $('#select-date-button').on('click', function(){
        $('#select-date-label').datepicker('show');
    });

    /*
     * changeSelectDate
     */
     function changeSelectDate(SelDate) {
        $('div#attendance-wrapper').block({
            message: '<img src="./img/common.loading.gif">',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.6
            }
        });
        $('.blockElement').css('border', '').css('background-color', '');

        var selYear = ('0000' + eval(SelDate.getFullYear())).substr(-4);
        var selMonth = ('00' + eval(SelDate.getMonth() + 1)).substr(-2);
        var selDay = ('00' + eval(SelDate.getDate())).substr(-2);

        var orgYear = $('#select-date-label').text().substr(0, 4);
        var orgMonth = $('#select-date-label').text().substr(6, 2);
        var orgDay = $('#select-date-label').text().substr(-2);

        if ((parseInt(selYear ,10) === parseInt(orgYear ,10)) &&
            (parseInt(selMonth ,10) === parseInt(orgMonth ,10)) &&
            (parseInt(selDay ,10) === parseInt(orgDay ,10))) {
            return;
        }

        $('#select-date-label').text(selYear + '/' + selMonth + '/' + selDay);

        $('div#attendance-wrapper').unblock();
    }
});
