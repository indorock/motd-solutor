<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    public function indexAction($request) {
        $this->assign("subtemplate", "form.html");

        $user = CW::getSingelton('user/session')->getUser();
        if (!$user)
            throw new Exception("Missing Session User Object");

        $modelName = $request->get(0);
        if (!$modelName)
            throw new Exception("Missing Model Param");

        $selection = $request->getParam('selection');
        $obj = CW::getInst($modelName)->load($selection);
        $parent = null;
        if($obj)
            $parent = $obj->getParentObject();

        $canEdit = $user->checkObjectAccess($modelName, array('create', 'update'));
//        if($canEdit){
        $frm = CW::getInst('cw/model/mdm/form');
        $frm->loadByModelName($modelName);
        $formdata = $frm->getActForm()->getFrm();

        $this->assign('model', $modelName);
        $this->assign('selection', $selection);
        $this->assign('frm', $formdata);
        $this->assign('currentuser', $user);
        if($parent){
            $this->assign('parent_id', $parent->getId());
            $this->assign('parent_model', $parent->getClassname());
        }
        if(json_decode($formdata)->Comments){
            $this->assign('hasComments', true);
            $comments = CW::getInst('cw/model/mdm/form/comment')->loadByOwner($request->get(0), $selection);
            $this->assign('comments', $comments);
        }
//        }else{
//            $this->assign("error", "You do not have permission to edit this object");
//        }
    }
}

CW::register('page_handler', new IndexPageData());
