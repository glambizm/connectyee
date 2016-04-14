<?php

/*
 * OrgPost.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
class OrgPost {
    private $postsUser;
    private $title;
    private $postDate;

    function __construct($postInfo = null) {
        if ($postInfo !== null) {
            $this->title = $postInfo['Post']['title'];
            $this->postDate = new DateTime($postInfo['Post']['post_date']);
        } else {
            $this->postsUser = null;
            $this->title = '';
            $this->postDate = 0;
        }

        $this->postsUser = new OrgUser($postInfo);
    }

    public function getPostsUser() {
        return $this->postsUser;
    }

    public function getTitle($escape = false) {
        if ($escape === true) {
            return htmlentities($this->title, ENT_QUOTES, 'utf-8');
        } else {
            return $this->title;
        }
    }

    public function getPostDate() {
        return $this->postDate;
    }
}

?>
