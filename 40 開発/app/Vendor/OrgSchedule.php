<?php

/*
 * OrgSchedule.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgSchedule {
    private $subject;
    private $startTime;
    private $endTime;

    function __construct($scheduleInfo = null) {
        if ($scheduleInfo !== null) {
            $this->subject = $scheduleInfo['Schedule']['subject'];
            $this->startTime = new DateTime($scheduleInfo['Schedule']['target_date'] . ' ' . $scheduleInfo['Schedule']['start_time']);
            $this->endTime = new DateTime($scheduleInfo['Schedule']['target_date'] . ' ' . $scheduleInfo['Schedule']['end_time']);
        } else {
            $this->subject = '';
            $this->startTime = 0;
            $this->endTime = 0;
        }
    }

    public function getSubject($escape = false) {
        if ($escape === true) {
            return htmlentities($this->subject, ENT_QUOTES, 'utf-8');
        } else {
            return $this->subject;
        }
    }

    public function getStartTime() {
        return $this->startTime;
    }

    public function getEndTime() {
        return $this->endTime;
    }
}

?>
