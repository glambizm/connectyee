<?php

/*
 * OrgMail.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgMail {
    protected $WebMail;
    protected $ReceivingUser;
    protected $UserList;
    protected $id;
    protected $SendingUser;
    protected $subject;
    protected $body;
    protected $sendingTime;
    protected $ReceivingUserList;
    protected $deleteKubun;

    function __construct($mailInfo = null) {
        $this->id = -1;
        $this->UserList = unserialize(CakeSession::read('user_list'));
        $this->SendingUser = null;
        $this->subject = '';
        $this->body = '';
        $this->sendingTime = null;
        $this->ReceivingUserList = null;
        $this->deleteKubun = 0;

        $this->WebMail = ClassRegistry::init('WebMail');
        $this->ReceivingUser = ClassRegistry::init('ReceivingUser');

        if ($this->checkProperty() === false) {
            return;
        }

        if ($mailInfo !== null) {
            $this->id = intval($mailInfo['WebMail']['id']);
            $this->subject = $mailInfo['WebMail']['subject'];
            $this->body = $mailInfo['WebMail']['body'];
            $this->sendingTime = new DateTime($mailInfo['WebMail']['sending_time']);
            $List = $this->UserList->getUserList(array(intval($mailInfo['WebMail']['user_id'])));
            $this->SendingUser = $List[0];
        } else {
            return;
        }
    }

    public function init($mailId) {
        if ($this->checkProperty() === false) {
            return;
        }

        $this->id = intval($mailId);

        $SQLPara['conditions'] = array('WebMail.id'=>$this->id);

        try {
            $result = $this->WebMail->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        if (count($result) > 0) {
            $this->subject = $result[0]['WebMail']['subject'];
            $this->body = $result[0]['WebMail']['body'];
            $this->sendingTime = new DateTime($result[0]['WebMail']['sending_time']);
            $this->deleteKubun = $result[0]['WebMail']['delete_kubun'];
            $this->SendingUser = new OrgUser($result[0]);

            $SQLPara['conditions'] = array('ReceivingUser.web_mail_id'=>$this->id);

            try {
                $result = $this->ReceivingUser->find('all', $SQLPara);
            } catch (PDOException $e) {
                Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
                return;
            } catch (Exception $e) {
                Debugger::log($e->getMessage(), LOG_DEBUG);
                return;
            }

            $receivingUserId = array();
            foreach ($result as $val) {
                $receivingUserId[] = intval($val['ReceivingUser']['user_id']);
            }

            $this->ReceivingUserList = $this->UserList->getUserList($receivingUserId);
        }
    }

    public function checkUser($userId) {
        if ($this->SendingUser !== null) {
            if (intval($this->SendingUser->getUserId()) === intval($userId)) {
                return true;
            }
        }

        foreach ($this->ReceivingUserList as $val) {
            if (intval($val->getUserId()) === intval($userId)) {
                return true;
            }
        }

        return false;
    }

    public function getId() {
        return intval($this->id);
    }

    public function getSendingUser() {
        return $this->SendingUser;
    }

    public function getReceivingUserList() {
        return $this->ReceivingUserList;
    }

    public function getSubject($escape = false) {
        if ($escape === true) {
            return htmlentities($this->subject, ENT_QUOTES, 'utf-8');
        } else {
            return $this->subject;
        }
    }

    public function getBody($escape = false) {
        if ($escape === true) {
            $result = htmlentities($this->body, ENT_QUOTES, 'utf-8');
            $result = nl2br($result);
            return $result;
        } else {
            return $this->body;
        }
    }

    public function getSendingTime() {
        return $this->sendingTime;
    }

    public function getDeleteKubun() {
        return $this->deleteKubun;
    }

    public function setSendingUser($id) {
        $List = $this->UserList->getUserList(array(intval($id)));
        $this->SendingUser = $List[0];
    }

    public function setReceivingUserList($id) {
        $List = $this->UserList->getUserList($id);
        $this->ReceivingUserList = $List;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    public function isExistReceivingUser($id) {
        foreach ($this->ReceivingUserList->Items as $val) {
            if (intval($val->getUserId()) === intval($id)) {
                return ture;
            }
        }
        return false;
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
