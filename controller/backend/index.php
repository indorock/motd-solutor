<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    protected $needLogin = false;

    public function indexAction($request) {
        $this->getTpl()->assign("template", "index.html");

        $request->setValidSource('_POST');
        $user = CW::model('user');
        try {
            $user->authenticate( $request->getData() );
            CW::getSingleton('user/session')->setUser($user);
        }catch(Exception $e){
        }

        if(CW::getSingleton('user/session')->isLoggedIn())
            $this->redirect('dashboard');
    }

}

CW::register('page_handler', new IndexPageData());
