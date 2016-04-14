<?php

/*
 * Post.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppModel', 'Model');

class Post extends AppModel {
    public $belongsTo = array(
            'User' => array('className' => 'User', 'foreignKey' => 'user_id')
    );

    public $hasMany = array(
            'Comment'=>array('className'=>'Comment')
    );
}

?>
