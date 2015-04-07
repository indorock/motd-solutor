<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    public function indexAction($request) {
        CW::getSingleton('user/session')->logout();
        $this->redirect('');
    }

}

CW::register('page_handler', new IndexPageData());
