<?php

/*
 * User.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppModel', 'Model');

class User extends AppModel {

    public function beforeSave($options = array()) {
        Configure::load("connectyee_config.php");
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'sha1', true);
        }
        if (isset($this->data[$this->alias]['full_name'])) {
            $this->data[$this->alias]['full_name'] = openssl_encrypt($this->data[$this->alias]['full_name'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
        }
        if (isset($this->data[$this->alias]['full_name_kana'])) {
            $this->data[$this->alias]['full_name_kana'] = openssl_encrypt($this->data[$this->alias]['full_name_kana'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
        }
        if (isset($this->data[$this->alias]['mail_address'])) {
            $this->data[$this->alias]['mail_address'] = openssl_encrypt($this->data[$this->alias]['mail_address'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
        }
        return true;
    }

    public function afterFind($results, $primary = false) {
        Configure::load("connectyee_config.php");
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['full_name'])) {
                $results[$key][$this->alias]['full_name'] = openssl_decrypt($results[$key][$this->alias]['full_name'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
            }
            if (isset($val[$this->alias]['full_name_kana'])) {
                $results[$key][$this->alias]['full_name_kana'] = openssl_decrypt($results[$key][$this->alias]['full_name_kana'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
            }
            if (isset($val[$this->alias]['mail_address'])) {
                $results[$key][$this->alias]['mail_address'] = openssl_decrypt($results[$key][$this->alias]['mail_address'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
            }

            if (isset($val[$this->alias]['authority'])) {
                $results[$key][$this->alias]['authority'] = $results[$key][$this->alias]['authority'] === null ? 0 : $results[$key][$this->alias]['authority'];
            } else {
                $results[$key][$this->alias]['authority'] = 0;
            }
        }
        return $results;
    }
}

?>
