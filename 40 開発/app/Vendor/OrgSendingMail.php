<?php

/*
 * OrgSendingMail.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgSendingMail extends OrgMail  {

    function __construct($mailInfo = null) {
        parent::__construct($mailInfo);

        if ($mailInfo !== null) {
            $this->deleteKubun = $mailInfo['WebMail']['delete_kubun'];

            $receivingUserId = array();
            foreach ($mailInfo['ReceivingUser'] as $val) {
                $receivingUserId[] = intval($val['user_id']);
            }
            $this->ReceivingUserList = $this->UserList->getUserList($receivingUserId);
        } else {
            $this->deleteKubun = 0;
        }
    }

    public function deleteSendingMail() {
        $this->WebMail->id = $this->id;

        try {
            $this->WebMail->saveField('delete_kubun', 1);
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
        }
    }

    public function sendMail() {
        if ($this->SendingUser->isExist() === false) {
            return;
        }

        $fields = array('user_id', 'subject', 'body', 'sending_time', 'delete_kubun');
        $data = array('WebMail'=>array( 'user_id'=>$this->SendingUser->getUserId(),
                                        'subject'=>$this->subject,
                                        'body'=>$this->body,
                                        'sending_time'=>DboSource::expression('NOW()'),
                                        'delete_kubun'=>0));

        if ($this->WebMail->validates($data) === true) {
            $this->WebMail->create();

            try {
                $this->WebMail->save($data, false, $fields);
            } catch (PDOException $e) {
                Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
                return;
            } catch (Exception $e) {
                Debugger::log($e->getMessage(), LOG_DEBUG);
                return;
            }

            $fields = array('web_mail_id', 'user_id', 'unread_kubun', 'delete_kubun');
            foreach ($this->ReceivingUserList as $val) {
                $data = array('ReceivingUser'=>array(   'web_mail_id'=>$this->WebMail->id,
                                                        'user_id'=>$val->getUserId(),
                                                        'unread_kubun'=>1,
                                                        'delete_kubun'=>0));
                if ($this->ReceivingUser->validates($data) === true) {
                    $this->ReceivingUser->create();

                    try {
                        $this->ReceivingUser->save($data, false, $fields);
                    } catch (PDOException $e) {
                        Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
                    } catch (Exception $e) {
                        Debugger::log($e->getMessage(), LOG_DEBUG);
                    }
                } else {
                    Debugger::log(var_export($this->ReceivingUser->validationErrors, true), LOG_DEBUG);
                }

            }

        } else {
            Debugger::log(var_export($this->WebMail->validationErrors, true), LOG_DEBUG);
            return;
        }

        $view_vars = array( 'subject' => $this->subject,
                            'sending_user_name' => $this->SendingUser->getFullName(true),
                            'url' => Router::url('/', true));

        foreach ($this->ReceivingUserList as $val) {
            $email = new CakeEmail('connectyee');
            $email  ->to($val->getMailAddress())
                    ->viewVars($view_vars)
                    ->send();
        }
    }
}

?>
