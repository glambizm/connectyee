<?php
/*
 * OrgAttendance.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgAttendance {
    private $Attendance;
    private $id;
    private $UserList;
    private $TargetUser;
    private $TargetDate;
    private $attendanceKubun;
    private $memo;
    private $RegistrationUser;
    private $RegistrationDate;

    function __construct($attendanceInfo = null) {
        $this->id               = -1;
        $this->UserList         = unserialize(CakeSession::read('user_list'));
        $this->TargetUser       = null;
        $this->TargetDate       = null;
        $this->attendanceKubun  = -1;
        $this->memo             = '';
        $this->RegistrationUser = null;
        $this->RegistrationDate = null;

        $this->Attendance = ClassRegistry::init('Attendance');

        if ($this->checkProperty() === false) {
            return;
        }

        if ($attendanceInfo !== null) {
            $this->id               = $attendanceInfo['Attendance']['id'];
            $this->TargetDate       = new DateTime($attendanceInfo['Attendance']['target_date']);
            $this->attendanceKubun  = $attendanceInfo['Attendance']['attendance_kubun'];
            $this->memo             = $attendanceInfo['Attendance']['memo'];
            $this->RegistrationDate = new DateTime($attendanceInfo['Attendance']['registration_date']);
        } else {
            return;
        }

        $result = array();
        $result = $this->UserList->getUserList($attendanceInfo['Attendance']['target_user']);
        $this->TargetUser = $result[0];

        $result = array();
        $result = $this->UserList->getUserList($attendanceInfo['Attendance']['registration_user']);
        $this->RegistrationUser = $result[0];
    }

    public function init($id) {
        if ($this->checkProperty() === false) {
            return;
        }

        $SQLPara['conditions'] = array('Attendance.id'=>$id);

        try {
            $result = $this->Attendance->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        if (count($result) > 0) {
            $this->id = $id;
            $this->TargetDate = new DateTime($result[0]['Attendance']['target_date']);
            $this->attendanceKubun = $result[0]['Attendance']['attendance_kubun'];
            $this->memo = $result[0]['Attendance']['memo'];
            $this->RegistrationDate = new DateTime($result[0]['Attendance']['registration_date']);

            $retUser = array();
            $retUser = $this->UserList->getUserList($result[0]['Attendance']['target_user']);
            $this->TargetUser = $retUser[0];

            $retUser = array();
            $retUser = $this->UserList->getUserList($result[0]['Attendance']['registration_user']);
            $this->RegistrationUser = $retUser[0];
        }
    }

    public function checkUser($userId) {
        if ($this->RegistrationUser->getUserId() === $userId) {
            return true;
        }

        return false;
    }

    public function getId() {
        return intval($this->id);
    }

    public function getTargetUser() {
        return $this->TargetUser;
    }

    public function getTargetDate() {
        return $this->TargetDate;
    }

    public function getAttendanceKubun() {
        return intval($this->attendanceKubun);
    }

    public function getAttendanceKubunName() {
        switch ($this->attendanceKubun) {
            case 1:
                return '休み';
            case 2:
                return '現場出社';
            case 3:
                return '午前休';
            case 4:
                return '午後休';
            case 5:
                return '遅刻';
            case 6:
                return '早退';
            case 7:
                return 'その他';
            default:
                return '';
        }
    }

    public function getMemo($escape = false) {
        if ($escape === true) {
            $result = htmlentities($this->memo, ENT_QUOTES, 'utf-8');
            $result = nl2br($result);
            return $result;
        } else {
            return $this->memo;
        }
    }

    public function getRegistrationUser() {
        return $this->RegistrationUser;
    }

    public function getRegistrationDate() {
        return $this->RegistrationDate;
    }

    public function setTargetUser($id) {
        $result = $this->UserList->getUserList($id);
        $this->TargetUser = $result[0];
    }

    public function setTargetDate($date) {
        $this->TargetDate = new DateTime($date);
    }

    public function setAttendanceKubun($kubun) {
        $this->attendanceKubun = $kubun;
    }

    public function setMemo($memo) {
        $this->memo = $memo;
    }

    public function setRegistrationUser($id) {
        $result = $this->UserList->getUserList($id);
        $this->RegistrationUser = $result[0];
    }

    public function registAttendance() {
        if (($this->TargetUser->isExist() === false) ||
            ($this->RegistrationUser->isExist() === false) ||
            ($this->TargetDate === null) ||
            ($this->attendanceKubun === -1)) {
            return;
        }

        $fields = array('target_user', 'target_date', 'attendance_kubun', 'memo', 'registration_user', 'regstration_date');
        $data = array('Attendance'=>array(  'target_user'=>$this->TargetUser->getUserId(),
                                            'target_date'=>$this->TargetDate->format('Y-m-d'),
                                            'attendance_kubun'=>$this->attendanceKubun,
                                            'memo'=>$this->memo,
                                            'registration_user'=>$this->RegistrationUser->getUserId(),
                                            'regstration_date'=>DboSource::expression('NOW()')
                                            ));
        if ($this->Attendance->validates($data) === true) {
            if ($this->id === -1) {
                $this->Attendance->create();
            } else {
                $this->Attendance->id = $this->id;
            }

            try {
                $this->Attendance->save($data, false, $fields);
            } catch (PDOException $e) {
                Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            } catch (Exception $e) {
                Debugger::log($e->getMessage(), LOG_DEBUG);
            }
        } else {
            Debugger::log(var_export($this->Attendance->validationErrors, true), LOG_DEBUG);
        }
    }

    public function deleteAttendance() {
        if ($this->id !== -1) {
            $this->Attendance->delete($this->id);
        }
    }

    public function isExist() {
        if ($this->id > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function checkProperty() {
        if (($this->Attendance instanceof Attendance) === false) {
            return false;
        }
        return true;
    }
}
?>