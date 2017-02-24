<?php

/*
 * DashBoardsController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppController', 'Controller');

class DashBoardsController extends AppController {
    public $uses = array('User', 'Post', 'Schedule', 'WebMail', 'ReceivingUser');
    private $PostList;
    private $ScheduleList;
    private $ReceivingMailList;
    private $AttendanceList;
    private $Calendar;
    private $loginMsg;

    public function index() {
        $where  = null;
        $order = 'Post.post_date DESC';
        $count = 5;
        $this->PostList = new OrgPostList($where, $order, $count);
        $this->set('PostList', $this->PostList->Items);

        $where  = array('ReceivingUser.delete_kubun' => '0');
        $order = 'WebMail.sending_time DESC';
        $count = 5;
        $this->ReceivingMailList = new OrgReceivingMailList($this->LoginUser->getUserId(), $where, $order, $count);

        $this->set('MailList', $this->ReceivingMailList->Items);
    }

    public function login() {
        $this->layout = "";
        $this->set('loginMsg', '');
        $this->set('input_account', '');

        $this->LoginUser = new OrgUser();

        if ($this->request->is('post') === false) {
            return;
        }

        $this->set('input_account', $this->request->data['account']);

        if (($this->request->data['account'] === '') && ($this->request->data['password'] === '')) {
            $this->set('loginMsg', 'アカウント、および、パスワードを入力してください。');
            return;
        } else if ($this->request->data['account'] === '') {
            $this->set('loginMsg', 'アカウントを入力してください。');
            return;
        } else if ($this->request->data['password'] === '') {
            $this->set('loginMsg', 'パスワードを入力してください。');
            return;
        }

        $this->LoginUser->login($this->request->data['account'], $this->request->data['password']);

        if ($this->LoginUser->isExist() === false) {
            $this->set('loginMsg', 'アカウント、または、パスワードが間違っています。');
            return;
        }

        $this->redirect(array('controller'=>'DashBoards', 'action'=>'index'));
    }

    public function getAttendance() {
        if ($this->request->is('ajax') === true) {
            $this->autoRender = false;

            $TargetDate = new DateTime($this->request->data['target_date']);

            $where = array('Attendance.target_date' => $TargetDate->format('Y/m/d'));
            $order = '';
            $count = 0;

            $this->AttendanceList = new OrgAttendanceList($where, $order, $count);

            $Result = $this->AttendanceList->getLatestItems();

            $ReturnJson = array();
            foreach ($Result as $val) {
                $attendanceInfo = array();
                $attendanceInfo['TargetUserId']       = $val->getTargetUser()->getUserId();
                $attendanceInfo['TargetUser']         = $val->getTargetUser()->getFullName(true);
                $attendanceInfo['attendanceKubun']    = $val->getAttendanceKubunName();
                $attendanceInfo['memo']               = $val->getMemo();
                $attendanceInfo['RegistrationUser']   = $val->getRegistrationUser()->getFullName(true);

                if ($val->getRegistrationDate() instanceof DateTime) {
                    $attendanceInfo['RegistrationDate'] = $val->getRegistrationDate()->format('m/d G:i');
                } else {
                    $attendanceInfo['RegistrationDate'] = '';
                }

                $ReturnJson[] = $attendanceInfo;
            }

            return new CakeResponse(array('type' => 'json', 'body' => json_encode($ReturnJson)));
        }
    }

    public function getDateInfo() {
        if ($this->request->is('ajax') === true) {
            $this->autoRender = false;

            $TargetDate = explode('/' ,$this->request->data['target_date']);
            $startDate = new DateTime($this->request->data['target_date'] . '/1');
            $endDate = new DateTime('last day of ' . $TargetDate[0] . '-' . $TargetDate[1]);

            $this->Calendar = new OrgCalendar($startDate, $endDate);

            $ReturnJson = array();
            foreach ($this->Calendar->getCalendarItems() as $value) {
                $dateInfo = array();
                $dateInfo['dateKubun'] = $value->getDateKubun();
                $dateInfo['dateName'] = $value->getDateName(true);

                $ReturnJson[] = $dateInfo;
            }

            return new CakeResponse(array('type' => 'json', 'body' => json_encode($ReturnJson)));
        }
    }
}

?>