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
                $ReturnJson['AttendanceList'][]['id']                 = $val->getId();
                $ReturnJson['AttendanceList'][]['TargetUserId']       = $val->TargetUser->getUserId();
                $ReturnJson['AttendanceList'][]['TargetUser']         = $val->TargetUser->getFullName(true);
                $ReturnJson['AttendanceList'][]['attendanceKubun']    = $val->getAttendanceKubunName();
                $ReturnJson['AttendanceList'][]['memo']               = $val->getMemo(true);
                $ReturnJson['AttendanceList'][]['RegistrationUserId']   = $val->getRegistrationUser()->getUserId();
                $ReturnJson['AttendanceList'][]['RegistrationUserName']   = $val->getRegistrationUser()->getFullName(true);
                if ($val->getRegistrationDate() instanceof DateTime) {
                    $ReturnJson['AttendanceList'][]['RegistrationDate'] = $val->getRegistrationDate()->format('m/d G:i');
                } else {
                    $ReturnJson['AttendanceList'][]['RegistrationDate'] = '';
                }
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