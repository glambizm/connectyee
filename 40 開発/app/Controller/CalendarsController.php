<?php

/*
 * CalendarsController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppController', 'Controller');

class CalendarsController extends AppController {
    private $CalendarObj;

    public function displayCalendar() {
        if ($this->request->is('ajax') === true) {
            $this->autoRender = false;

            $TargetDate = explode('/' ,$this->request->data['target_date']);
            $startDate = new DateTime($TargetDate[0] . '/' . $TargetDate[1] . '/1');
            $endDate = new DateTime('last day of ' . $TargetDate[0] . '-' . $TargetDate[1]);

            $this->CalendarObj = new OrgCalendar($startDate, $endDate);

            $ReturnJson = array();
            foreach ($this->CalendarObj->getCalendarItems() as $value) {
                $dateInfo = array();
                $dateInfo['dateKubun'] = $value->getDateKubun();
                $dateInfo['dateName'] = $value->getDateName(true);

                $ReturnJson[] = $dateInfo;
            }

            return new CakeResponse(array('type' => 'json', 'body' => json_encode($ReturnJson)));
        }
    }

    public function registDateInfo() {
        if ($this->request->is('ajax') === true) {
            $this->autoRender = false;

            if ((isset($this->request->data['target_date']) === false) ||
                (isset($this->request->data['date_kubun']) === false) ||
                (isset($this->request->data['date_name']) === false)) {
                return;
            }

            list($y, $m, $d) = explode('/', $this->request->data['target_date']);
            if (checkdate($m, $d, $y) === false) {
                return;
            }

            $CalendarItem = new OrgCalendarItem();

            $CalendarItem->setCalendarDate(new DateTime($this->request->data['target_date']));
            $CalendarItem->setDateKubun(intval($this->request->data['date_kubun']));
            $CalendarItem->setDateName($this->request->data['date_name']);
            $CalendarItem->registDateInfo();

            $TargetDate = explode('/' ,$this->request->data['target_date']);
            $startDate = new DateTime($TargetDate[0] . '-' . $TargetDate[1] . '-1');
            $endDate = new DateTime('last day of ' . $TargetDate[0] . '-' . $TargetDate[1]);

            $this->CalendarObj = new OrgCalendar($startDate, $endDate);

            $ReturnJson = array();
            foreach ($this->CalendarObj->getCalendarItems() as $value) {
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