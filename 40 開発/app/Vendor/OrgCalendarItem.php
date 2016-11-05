<?php
/*
 * OrgCalendarItem.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgCalendarItem {
    private $Calendar;
    private $calendarDate;
    private $dateKubun;
    private $dateName;

    function __construct($dateInfo = null) {
        $this->calendarDate = null;
        $this->dateKubun    = 0;
        $this->dateName     = '';

        $this->Calendar = ClassRegistry::init('Calendar');

        if (($this->Calendar instanceof Calendar) === false) {
            return;
        }

        if ($dateInfo === null) {
            return;
        }

        $this->calendarDate = $dateInfo['Calendar']['calendar_date'];
        $this->dateKubun    = $dateInfo['Calendar']['date_kubun'];
        $this->dateName     = $dateInfo['Calendar']['date_name'];
    }

    public function getCalendarDate() {
        return $this->calendarDate;
    }

    public function getDateKubun() {
        return $this->dateKubun;
    }

    public function getDateName($escape = false) {
        if ($escape === true) {
            return htmlentities($this->dateName, ENT_QUOTES, 'utf-8');
        } else {
            return $this->dateName;
        }
    }

    public function setCalendarDate($calendarDate) {
        $this->calendarDate = $calendarDate;
    }

    public function setDateKubun($dateKubun) {
        $this->dateKubun = $dateKubun;
    }

    public function setDateName($dateName) {
        $this->dateName = $dateName;
    }

    public function registDateInfo() {
        $SQLPara = array();
        $SQLPara['conditions'] = array('Calendar.calendar_date'=>$this->calendarDate->format('Y/m/d'));

        try {
            $result = $this->Calendar->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        $fields = array('calendar_date','date_kubun', 'date_name');
        $data = array('Calendar'=>array('calendar_date'=>$this->calendarDate->format('Y-m-d'),
                                        'date_kubun'=>$this->dateKubun,
                                        'date_name'=>$this->dateName
                                        ));

        if (count($result) > 0) {
            if (($this->dateKubun === 0) && ($this->dateName === '')) {
                $this->Calendar->delete(intval($result['Calendar']['id']));
            } else {
                $this->Calendar->id = intval($result['Calendar']['id']);

                if ($this->Calendar->validates($data) === true) {
                    try {
                        $this->Calendar->save($data, false, $fields);
                    } catch (PDOException $e) {
                        Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
                    } catch (Exception $e) {
                        Debugger::log($e->getMessage(), LOG_DEBUG);
                    }
                } else {
                    Debugger::log(var_export($this->Attendance->validationErrors, true), LOG_DEBUG);
                }
            }
        } else {
            if (($this->dateKubun === 0) && ($this->dateName === '')) {
                return;
            }

            $this->Calendar->create();
            if ($this->Calendar->validates($data) === true) {
                try {
                    $this->Calendar->save($data, false, $fields);
                } catch (PDOException $e) {
                    Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
                } catch (Exception $e) {
                    Debugger::log($e->getMessage(), LOG_DEBUG);
                }
            } else {
                Debugger::log(var_export($this->Attendance->validationErrors, true), LOG_DEBUG);
            }
        }
    }
}
?>