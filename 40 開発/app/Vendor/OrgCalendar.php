<?php
/*
 * OrgCalendar.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgCalendar {
    public $Items;
    private $Calendar;

    function __construct($startDate, $endDate) {
        $this->Calendar = ClassRegistry::init('Calendar');
        $this->Items = array();

        if (($this->Calendar instanceof Calendar) === false) {
            return;
        }

        if (($startDate === null) || ($endDate === null)) {
            return;
        }

        $dayCount = ($endDate - $startDate) / (60 * 60 * 24);

        for ($count=0; $count <= $dayCount; $count++) {
            $param = array();
            $param['Calendar']['calendar_date'] = strtotime($startDate->format('Y/m/d') . ' +' . $count .' day');
            $param['Calendar']['date_kubun']    = 0;
            $param['Calendar']['date_name']     = '';

            $this->Items[] = new OrgCalendarItem($param);
        }

        $SQLPara = array();
        $SQLPara['conditions'] = array( array('Calendar.calendar_date'=>'>='.$starDate->format('Y/m/d')),
                                        array('Calendar.calendar_date'=>'<='.$endDate->format('Y/m/d')));
        $SQLPara['order'] = 'Calendar.calendar_date';
        try {
            $result = $this->Calendar->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        foreach ($result as $val) {
            foreach($this->Items as $key=>$item) {
                if (strtotime($val['Calendar']['calendar_date']) === $item->getCalendarDate()) {
                    $this->Items[$key]->setDateKubun(intval($val['Calendar']['date_kubun']));
                    $this->Items[$key]->setDateName($val['Calendar']['date_name']);
                    break;
                }
            }
        }
    }

    public function getUserList($id) {
        $result = array();
        foreach ($id as $val) {
            foreach($this->Items as $User) {
                if (intval($val) === intval($User->getUserId())) {
                    $result[] = clone $User;
                    break;
                }
            }
        }

        if (count($result) === 0) {
            $result[] = new OrgUser();
            return $result;
        } else {
            usort($result, 'compareUser');
            return $result;
        }
    }

    public function getActiveUserList() {
        $result = array();
        foreach ($this->Items as $val) {
            if (intval($val->getDeleteKubun()) === 0) {
                $result[] = clone $val;
            }
        }

        if (count($result) === 0) {
            $result[] = new OrgUser();
            return $result;
        } else {
            usort($result, 'compareUser');
            return $result;
        }
    }

    public function isExistSameAccountUser($Target) {
        foreach($this->Items as $User) {
            if ((intval($Target->getUserId()) !== intval($User->getUserId())) &&
                ($Target->getAccount() === $User->getAccount()) &&
                (intval($User->getDeleteKubun()) === 0)) {
                return true;
            }
        }
        return false;
    }
}

function compareUser($a, $b) {
    return strnatcasecmp(preg_replace("/( |@)/", "",$a->getFullNameKana()), preg_replace("/( |@)/", "",$b->getFullNameKana()));
}

?>
