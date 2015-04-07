<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    public function saveAction($request) {
        $user = CW::getSingelton('user/session')->getUser();
        if (!$user)
            throw new Exception("Missing Session User Object");

        $request->setValidSource('_POST');
        if(count($_POST)>0){
            $comment = CW::model('backend/comment');
            $comment->saveNew($request);
            $this->assign('user', $comment->getUser());
            $this->assign('currentuser', $user);
            $this->assign('comment', $comment);
            $this->mainTpl = "comment.html";
        }
    }

    public function deleteAction($request){
        $this->ignoreTemplate = true;

        $user = CW::getSingelton('user/session')->getUser();
        if (!$user)
            throw new Exception("Missing Session User Object");

        if($comment_id = $request->get(0))
            echo CW::model('backend/comment')->delete($comment_id, $user->getId());
    }
}

CW::register('page_handler', new IndexPageData());
