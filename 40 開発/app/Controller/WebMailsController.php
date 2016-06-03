<?php
/*
 * WebMailsController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppController', 'Controller');

class WebMailsController extends AppController {
    public $uses = array('WebMail', 'ReceivingUser');
    private $ReceivingMailList;
    private $SendingMailList;

    public function beforeFilter() {
        parent::beforeFilter();

        if (($this->action !== 'displayReceivingMail') &&
            ($this->action !== 'deleteReceivingMail') &&
            ($this->action !== 'displaySendingMail') &&
            ($this->action !== 'deleteSendingMail') &&
            ($this->action !== 'forwardMail') &&
            ($this->action !== 'replyMail')) {
            return;
        }

        $Mail = new OrgMail();
        $mail_id = $this->params['pass'][0];
        $Mail->init($mail_id);
        if ($Mail->checkUser($this->LoginUser->getUserId()) === false) {
            $this->redirect(array('controller'=>'WebMails', 'action'=>'displayReceivingMailList'));
        }
    }

    public function displayReceivingMailList() {
        $userId = $this->LoginUser->getUserId();
        $where = array('ReceivingUser.delete_kubun'=>0);
        $order = 'WebMail.sending_time DESC';
        $this->ReceivingMailList = new OrgReceivingMailList($userId, $where, $order);

        $this->set('ReceivingMailList', $this->ReceivingMailList->Items);
    }

    public function displayReceivingMail($id) {
        $this->_procReceivingMail($id);
    }

    public function deleteReceivingMail($id) {
        $this->_procReceivingMail($id);
    }

    public function displaySendingMailList() {
        $userId = $this->LoginUser->getUserId();
        $where = array('WebMail.delete_kubun'=>0);
        $order = 'WebMail.sending_time DESC';
        $this->SendingMailList = new OrgSendingMailList($userId, $where, $order);

        $this->set('SendingMailList', $this->SendingMailList->Items);
    }

    public function displaySendingMail($id) {
        $this->_procSendingMail($id);
    }

    public function deleteSendingMail($id) {
        $this->_procSendingMail($id);
    }

    public function makeNewMail() {
        $this->_procMakingMail();
    }

    public function forwardMail($id) {
        $this->_procMakingMail($id);
    }

    public function replyMail($id) {
        $this->_procMakingMail($id);
    }

    public function sendMail() {
        if ((isset($this->request->data['receiving_user_list']) === false) ||
            (count($this->request->data['receiving_user_list']) === 0)) {
            $this->redirect(array('controller'=>'WebMails', 'action'=>'displaySendingMailList'));
        }

        $SendingMail = new OrgSendingMail();
        $SendingMail->setSendingUser($this->LoginUser->getUserid());
        $SendingMail->setSubject($this->request->data['subject']);
        $SendingMail->setBody($this->request->data['body']);
        $SendingMail->setReceivingUserList($this->request->data['receiving_user_list']);
        $SendingMail->sendMail();

        $this->redirect(array('controller'=>'WebMails', 'action'=>'displaySendingMailList'));
    }

    private function _procReceivingMail($id) {
        $ReceivingMail = new OrgReceivingMail();
        $ReceivingMail->init($id, $this->LoginUser->getUserId());

        if ($this->action === 'displayReceivingMail') {
            $ReceivingMail->deleteUnReadKubun();
            $this->set('ReceivingMail', $ReceivingMail);
        } else if ($this->action ==='deleteReceivingMail') {
            $ReceivingMail->deleteReceivingMail();
            $this->redirect(array('controller'=>'WebMails', 'action'=>'displayReceivingMailList'));
        }
    }

    private function _procSendingMail($id) {
        $SendingMail = new OrgSendingMail();
        $SendingMail->init($id);

        if ($this->action === 'displaySendingMail') {
            $this->set('SendingMail', $SendingMail);
        } else if ($this->action === 'deleteSendingMail') {
            $SendingMail->deleteSendingMail();
            $this->redirect(array('controller'=>'WebMails', 'action'=>'displaySendingMailList'));
        }
    }

    private function _procMakingMail($id = 0) {
        $Mail = new OrgMail();
        $Mail->init($id);

        $SendingUser = $Mail->getSendingUser();
        $SendingTime = $Mail->getSendingTime();
        $subject = $Mail->getSubject() === '' ? '（件名なし）' : $Mail->getSubject();
        if ($this->action === 'replyMail') {
            $Mail->setSubject('Re:' . $Mail->getSubject());
            $Mail->setBody( "\n\n\n" . '---------- <以下、元メッセージ> ----------' . "\n" .
                            '送信者：' . $SendingUser->getFullName(true) . "\n" .
                            '送信日時：' . $SendingTime->format('Y/n/j(D) G:i') . "\n" .
                            '件名：' . $subject . "\n\n" .
                            $Mail->getBody()
            );
        } else if ($this->action ==='forwardMail') {
            $Mail->setSubject('Fw:' . $Mail->getSubject());
            $Mail->setBody( "\n\n\n" . '---------- <以下、元メッセージ> ----------' . "\n" .
                            '送信者：' . $SendingUser->getFullName(true) . "\n" .
                            '送信日時：' . $SendingTime->format('Y/n/j(D) G:i') . "\n" .
                            '件名：' . $subject . "\n\n" .
                            $Mail->getBody()
            );
        }

        $this->set('OriginalMail', $Mail);
        $this->render('MakeMail');
    }
}
?>
