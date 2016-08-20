<?php
/*
 * UsersController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppController', 'Controller');

class UsersController extends AppController {
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
        $this->LoginUser->registUserInfo();

        $this->redirect(array('controller'=>'Users', 'action'=>'changeUserInfoCompleted'));
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
                (empty($this->request->data['authority']) === true)) {
                return;
            }

            $User = new OrgUser();
            $User->setFullName($this->request->data['full_name']);
            $User->setFullNameKana($this->request->data['full_name_kana']);
            $User->setAccount($this->request->data['account']);
            $User->setPassword($this->request->data['password']);
            $User->setMailAddress($this->request->data['mail_address']);
            $User->setAuthority($this->request->data['authority']);
            $User->registUserInfo();

            $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
        }
    }

    public function editUserInfo($id) {
        if ($this->request->is('post') === false) {
            $User = $this->UserList->getUserList(array($id));
            $this->set('User', $User[0]);
        } else {
            if ((empty($this->request->data['full_name']) === true) ||
                (empty($this->request->data['full_name_kana']) === true) ||
                (empty($this->request->data['account']) === true) ||
                (empty($this->request->data['password']) === true) ||
                (empty($this->request->data['mail_address']) === true) ||
                (empty($this->request->data['authority']) === true)) {
                return;
            }

            $User = new OrgUser();
            $User->setFullName($this->request->data['full_name']);
            $User->setFullNameKana($this->request->data['full_name_kana']);
            $User->setAccount($this->request->data['account']);
            $User->setPassword($this->request->data['password']);
            $User->setMailAddress($this->request->data['mail_address']);
            $User->setAuthority($this->request->data['authority']);
            $User->registUserInfo();

            $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
        }
    }

    public function deleteUser($id) {
        $User = $this->UserList->getUserList(array($id));
        $User[0]->deleteUser();

        $this->redirect(array('controller'=>'Users', 'action'=>'displayUserList'));
    }
}

?>
