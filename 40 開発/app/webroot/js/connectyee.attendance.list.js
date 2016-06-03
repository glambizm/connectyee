/*
 * connectyee.dashboard.js
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

        var ajaxParam = {
            url: location.href + '/displayAttendanceList',
            type: 'POST',
            data: {target_date: selYear + '/' + selMonth + '/' + selDay}
        };

        ajaxProc(ajaxParam)
            .done(function(result) {
                if ($.isPlainObject(result) === false) {
                    return ture;
                }

                var prevUserId = -1;
                var attendance_list_wrapper = [];
                var j = -1;
                for (var i=0; i<result.AttendanceList.length(); i++) {
                    if ($.isPlainObject(result.AttendanceList[i]) === false) {
                        return true;
                    }

                    if (prevUserId !== result.AttendanceList[i].TargetUserId) {
                        prevUserId = result.AttendanceList[i].TargetUserId;
                        if (j >= 0) {
                            $('#attendance-wrapper').append(attendance_list_wrapper[j]);
                        }
                        j++;
                        attendance_list_wrapper.push($('<div></div>', {'class': 'attendance-list-wrapper panel panel-default'}));
                        attendance_list_wrapper[j].append($('<div></div>', {'class': 'list-group'}))
                                                  .append($('<div></div>', {'class': 'container-fluid'}));
                        $('<div></div>', {'class': 'attendance-list-header list-group-item row'})
                            .text(result.AttendanceList[i].TargetUser).appendTo(attendance_list_wrapper[j]);
                    }

                    var attendance_list_body = $('<div></div>', {'class': 'attendance-list-body list-group-item row'})
                        .appendTo(attendance_list_wrapper[j]);

                    var attendance_kubun = $('<div></div>', {'class': 'attendance-kubun col-sm-2 col-xs-5'})
                        .text(result.AttendanceList[i].attendanceKubun).appendTo(attendance_list_body);

                    if (result.AttendanceList[i].RegistrationUserId === result.LoginUser) {
                        var hrefStr = location.href;
                            hrefStr = hrefStr.splite('/');
                            hrefStr = hrefStr.pop();
                            hrefStr = hrefStr.join('/') + 'editAttendance' + '/' + result.AttendanceList[i].id;
                        $('<a></a>', {'class': 'attendance-edit-button btn btn-success glyphicon glyphicon-edit',
                                      'data-toggle': 'tooltip',
                                      'data-container': 'body',
                                      'data-placement': 'top',
                                      'title': '編集',
                                      'href': hrefStr}).appendTo(attendanceKubun);
                    }

                    $('<div></div>', {'class': 'attendance-memo col-sm-6 col-xs-7'})
                        .text(result.AttendanceList[i].memo).appendTo(attendance_list_body);
                    $('<div></div>', {'class': 'attendance-registration-user col-sm-2 col-xs-7'})
                        .text(result.AttendanceList[i].RegistrationUserName).appendTo(attendance_list_body);
                    $('<div></div>', {'class': 'attendance-registration-date col-sm-2 col-xs-5'})
                        .text(result.AttendanceList[i].RegistrationDate).appendTo(attendance_list_body);
                }
            })
            .always(function() {
                $('div#attendance-wrapper').unblock();
            });
    }
});
