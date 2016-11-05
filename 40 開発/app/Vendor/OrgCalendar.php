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

    public function getCalendarItems() {
        $result = array();
        foreach($this->Items as $item) {
            $result[] = clone $item;
        }
        return $result;
    }
}
?>