<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    public function indexAction($request) {
        $this->ignoreTemplate = true;
        $savehandler = CW::model('cms/savehandler');
        $resp = $savehandler->doSave($request);
        echo $resp;
    }
}

CW::register('page_handler', new IndexPageData());
