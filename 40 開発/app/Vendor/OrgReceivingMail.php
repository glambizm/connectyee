<?php

/*
 * OrgReceivingMail.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgReceivingMail extends OrgMail  {
    private $receivingMailId;
    private $unReadKubun;

    function __construct($mailInfo = null) {
        parent::__construct($mailInfo);

        if ($mailInfo !== null) {
            $this->deleteKubun = $mailInfo['ReceivingUser']['delete_kubun'];
            $this->receivingMailId = intval($mailInfo['ReceivingUser']['id']);
            $this->unReadKubun = $mailInfo['ReceivingUser']['unread_kubun'];

            $receivingUserId = array();
            foreach ($mailInfo['WebMail']['ReceivingUser'] as $val) {
                $receivingUserId[] = intval($val['user_id']);
            }
            $this->ReceivingUserList = $this->UserList->getUserList($receivingUserId);
        } else {
            $this->deleteKubun = 0;
            $this->receivingMailId = -1;
            $this->unReadKubun = 0;
        }
    }

    public function init($webMailId=0, $userId=0) {
        if ($this->checkProperty() === false) {
            return;
        }

        $SQLPara['conditions'] = array('ReceivingUser.web_mail_id'=>$webMailId);

		try {
	        $result = $this->ReceivingUser->find('all', $SQLPara);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        foreach ($result as $val) {
            if (intval($val['ReceivingUser']['user_id']) === intval($userId)) {

                $this->id = intval($val['WebMail']['id']);
                $this->subject = $val['WebMail']['subject'];
                $this->body = $val['WebMail']['body'];
                $this->sendingTime = new DateTime($val['WebMail']['sending_time']);
                $this->deleteKubun = $val['ReceivingUser']['delete_kubun'];
                $this->receivingMailId = intval($val['ReceivingUser']['id']);
                $this->unReadKubun = $val['ReceivingUser']['unread_kubun'];

                $SendingUserList = $this->UserList->getUserList(array(intval($val['WebMail']['user_id'])));
                $this->SendingUser = $SendingUserList[0];

                break;
            }
        }

        $userIdList = array();

        foreach ($result as $val) {
            $userIdList[] = intval($val['ReceivingUser']['user_id']);
        }

        $this->ReceivingUserList = $this->UserList->getUserList($userIdList);
    }

    public function deleteReceivingMail() {
        $this->ReceivingUser->id = $this->receivingMailId;

		try {
        	$this->ReceivingUser->saveField('delete_kubun', 1);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
        }
    }

    public function deleteUnReadKubun() {
        $this->ReceivingUser->id = $this->receivingMailId;

		try {
	        $this->ReceivingUser->saveField('unread_kubun', 0);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
        }
    }

    public function getUnreadKubun() {
        return intval($this->unReadKubun);
    }
}

?>
