<?php

/*
 * OrgReceivingMailList.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgReceivingMailList extends OrgMailList {
    public $Items;

    function __construct($userId = 0, $wherePhrase = null, $orderPhrase = '', $recordCount = 0) {
        parent::__construct($userId, $wherePhrase, $orderPhrase, $recordCount);

        $this->Items = array();

        if ($this->checkProperty() === false) {
            return;
        }

        $SQLPara = array();

        $SQLPara['conditions'] = array('ReceivingUser.user_id'=>$this->userId);
        if ($this->wherePhrase !== null) {
            $SQLPara['conditions'][] = $wherePhrase;
        }

        $SQLPara['recursive'] = 2;

        if ($this->orderPhrase !== '') {
            $SQLPara['order'] = $this->orderPhrase;
        }

        if ($this->recordCount !== 0) {
            $SQLPara['limit'] = $this->recordCount;
        }

		try {
	        $result = $this->ReceivingUser->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        foreach ($result as $key=>$val) {
            $this->Items[] = new OrgReceivingMail($val);
        }
    }
}

?>
