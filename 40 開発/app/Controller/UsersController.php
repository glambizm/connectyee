<?php
/*
 * UsersController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppController', 'Controller');

class UsersController extends AppController {
    private $errorMsg;
    private $inputtedAccount;

    public function beforeFilter() {
        parent::beforeFilter();

        $this->errorMsg = '';
        $this->inputtedAccount = '';
    }

    public function beforeRender() {
        parent::beforeRender();

        $this->set('errorMsg', $this->errorMsg);
        $this->set('inputtedAccount', $this->inputtedAccount);
    }

    public function changeUserProfile() {
        if ($this->request->is('post') === false) {
            return;
        }

        if ((empty($this->request->data['full_name']) === true) ||
            (empty($this->request->data['full_name_kana']) === true) ||
            (empty($this->request->data['account']) === true) ||
            (empty($this->request->data['mail_address']) === true)) {
            return;
        }

        $this->LoginUser->setFullName($this->request->data['full_name']);
        $this->LoginUser->setFullNameKana($this->request->data['full_name_kana']);
        $this->LoginUser->setAccount($this->request->data['account']);
        $this->LoginUser->setMailAddress($this->request->data['mail_address']);

        $ret = $this->_isExistSameAccountUser($this->LoginUser);

        if ($ret === true) {
            return;
        }

        $this->LoginUser->registUserInfo();
        $this->LoginUser->setLoginUser();

        $this->redirect(array('controller'=>'Users', 'action'=>'changeUserProfileCompleted'));
    }

    public function changeUserProfileCompleted() {

    }

    public function displayUserList() {

    }

    public function registUser() {
        if ($this->request->is('post') === false) {
            $User = new OrgUser();
            $this->set('User', $User);
        } else {
            if ((empty($this->request->data['full_name']) === true) ||
                (empty($this->request->data['full_name_kana']) === true) ||
                (empty($this->request->data['account']) === true) ||
                (empty($this->request->data['password']) === true) ||
                (empty($this->request->data['mail_address']) === true) ||
                (isset($this->request->data['authority']) === false)) {
                $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
            }

            $User = new OrgUser();
            $User->setFullName($this->request->data['full_name']);
            $User->setFullNameKana($this->request->data['full_name_kana']);
            $User->setAccount($this->request->data['account']);
            $User->setPassword($this->request->data['password']);
            $User->setMailAddress($this->request->data['mail_address']);
            $User->setAuthority($this->request->data['authority']);

            $ret = $this->_isExistSameAccountUser($User);

            if ($ret === true) {
                $this->set('User', $User);
                return;
            }

            $User->registUserInfo();

            $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
        }
    }

    public function editUserInfo($id = null) {
        if ($this->request->is('post') === false) {
            $User = $this->UserList->getUserList(array($id));
            $this->set('User', $User[0]);
        } else {
            if ((empty($this->request->data['full_name']) === true) ||
                (empty($this->request->data['full_name_kana']) === true) ||
                (empty($this->request->data['account']) === true) ||
                (empty($this->request->data['password']) === true) ||
                (empty($this->request->data['mail_address']) === true) ||
                (isset($this->request->data['authority']) === false)) {
                $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
            }

            $UserList = $this->UserList->getUserList(array($this->request->data['id']));
            $User = $UserList[0];
            $User->setFullName($this->request->data['full_name']);
            $User->setFullNameKana($this->request->data['full_name_kana']);
            $User->setAccount($this->request->data['account']);
            $User->setPassword($this->request->data['password']);
            $User->setMailAddress($this->request->data['mail_address']);
            $User->setAuthority($this->request->data['authority']);

            $ret = $this->_isExistSameAccountUser($User);

            if ($ret === true) {
                $this->set('User', $User);
                $this->render('RegistUser');
                return;
            }

            $User->registUserInfo();

            if ($User->getUserId() === $this->LoginUser->getUserId()) {
                $User->setLoginUser();
            }

            $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
        }

        $this->render('RegistUser');
    }

    public function deleteUser($id) {
        $User = $this->UserList->getUserList(array($id));
        $User[0]->deleteUser();

        $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
    }

    private function _isExistSameAccountUser($Target) {
        $ret = $this->UserList->isExistSameAccountUser($Target);

        if ($ret === true) {
            $this->errorMsg = '入力されたアカウントは他ユーザーにより使用されています。';
            return true;
        }

        return false;
    }
}

?>
