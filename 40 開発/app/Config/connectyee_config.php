<?php
    $config['SecurityKey'] = '9SQHlWZM6hhihq8uQIwJ6is4E0rj9otz';

    $config['menu-info'] = array(
        0=>array(   'display'=>true,
                    'name'=>'DashBoards',
                    'title'=>'ダッシュボード',
                    'sub-title'=>'DashBoard',
                    'authority'=>'0',
                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-home" aria-hidden="true"></span>',
                    'href'=>Router::url(array('controller'=>'DashBoards', 'action'=>'index')),
                    'menu-parent'=>-1,
                    'child'=>null),
        1=>array(   'display'=>true,
                    'name'=>'WebMails',
                    'title'=>'Ｗｅｂメール',
                    'sub-title'=>'WebMail',
                    'authority'=>'0',
                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-envelope" aria-hidden="true"></span>',
                    'href'=>'',
                    'menu-parent'=>1,
                    'child'=> array(
                        0=>array(   'display'=>true,
                                    'name'=>'NewMail',
                                    'title'=>'メール作成',
                                    'sub-title'=>'NewMail',
                                    'authority'=>'0',
                                    'icon'=>'<span class="[icon-class] icon-email-edit" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'WebMails', 'action'=>'makeNewMail')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        ),
                        1=>array(   'display'=>true,
                                    'name'=>'ReceivingMails',
                                    'title'=>'受信メール',
                                    'sub-title'=>'ReceivingMails',
                                    'authority'=>'0',
                                    'icon'=>'<span class="[icon-class] icon-email-inbox" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'WebMails', 'action'=>'displayReceivingMailList')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        ),
                        2=>array(   'display'=>true,
                                    'name'=>'SendingMails',
                                    'title'=>'送信メール',
                                    'sub-title'=>'SendingMails',
                                    'authority'=>'0',
                                    'icon'=>'<span class="[icon-class] icon-email-outbox" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'WebMails', 'action'=>'displaySendingMailList')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        ),
                        3=>array(   'display'=>false,
                                    'name'=>'',
                                    'title'=>'',
                                    'sub-title'=>'ReceivingMail',
                                    'authority'=>'0',
                                    'icon'=>'<span class="[icon-class] glyphicon icon-email-inbox" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'WebMails', 'action'=>'displayReceivingMail')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        ),
                        4=>array(   'display'=>false,
                                    'name'=>'',
                                    'title'=>'',
                                    'sub-title'=>'SendingMail',
                                    'authority'=>'0',
                                    'icon'=>'<span class="[icon-class] glyphicon icon-email-outbox" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'WebMails', 'action'=>'displaySendingMail')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        )
                    )),
        2=>array(   'display'=>true,
                    'name'=>'Schedules',
                    'title'=>'スケジュール',
                    'sub-title'=>'Schedule',
                    'authority'=>'0',
                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-time" aria-hidden="true"></span>',
//                  'href'=>Router::url(array('controller'=>'Schedules', 'action'=>'index')),
                    'href'=>'',
                    'menu-parent'=>-1,
                    'child'=>null),
        3=>array(   'display'=>true,
                    'name'=>'Posts',
                    'title'=>'掲示板',
                    'sub-title'=>'BBS',
                    'authority'=>'0',
                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-list-alt" aria-hidden="true"></span>',
//                  'href'=>Router::url(array('controller'=>'Posts', 'action'=>'index')),
                    'href'=>'',
                    'menu-parent'=>-1,
                    'child'=>null),
        4=>array(   'display'=>true,
                    'name'=>'Attendances',
                    'title'=>'勤怠予定',
                    'sub-title'=>'Attendance',
                    'authority'=>'1',
                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-calendar" aria-hidden="true"></span>',
                    'href'=>'',
                    'menu-parent'=>2,
                    'child'=> array(
                        0=>array(   'display'=>true,
                                    'name'=>'AttendanceList',
                                    'title'=>'勤怠予定一覧',
                                    'sub-title'=>'AttendanceList',
                                    'authority'=>'1',
                                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-list" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'Attendances', 'action'=>'displayAttendanceList')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        ),
                        1=>array(   'display'=>true,
                                    'name'=>'RegistAttendance',
                                    'title'=>'勤怠予定登録',
                                    'sub-title'=>'RegistAttendance',
                                    'authority'=>'1',
                                    'icon'=>'<span class="[icon-class] icon-interface" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'Attendances', 'action'=>'registAttendance')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        )
                    )),
        5=>array(   'display'=>true,
                    'name'=>'Users',
                    'title'=>'ユーザー情報',
                    'authority'=>'0',
                    'sub-title'=>'UserProfile',
                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-user" aria-hidden="true"></span>',
                    'href'=>Router::url(array('controller'=>'Users', 'action'=>'changeUserProfile')),
                    'href'=>'',
                    'menu-parent'=>-1,
                    'child'=>null),
        6=>array(   'display'=>true,
                    'name'=>'Administrations',
                    'title'=>'管理',
                    'sub-title'=>'Administration',
                    'authority'=>'1',
                    'icon'=>'<span class="[icon-class] glyphicon glyphicon-wrench" aria-hidden="true"></span>',
                    'href'=>'',
                    'menu-parent'=>3,
                    'child'=> array(
                        0=>array(   'display'=>true,
                                    'name'=>'Users',
                                    'title'=>'ユーザー管理',
                                    'sub-title'=>'AdministrateUser',
                                    'authority'=>'1',
                                    'icon'=>'<span class="[icon-class] icon-social-1" aria-hidden="true"></span>',
                                    'href'=>Router::url(array('controller'=>'Users', 'action'=>'displayUserList')),
                                    'menu-parent'=>-1,
                                    'child'=>null
                        )
                    ))
    );

    $config['initial_color'] = array(
        'A'=>' initial color-a',
        'B'=>' initial color-b',
        'C'=>' initial color-c',
        'D'=>' initial color-d',
        'E'=>' initial color-e',
        'F'=>' initial color-f',
        'G'=>' initial color-g',
        'H'=>' initial color-h',
        'I'=>' initial color-i',
        'J'=>' initial color-j',
        'K'=>' initial color-k',
        'L'=>' initial color-l',
        'M'=>' initial color-m',
        'N'=>' initial color-n',
        'O'=>' initial color-o',
        'P'=>' initial color-p',
        'Q'=>' initial color-q',
        'R'=>' initial color-r',
        'S'=>' initial color-s',
        'T'=>' initial color-t',
        'U'=>' initial color-u',
        'V'=>' initial color-v',
        'W'=>' initial color-w',
        'X'=>' initial color-x',
        'Y'=>' initial color-y',
        'Z'=>' initial color-z',
        '?'=>' initial color-a'
    );
?>
