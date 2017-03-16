<?php

/*
 * OrgPost.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgPost {
    public  $Comments;
    private $id;
    private $SubmissionUser;
    private $title;
    private $body;
    private $PostDate;
    private $Post;
    private $UserList;

    function __construct($postInfo = null) {
        $this->Comments         = array();
        $this->id               = -1;
        $this->SubmissionUser   = null;
        $this->title            = '';
        $this->body             = '';
        $this->PostDate         = null;
        $this->Post             = ClassRegistry::init('Post');
        $this->UserList         = unserialize(CakeSession::read('user_list'));

        if ($this->checkProperty() === false) {
            return;
        }

        if ($postInfo === null) {
            return;
        }

        foreach ($postInfo['Comment'] as $val) {
            $this->Comments[] = new OrgComment($val);
        }
        $this->id               = $postInfo['Post']['id'];
        $this->SubmissionUser   = $this->UserList->getUserList(array($postInfo['Post']['user_id']))[0];
        $this->title            = $postInfo['Post']['title'];
        $this->body             = $postInfo['Post']['body'];
        $this->PostDate         = new DateTime($postInfo['Post']['post_date']);
    }

    public function init($id) {
        if ($this->checkProperty() === false) {
            return;
        }

        try {
            $this->Post->hasMany['Comment']['order'] = 'post_date asc';
            $result = $this->Post->find('all', array('conditions'=>array('Post.id'=>$id)));
        } catch (PDOException $e) {
            Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            return;
        } catch (Exception $e) {
            Debugger::log($e->getMessage(), LOG_DEBUG);
            return;
        }

        if (count($result) > 0) {
            foreach ($result[0]['Comment'] as $val) {
                $this->Comments[] = new OrgComment($val);
            }
            $this->id               = $result[0]['Post']['id'];
            $this->SubmissionUser   = $this->UserList->getUserList(array($result[0]['Post']['user_id']))[0];
            $this->title            = $result[0]['Post']['title'];
            $this->body             = $result[0]['Post']['body'];
            $this->PostDate         = new DateTime($result[0]['Post']['post_date']);
        }
    }

    public function registPost() {
        if ($this->checkProperty() === false) {
            return;
        }

        $fields = array('user_id', 'title', 'body', 'post_date');
        $data = array('Post'=>array('user_id'=>$this->SubmissionUser->getUserId(),
                                    'title'=>$this->title,
                                    'body'=>$this->body,
                                    'post_date'=>DboSource::expression('NOW()')
                                    ));
        if ($this->Post->validates($data) === true) {
            try {
                $result = $this->Post->find('all', array('conditions'=>array('Post.id'=>$this->id)));
            } catch (PDOException $e) {
                Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
                return;
            } catch (Exception $e) {
                Debugger::log($e->getMessage(), LOG_DEBUG);
                return;
            }

            if (count($result) > 0) {
                $this->Post->id = $this->id;
            } else {
                $this->Post->create();
            }

            try {
                $this->Post->save($data, false, $fields);
            } catch (PDOException $e) {
                Debugger::log($e->getMessage() . "\n" . $e->queryString, LOG_DEBUG);
            } catch (Exception $e) {
                Debugger::log($e->getMessage(), LOG_DEBUG);
            }
        } else {
            Debugger::log(var_export($this->Post->validationErrors, true), LOG_DEBUG);
        }
    }

    public function deletePost() {
        if ($this->checkProperty() === false) {
            return;
        }

        $this->Post->delete($this->id);
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

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setBody($body) {
        $this->body = $body;
    }

    private function checkProperty() {
      if (($this->Post instanceof Post) === false) {
            return false;
        }
        return true;
    }
}
?>