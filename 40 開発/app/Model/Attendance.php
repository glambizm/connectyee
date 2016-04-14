<?php

/*
 * Attendance.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppModel', 'Model');

class Attendance extends AppModel {
    public $belongsTo = array(
            'TargetUser' => array('className' => 'User', 'foreignKey' => 'target_user'),
            'RegistrationUser' => array('className' => 'User', 'foreignKey' => 'registration_user')
    );
}

?>
