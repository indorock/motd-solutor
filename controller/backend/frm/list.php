<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    public function indexAction($request) {
        $mypage = CW::getInstance('CW_Pages_MDM_Lists');
        if (!$mypage->indexAction($request))
            throw new CW_Core_Exception_Ignore('error loading list');

        $model = $request->get(0);
        $this->assign("listtitle", CW__('listtitle',null,'backend',$model,'NAME'));
        $this->assign("subtemplate", "list.html");
    }

    public function dataAction($request) {
        $this->ignoreTemplate = true;

        $mypage = CW::getInstance('CW_Pages_MDM_Lists');

        $list = $mypage->getList($request);
        if (!$list)
            throw new CW_Core_Exception_Ignore('error loading list');

        // check object's read permissions
        $user = CW::getSingelton('user/session')->getUser();
        if($user){
            $canView = $user->checkObjectAccess($list->getModel(), array('read'));
            if($canView){
                //run action if passed!
                if ($list->runActions())
                    return;

                $page = (int)$request->get(1);
                if (!$page)
                    $page = (int)$request->get("page");
                if (!$page)
                    $page = $list->getPage();

                echo $list->getListJSON($page);
            }else{
                throw new CW_Core_Exception_Ignore("You do not have permission to view this list");
            }
        }else{
            throw new Exception("User not found");
        }

    }
}

CW::register('page_handler', new IndexPageData());
CW::register('api_access', true);
CW::register('api_access_html', true);
