<?php
/*
 * OrgCalendar.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgCalendar {
    public $Items;
    private $Calendar;

    function __construct($startDate = null, $endDate = null) {
        $this->Calendar = ClassRegistry::init('Calendar');
        $this->Items = array();

        if (($this->Calendar instanceof Calendar) === false) {
            return;
        }

        if (($startDate === null) || ($endDate === null)) {
            return;
        }

        $dayCount = $startDate->diff($endDate);

        for ($count=0; $count <= $dayCount->days; $count++) {
            $param = array();
            $param['Calendar']['calendar_date'] = new DateTime($startDate->format('Y/m/d') . ' +' . $count .' day');
            $param['Calendar']['date_kubun']    = 0;
            $param['Calendar']['date_name']     = '';

            $this->Items[] = new OrgCalendarItem($param);
        }

        $SQLPara = array();
        $SQLPara['conditions'] = array( array('Calendar.calendar_date >='=>$startDate->format('Y/m/d')),
                                        array('Calendar.calendar_date <='=>$endDate->format('Y/m/d')));
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
                if ($item->getCalendarDate()->diff(new DateTime($val['Calendar']['calendar_date']))->days === 0) {
                    $this->Items[$key]->setDateKubun(intval($val['Calendar']['date_kubun']));
                    $this->Items[$key]->setDateName($val['Calendar']['date_name']);
                    break;
                }
            }
        }
    }

    public function getCalendarItems() {
        $result = array();
        foreach($this->Items as $item) {
            $result[] = clone $item;
        }
        return $result;
    }
}
?>