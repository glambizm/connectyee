<?php

/*
 * Comment.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppModel', 'Model');

class Comment extends AppModel {
    public $belongsTo = array (
            'user' => array('className' => 'User', 'foreignKey' => 'user_id'),
            'post' => array('className' => 'Post', 'foreignKey' => 'post_id')
    );
}

?>
