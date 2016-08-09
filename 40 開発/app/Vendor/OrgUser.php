<?php

/*
 * OrgUser.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgUser {
    private $User;
    private $id;
    private $account;
    private $password;
    private $fullName;
    private $fullNameKana;
    private $mailAddress;
    private $authority;
    private $deleteKubun;

    function __construct($userInfo = null) {
        if ($userInfo !== null) {
            $this->id           = intval($userInfo['User']['id']);
            $this->account      = $userInfo['User']['account'];
            $this->password     = $userInfo['User']['password'];
            $this->fullName     = $userInfo['User']['full_name'];
            $this->fullNameKana = $userInfo['User']['full_name_kana'];
            $this->mailAddress  = $userInfo['User']['mail_address'];
            $this->authority    = $userInfo['User']['authority'];
            $this->deleteKubun  = $userInfo['User']['delete_kubun'];
        } else {
            $this->id           = -1;
            $this->account      = '';
            $this->password     = '';
            $this->fullName     = '';
            $this->fullNameKana = '';
            $this->mailAddress  = '';
            $this->authority    = -1;
            $this->deleteKubun  = -1;
        }

        $this->User = ClassRegistry::init('User');
    }

    public function login($account, $password) {
        $conditions = array(
            'and'=>array('account'=>$account, 'password'=>Security::hash($password, 'sha1', true))
        );

		try {
	        $result = $this->User->find('first', array('conditions'=>$conditions));
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        if (empty($result) === true) {
            return;
        }

        $this->id           = intval($result['User']['id']);
        $this->account      = $result['User']['account'];
        $this->password     = $result['User']['password'];
        $this->fullName     = $result['User']['full_name'];
        $this->fullNameKana = $result['User']['full_name_kana'];
        $this->mailAddress  = $result['User']['mail_address'];
        $this->authority    = $result['User']['authority'];
        $this->deleteKubun  = $result['User']['delete_kubun'];

        session_destroy();
        session_start();

        $_SESSION['login_user'] = serialize($this);
    }

    public function logout() {
        session_destroy();
    }

    public function isExist() {
        if ($this->id <= 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getUserId() {
        return $this->id;
    }

    public function getAccount() {
        if ($escape === true) {
            return htmlentities($this->account, ENT_QUOTES, 'utf-8');
        } else {
            return $this->account;
        }
    }

    public function getFullName($escape = false) {
        if ($escape === true) {
            return htmlentities($this->fullName, ENT_QUOTES, 'utf-8');
        } else {
            return $this->fullName;
        }
    }

    public function getFullNameKana($escape = false) {
        if ($escape === true) {
            return htmlentities($this->fullNameKana, ENT_QUOTES, 'utf-8');
        } else {
            return $this->fullNameKana;
        }
    }

    public function getMailAddress($escape = false) {
        if ($escape === true) {
            return htmlentities($this->mailAddress, ENT_QUOTES, 'utf-8');
        } else {
            return $this->mailAddress;
        }
    }

    public function getAuthority() {
        return $this->authority;
    }

    public function getDeleteKubun() {
        return $this->deleteKubun;
    }

    public function getInitial() {
        if ((mb_strpos($this->getFullNameKana(), 'ﾞ') === 1) || (mb_strpos($this->getFullNameKana(), 'ﾟ') === 1)) {
            $top_str = mb_substr($this->fullNameKana, 0, 2, 'utf-8');
        } else {
            $top_str = mb_substr($this->fullNameKana, 0, 1, 'utf-8');
        }
        switch ($top_str) {
            case 'ｱ':                                               return 'A';
            case 'ｲ':                                               return 'I';
            case 'ｳ':                                               return 'U';
            case 'ｴ':                                               return 'E';
            case 'ｵ':                                               return 'O';
            case 'ｶ': case 'ｷ': case 'ｸ': case 'ｹ': case 'ｺ':       return 'K';
            case 'ｻ': case 'ｼ': case 'ｽ': case 'ｾ': case 'ｿ':       return 'S';
            case 'ﾀ': case 'ﾁ': case 'ﾂ': case 'ﾃ': case 'ﾄ':       return 'T';
            case 'ﾅ': case 'ﾆ': case 'ﾇ': case 'ﾈ': case 'ﾉ':       return 'N';
            case 'ﾊ': case 'ﾋ': case 'ﾌ': case 'ﾍ': case 'ﾎ':       return 'H';
            case 'ﾏ': case 'ﾐ': case 'ﾑ': case 'ﾒ': case 'ﾓ':       return 'M';
            case 'ﾔ': case 'ﾕ': case 'ﾖ':                           return 'Y';
            case 'ﾗ': case 'ﾘ': case 'ﾙ': case 'ﾚ': case 'ﾛ':       return 'R';
            case 'ﾜ': case 'ｦ': case 'ﾝ':                           return 'W';
            case 'ｶﾞ': case 'ｷﾞ': case 'ｸﾞ': case 'ｹﾞ': case 'ｺﾞ':  return 'G';
            case 'ｻﾞ': case 'ｼﾞ': case 'ｽﾞ': case 'ｾﾞ': case 'ｿﾞ':  return 'Z';
            case 'ﾀﾞ': case 'ﾁﾞ': case 'ﾂﾞ': case 'ﾃﾞ': case 'ﾄﾞ':  return 'D';
            case 'ﾊﾞ': case 'ﾋﾞ': case 'ﾌﾞ': case 'ﾍﾞ': case 'ﾎﾞ':  return 'B';
            case 'ﾊﾟ': case 'ﾋﾟ': case 'ﾌﾟ': case 'ﾍﾟ': case 'ﾎﾟ':  return 'P';
            case 'a': case 'A':                                     return 'A';
            case 'b': case 'B':                                     return 'B';
            case 'c': case 'C':                                     return 'C';
            case 'd': case 'D':                                     return 'D';
            case 'e': case 'E':                                     return 'E';
            case 'f': case 'F':                                     return 'F';
            case 'g': case 'G':                                     return 'G';
            case 'h': case 'H':                                     return 'H';
            case 'i': case 'I':                                     return 'I';
            case 'j': case 'J':                                     return 'J';
            case 'k': case 'K':                                     return 'K';
            case 'l': case 'L':                                     return 'L';
            case 'm': case 'M':                                     return 'M';
            case 'n': case 'N':                                     return 'N';
            case 'o': case 'O':                                     return 'O';
            case 'p': case 'P':                                     return 'P';
            case 'q': case 'Q':                                     return 'Q';
            case 'r': case 'R':                                     return 'R';
            case 's': case 'S':                                     return 'S';
            case 't': case 'T':                                     return 'T';
            case 'u': case 'U':                                     return 'U';
            case 'v': case 'V':                                     return 'V';
            case 'w': case 'W':                                     return 'W';
            case 'x': case 'X':                                     return 'X';
            case 'y': case 'Y':                                     return 'Y';
            case 'z': case 'Z':                                     return 'Z';
            default:                                                return '?';
        }
    }
}

?>
