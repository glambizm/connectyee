<?php
/*
 * OrgAttendanceList.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgAttendanceList {
    public $Items;
    private $Attendance;
    private $wherePhrase;
    private $orderPhrase;
    private $recordCount;

    function __construct($userId = 0, $wherePhrase = null, $orderPhrase = '', $recordCount = 0) {
        $this->Items = array();
        $this->wherePhrase = $wherePhrase;
        $this->orderPhrase = $orderPhrase;
        $this->recordCount = $recordCount;


        $this->Attendance = ClassRegistry::init('Attendance');
        if (($this->Attendance instanceof Attendance) === false) {
            return;
        }

        $SQLPara = array();

        if ($this->wherePhrase !== null) {
            $SQLPara['conditions'][] = $wherePhrase;
        }

        if ($this->orderPhrase !== '') {
            $SQLPara['order'] = $this->orderPhrase;
        }

        if ($this->recordCount !== 0) {
            $SQLPara['limit'] = $this->recordCount;
        }

        try {
            $result = $this->Attendance->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        foreach ($result as $key=>$val) {
            $this->Items[] = new OrgAttendance($val);
        }
    }

    public function getLatestItems() {
        $result = array();
        $sortItems = array();

        foreach ($this->Items as $val) {
            $sortItems[] = clone $val;
        }

        usort($sortItems);

        $prevId = -1;
        foreach ($sortItems as $val) {
            if ($val->getUserId() !== $prevId) {
                $prevId = $val->getUserId();
                $result[] = clone $val;
            }
        }

        return $result;
    }

    public function getAllItems() {
        $result = array();

        foreach ($this->Items as $val) {
            $result[] = clone $val;
        }

        usort($result);

        return $result;
    }

    private function cmp($a, $b) {
        $cmp = strnatcmp($a->getTargetUser()->getFullNameKana(), $b->getTargetUser()->getFullNameKana());

        if ($cmp === 0) {
            if ($a->getRegistrationDate()->getTimestamp() > $b->getRegistrationDate()->getTimestamp()) {
                $cmp = -1;
            } else if ($a->getRegistrationDate()->getTimestamp() < $b->getRegistrationDate()->getTimestamp()) {
                $cmp = 1;
            } else {
                $cmp = 0;
            }
        }
        return $cmp;
    }
}

?>