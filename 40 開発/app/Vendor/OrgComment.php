<?php

/*
 * OrgComment.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgPost {
    private $id;
    private $SubmissionUser;
    private $parentId;
    private $title;
    private $body;
    private $PostDate;
    private $Comment;
    private $UserList;

    function __construct($commentInfo = null) {
        $this->id               = -1;
        $this->SubmissionUser   = null;
        $this->parentId         = -1;
        $this->title            = '';
        $this->body             = '';
        $this->PostDate         = null;
        $this->Comment          = ClassRegistry::init('Comment');
        $this->UserList         = unserialize(CakeSession::read('user_list'));

        if ($this->checkProperty() === false) {
            return;
        }

        if ($commentInfo === null) {
            return;
        }

        $this->id               = $commentInfo['id'];
        $this->SubmissionUser   = $this->UserList->getUserList(array($commentInfo['user_id']))[0];
        $this->parentId         = $commentInfo['post_id'];
        $this->title            = $commentInfo['title'];
        $this->body             = $commentInfo['body'];
        $this->PostDate         = new DateTime($commentInfo['post_date']);
    }

    public function init($id) {
        if ($this->checkProperty() === false) {
            return;
        }

        try {
            $result = $this->Comment->find('all', array('conditions'=>array('Comment.id'=>$id)));
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        if (count($result) > 0) {
            $this->id               = $result[0]['Comment']['id'];
            $this->SubmissionUser   = $this->UserList->getUserList(array($result[0]['Comment']['user_id']))[0];
            $this->parentId         = $result[0]['Comment']['post_id'];
            $this->title            = $result[0]['Comment']['title'];
            $this->body             = $result[0]['Comment']['body'];
            $this->PostDate         = new DateTime($result[0]['Comment']['post_date']);
        }
    }

    public function registComment() {
        if ($this->checkProperty() === false) {
            return;
        }

        $fields = array('user_id', 'post_id', 'title', 'body', 'post_date');
        $data = array('Comment'=>array( 'user_id'=>$this->SubmissionUser->getUserId(),
                                        'post_id'=>$this->parentId,
                                        'title'=>$this->title,
                                        'body'=>$this->body,
                                        'post_date'=>DboSource::expression('NOW()')
                                        ));
        if ($this->Comment->validates($data) === true) {
            try {
                $result = $this->Comment->find('all', array('conditions'=>array('Comment.id'=>$this->id)));
            } catch (PDOException $e) {
                Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
                return;
            } catch (Exception $e) {
                Debugger::log($e->getMessage(), LOG_DEBUG);
                return;
            }

            if (count($result) > 0) {
                $this->Comment->id = $this->id;
            } else {
                $this->Comment->create();
            }

            try {
                $this->Comment->save($data, false, $fields);
            } catch (PDOException $e) {
                Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            } catch (Exception $e) {
                Debugger::log($e->getMessage(), LOG_DEBUG);
            }
        } else {
            Debugger::log(var_export($this->Comment->validationErrors, true), LOG_DEBUG);
        }
    }

    public function deletePost() {
        if ($this->checkProperty() === false) {
            return;
        }

        $this->Comment->delete($this->id);
    }

    public function checkUser($id) {
        if (intval($id) === intval($this->SubmissionUser->getUserId())) {
            return true;
        } else {
            return false;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getSubmissionUser() {
        return $this->SubmissionUser;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function getTitle($escape = false) {
        if ($escape === true) {
            $result = htmlentities($this->title, ENT_QUOTES, 'utf-8');
            return $result;
        } else {
            return $this->title;
        }
    }

    public function getBody($escape = false) {
        if ($escape === true) {
            $result = htmlentities($this->body, ENT_QUOTES, 'utf-8');
            $result = nl2br($result);
            return $result;
        } else {
            return $this->body;
        }
    }

    public function getPostDate() {
        return $this->PostDate;
    }

    public function setSubmissionUser($id) {
        $this->SubmissionUser = $this->UserList->getUserList(array($id))[0];
    }

    public function setParentId($id) {
        $this->parentId = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    private function checkProperty() {
      if (($this->Comment instanceof Comment) === false) {
            return false;
        }
        return true;
    }
}
?>