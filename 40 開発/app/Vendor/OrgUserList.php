<?php
/*
 * OrgUserList.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/

class OrgUserList {
    public $Items;
    private $User;

    function __construct() {
        $this->User = ClassRegistry::init('User');
        $this->Items = array();

        if (($this->User instanceof User) === false) {
            return;
        }

        try {
            $result = $this->User->find('all');
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        foreach ($result as $val) {
            $this->Items[] = new OrgUser($val);
        }

        usort($this->Items, 'compareUser');
    }

    public function getUserList($id) {
        $result = array();
        foreach ($id as $val) {
            foreach($this->Items as $User) {
                if (intval($val) === intval($User->getUserId())) {
                    $result[] = clone $User;
                    break;
                }
            }
        }

        if (count($result) === 0) {
            $result[] = new OrgUser();
            return $result;
        } else {
            usort($result, 'compareUser');
            return $result;
        }
    }

    public function getActiveUserList() {
        $result = array();
        foreach ($this->Items as $val) {
            if (intval($val->getDeleteKubun()) === 0) {
                $result[] = clone $val;
            }
        }

        if (count($result) === 0) {
            $result[] = new OrgUser();
            return $result;
        } else {
            usort($result, 'compareUser');
            return $result;
        }
    }

    public function isExistSameAccountUser($Target) {
        foreach($this->Items as $User) {
            if ((intval($Target->getUserId()) !== intval($User->getUserId())) &&
                ($Target->getAccount() === $User->getAccount()) &&
                (intval($User->getDeleteKubun()) === 0)) {
                return true;
            }
        }
        return false;
    }
}

function compareUser($a, $b) {
    return strnatcasecmp(preg_replace("/( |@)/", "",$a->getFullNameKana()), preg_replace("/( |@)/", "",$b->getFullNameKana()));
}

?>
