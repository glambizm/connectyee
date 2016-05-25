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

        usort($this->Items, 'cmp');
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
            usort($result, 'cmp');
            return $result;
        }
    }
}

function cmp($a, $b) {
    return strnatcmp($a->getFullNameKana(), $b->getFullNameKana());
}

?>
