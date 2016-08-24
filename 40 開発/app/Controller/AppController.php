<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('Debugger', 'Utility');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'OrgUserList');
App::import('Vendor', 'OrgUser');
App::import('Vendor', 'OrgPostList');
App::import('Vendor', 'OrgPost');
App::import('Vendor', 'OrgScheduleList');
App::import('Vendor', 'OrgSchedule');
App::import('Vendor', 'OrgMailList');
App::import('Vendor', 'OrgMail');
App::import('Vendor', 'OrgReceivingMailList');
App::import('Vendor', 'OrgReceivingMail');
App::import('Vendor', 'OrgSendingMailList');
App::import('Vendor', 'OrgSendingMail');
App::import('Vendor', 'OrgAttendancesList');
App::import('Vendor', 'OrgAttendance');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    protected $LoginUser;
    protected $UserList;

    public function beforeFilter() {
        $session_id = $this->Session->id();

        if (empty($session_id) === true) {
            CakeSession::start();
        }

        if (($this->action !== 'login') && ($this->Session->check('login_user') === false)) {
            $this->redirect(array('controller'=>'DashBoards', 'action'=>'login'));
            return;
        }

        if ($this->action !== 'login') {
            $this->LoginUser = unserialize($this->Session->read('login_user'));
            $this->LoginUser->setUserModel();
        }

        $this->UserList = new OrgUserList();

        $_SESSION['user_list'] = serialize($this->UserList);

        $menu_info = Configure::read('menu-info');
        $this_path = Router::url(array('controller'=>$this->name, 'action'=>$this->action));
        $authority = -1;
        foreach ($menu_info as $val) {
            if ($val['child'] !== null) {
                foreach ($val['child'] as $val_child) {
                    if ($val_child['href'] === $this_path) {
                        $authority = $val_child['authority'];
                        break;
                    }
                }
            } else {
                if ($val['href'] === $this_path) {
                    $authority = $val['authority'];
                    break;
                }
            }

            if ($authority >= 0) {
                break;
            }
        }

        if ($authority < 0) {
            return;
        }

        if ($authority > $this->LoginUser->getAuthority()) {
            $this->redirect(array('controller'=>'DashBoards', 'action'=>'index'));
        }
    }

    public function beforeRender() {
        $ReceivingMailList = new OrgReceivingMailList($this->LoginUser->getUserId(), null, '', 0);

        $unreadMailCount = 0;
        foreach ($ReceivingMailList->Items as $key => $value) {
            if (intval($value->getUnReadKubun()) === 1) {
                ++$unreadMailCount;
            }
        }

        $this->set('unreadMailCount', $unreadMailCount);
        $this->set('LoginUser', $this->LoginUser);
        $this->set('UserList', $this->UserList);
    }

    public function logout() {
        $this->LoginUser->logout();
        $this->redirect(array('controller'=>'DashBoards', 'action'=>'login'));
    }
}
