<?php

/*
 * ReceivingUser.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppModel', 'Model');

class ReceivingUser extends AppModel {
    public $belongsTo = array(
            'WebMail'=>array('className'=>'WebMail', 'foreignKey'=>'web_mail_id'),
            'User'=>array('className'=>'User', 'foreignKy'=>'user_id')
    );
}

?>
