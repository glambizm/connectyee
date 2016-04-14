<?php

/*
 * WebMail.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppModel', 'Model');

class WebMail extends AppModel {
    public $belongsTo = array(
            'User'=>array('className'=>'User', 'foreignKey'=>'user_id')
    );

    public $hasMany = array(
            'ReceivingUser'=>array('className'=>'ReceivingUser')
    );

    public function beforeSave($options = array()) {
        Configure::load("connectyee_config.php");
        if (isset($this->data[$this->alias]['subject']) === true) {
            $this->data[$this->alias]['subject'] = openssl_encrypt($this->data[$this->alias]['subject'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
        }
        if (isset($this->data[$this->alias]['body']) === true) {
            $this->data[$this->alias]['body'] = openssl_encrypt($this->data[$this->alias]['body'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
        }
        return true;
    }

    public function afterFind($results, $primary = false) {
        Configure::load("connectyee_config.php");
        foreach ($results as $key => $val) {
            if (isset($val[$this->alias]['subject'])) {
                $results[$key][$this->alias]['subject'] = openssl_decrypt($results[$key][$this->alias]['subject'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
            }
            if (isset($val[$this->alias]['body'])) {
                $results[$key][$this->alias]['body'] = openssl_decrypt($results[$key][$this->alias]['body'], 'aes-256-cbc', Configure::read('SecurityKey'), false, '1234567812345678');
            }
        }
        return $results;
    }
}

?>
