<?php
/*
 * PostsController.php
 * History
 * <#XX> XXXX/XX/XX X.XXXXXX XXXXXXXXXX
*/
App::uses('AppController', 'Controller');

class PostsController extends AppController {
    public $uses = array('Post', 'Comment');
    private $PostList;

    public function beforeFilter() {
        parent::beforeFilter();

        if (($this->action !== 'editPost') &&
            ($this->action !== 'deletePost') &&
            ($this->action !== 'deleteComment')) {
            return;
        }

        if (($this->action === 'editPost') || ($this->action === 'deletePost')) {
            $Target = new OrgPost();
        } else if ($this->action === 'deleteComment') {
            $Target = new OrgComment();
        }

        $Target->init($this->params['pass'][0]);
        if ($Target->checkUser($this->LoginUser->getUserId()) === false ) {
            $this->redirect(array('controller'=>'Post', 'action'=>'displayPostList'));
        }
    }

    public function displayPostList() {
        $order = 'posts.post_date DESC, comments.post_date ASC';
        $this->PostList = new OrgPostList(NULL, $order);
        $this->set('PostList', $this->PostList->Items);
    }

    public function  displayPost($id) {
        $Target = new OrgPost();
        $Target.init($id);
        $this->set('Post', $Target);
    }

    public function submissionPost() {
        $Target = new OrgPost();
        if ($this->request->is('post') === false) {
            $this->set('Post', $Target);
        } else {
            $Target->init($this->request->data['id']);
            $Target->setSubmissionUser($this->LoginUser->getUserId());
            $Target->setTitle($this->request->data['title']);
            $Target->setBody($this->request->data['body']);
            $Target->registPost();
            $this->redirect(array('controller'=>'Post', 'action'=>'displayPostList'));
        }
    }

    public function editPost($id) {
        $Target = new OrgPost();
        $Target->init($id);
        $this->set('Post', $Target);
        $this->render('submission_post');
    }

    public function deletePost($id) {
        $Target = new OrgPost();
        $Target->init($id);
        $Target->deletePost();
        $this->redirect(array('controller'=>'Post', 'action'=>'displayPostList'));
    }

    public function submissionComment() {
        if ($this->request->is('ajax') === false) {
            return;
        }
        $initial_color = Configure::read('initial_color');

        $TargetComment = new OrgComment();
        $TargetComment->setSubmissionUser($this->LoginUser->getUserId());
        $TargetComment->setParentId($this->request->data['parent_id']);
        $TargetComment->setTitle($this->request->data['comment_title']);
        $TargetComment->setBody($this->request->data['comment_body']);
        $TargetComment->registComment();

        $TargetPost = new OrgPost();
        $TargetPost->init($this->request->data['parent_id']);

        $ReturnJson = array();
        foreach ($TargetPost->Comments as $val) {
            $commentInfo = array();

            $commentInfo['id']              = $val->getId();
            $commentInfo['title']           = $val->getTitle(true);
            $commentInfo['body']            = $val->getBody(true);
            if ($val->getPostDate() instanceof DateTime) {
                $commentInfo['postDate'] = $val->getPostDate()->format('Y/m/d G:i');
            } else {
                $commentInfo['postDate'] = '';
            }
            $commentInfo['fullName']        = $val->getSubmissionUser()->getFullName(true);
            $commentInfo['fullNameKana']    = $val->getSubmissionUser()->getFullNameKana(true);
            $commentInfo['canDelete']       = $val->checkUser($this->LoginUser->getUserId());
            $commentInfo['initial']         = $val->getSubmissionUser()->getInitial();
            $commentInfo['initialClass']    = $initial_color[$val->getSubmissionUser()->getInitial()];

            $ReturnJson[] = $commentInfo;
        }
    }

    public function deleteComment() {
        if ($this->request->is('ajax') === false) {
            return;
        }
        $initial_color = Configure::read('initial_color');

        $TargetComment = new OrgComment();
        $TargetComment->init($this->request->data['id']);
        $TargetComment->deleteComment();

        $TargetPost = new OrgPost();
        $TargetPost->init($this->request->data['parent_id']);

        $ReturnJson = array();
        foreach ($TargetPost->Comments as $val) {
            $commentInfo = array();

            $commentInfo['id']              = $val->getId();
            $commentInfo['title']           = $val->getTitle(true);
            $commentInfo['body']            = $val->getBody(true);
            if ($val->getPostDate() instanceof DateTime) {
                $commentInfo['postDate'] = $val->getPostDate()->format('Y/m/d G:i');
            } else {
                $commentInfo['postDate'] = '';
            }
            $commentInfo['fullName']        = $val->getSubmissionUser()->getFullName(true);
            $commentInfo['fullNameKana']    = $val->getSubmissionUser()->getFullNameKana(true);
            $commentInfo['canDelete']       = $val->checkUser($this->LoginUser->getUserId());
            $commentInfo['initial']         = $val->getSubmissionUser()->getInitial();
            $commentInfo['initialClass']    = $initial_color[$val->getSubmissionUser()->getInitial()];

            $ReturnJson[] = $commentInfo;
        }
    }

}
?>
