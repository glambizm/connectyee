<?php

/*
 * OrgMailList.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgMailList {
    protected $WebMail;
    protected $ReceivingUser;
    protected $userId;
    protected $wherePhrase;
    protected $orderPhrase;
    protected $recordCount;

    function __construct($userId = 0, $wherePhrase = null, $orderPhrase = '', $recordCount = 0) {
        $this->WebMail = ClassRegistry::init('WebMail');
        $this->ReceivingUser = ClassRegistry::init('ReceivingUser');

        $this->userId = intval($userId);
        $this->wherePhrase = $wherePhrase;
        $this->orderPhrase = $orderPhrase;
        $this->recordCount = $recordCount;
    }

    protected function checkProperty() {
        if (($this->WebMail instanceof WebMail) === false) {
            return false;
        }

        if (($this->ReceivingUser instanceof ReceivingUser) === false) {
            return false;
        }

        return true;
    }
}

?>
