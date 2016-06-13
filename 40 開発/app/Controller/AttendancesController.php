<?php
/*
 * AttendancesController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

App::uses('AppController', 'Controller');

class AttendancesController extends AppController {
    private $AttendancelList;

    public function beforeFilter() {
        parent::beforeFilter();

        if (($this->action !== 'editAttendance') &&
            ($this->action !== 'deleteAttendance')) {
            return;
        }

        $Attendance = new OrgAttendance();
        $attendance_id = $this->params['pass'][0];
        $Attendance->init($attendance_id);

        if ($Attendance->isExist() === false) {
            $this->redirect(array('controller'=>'Attendances', 'action'=>'displayAttendanceList'));
        }

        if ($Attendance->checkUser($this->LoginUser->getUserId()) === false) {
            $this->redirect(array('controller'=>'Attendances', 'action'=>'displayAttendanceList'));
        }
    }

    public function displayAttendanceList() {
        if ($this->request->is('ajax') === true) {
            $this->autoRender = false;

            $TargetDate = new DateTime($this->request->data['target_date']);

            $where = array('Attendance.target_date' => $TargetDate->format('Y/m/d'));
            $order = '';
            $count = 0;

            $this->AttendanceList = new OrgAttendanceList($where, $order, $count);

            $Result = $this->AttendanceList->getAllItems();

            $ReturnJson = array();
            $ReturnJson['AttendanceList'] = array();
            foreach ($Result as $val) {
                $attendanceInfo = array();
                $attendanceInfo['id']                 = $val->getId();
                $attendanceInfo['TargetUserId']       = $val->getTargetUser()->getUserId();
                $attendanceInfo['TargetUser']         = $val->getTargetUser()->getFullName(true);
                $attendanceInfo['attendanceKubun']    = $val->getAttendanceKubunName();
                $attendanceInfo['memo']               = $val->getMemo();
                $attendanceInfo['RegistrationUserId']   = $val->getRegistrationUser()->getUserId();
                $attendanceInfo['RegistrationUserName']   = $val->getRegistrationUser()->getFullName(true);
                if ($val->getRegistrationDate() instanceof DateTime) {
                    $attendanceInfo['RegistrationDate'] = $val->getRegistrationDate()->format('m/d G:i');
                } else {
                    $attendanceInfo['RegistrationDate'] = '';
                }

                $ReturnJson['AttendanceList'][] = $attendanceInfo;
            }
            $ReturnJson['LoginUser'] = $this->LoginUser->getUserId();

            return new CakeResponse(array('type' => 'json', 'body' => json_encode($ReturnJson)));
        }
    }

    public function registAttendance() {
        if ($this->request->is('post') === false) {
            $Attendance = new OrgAttendance();
            $this->set('Attendance', $Attendance);
        } else {
            if ((isset($this->request->data['target_user']) === false) ||
                (isset($this->request->data['attendance_kubun']) === false)) {
                $this->redirect(array('controller'=>'Attendances', 'action'=>'displayAttendanceList'));
            }

            $Attendance = new OrgAttendance();
            $Attendance->init($this->request->data['attendance_id']);
            $Attendance->setTargetDate($this->request->data['target_date']);
            $Attendance->setTargetUser($this->request->data['target_user']);
            $Attendance->setAttendanceKubun($this->request->data['attendance_kubun']);
            $Attendance->setMemo($this->request->data['memo']);
            $Attendance->setRegistrationUser($this->LoginUser->getUserId());
            $Attendance->registAttendance();

            $this->redirect(array('controller'=>'Attendances', 'action'=>'displayAttendanceList'));
        }
    }

    public function editAttendance($id) {
        $Attendance = new OrgAttendance();
        $Attendance->init($id);

        $this->set('Attendance', $Attendance);

        $this->render('registAttendance');
    }

    public function deleteAttendance($id) {
        $Attendance = new OrgAttendance();
        $Attendance->init($id);
        $Attendance->deleteAttendance();
        $this->redirect(array('controller'=>'Attendances', 'action'=>'displayAttendanceList'));
    }
}
?>