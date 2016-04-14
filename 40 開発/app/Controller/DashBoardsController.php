<?php

/*
 * DashBoardsController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppController', 'Controller');

class DashBoardsController extends AppController {
    public $uses = array('User', 'Post', 'Schedule', 'WebMail', 'ReceivingUser');
    private $PostList;
    private $ScheduleList;
    private $ReceivingMailList;
    private $loginMsg;

    public function index() {
        $where  = null;
        $order = 'Post.post_date DESC';
        $count = 5;
        $this->PostList = new OrgPostList($where, $order, $count);
        $this->set('PostList', $this->PostList->Items);

        $where  = array('Schedule.user_id' => $this->LoginUser->getUserId(), 'Schedule.target_date'=>date('Y-m-d'));
        $order = 'Schedule.start_time';
        $count = 5;
        $this->ScheduleList = new OrgScheduleList($where, $order, $count);
        $this->set('ScheduleList', $this->ScheduleList->Items);

        $where  = array('ReceivingUser.delete_kubun' => '0');
        $order = 'WebMail.sending_time DESC';
        $count = 5;
        $this->ReceivingMailList = new OrgReceivingMailList($this->LoginUser->getUserId(), $where, $order, $count);

        $this->set('MailList', $this->ReceivingMailList->Items);
    }

    public function login() {
        $this->layout = "";
        $this->set('loginMsg', '');
        $this->set('input_account', '');

        $this->LoginUser = new OrgUser();

        if ($this->request->is('post') === false) {
            return;
        }

        $this->set('input_account', $this->request->data['account']);

        if (($this->request->data['account'] === '') && ($this->request->data['password'] === '')) {
            $this->set('loginMsg', 'アカウント、および、パスワードを入力してください。');
            return;
        } else if ($this->request->data['account'] === '') {
            $this->set('loginMsg', 'アカウントを入力してください。');
            return;
        } else if ($this->request->data['password'] === '') {
            $this->set('loginMsg', 'パスワードを入力してください。');
            return;
        }

        $this->LoginUser->login($this->request->data['account'], $this->request->data['password']);

        if ($this->LoginUser->isExist() === false) {
            $this->set('loginMsg', 'アカウント、または、パスワードが間違っています。');
            return;
        }

        $this->redirect(array('controller'=>'DashBoards', 'action'=>'index'));
    }

    public function attendance() {
        $this->redirect('http://www.takumicorp.jp/TakumiDev/prg/kintai_kanri.php?new_to_old=1&account=' . $this->LoginUser->getAccount());
    }
}
?>