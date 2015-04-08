<?php

class DoiPageData extends Motd_Model_PageData {
    protected $template = "doi.html";

    public function indexAction($request){
        $ret = CW::model('user')->handleDoi($request);
        $this->assign('already_doied', $ret['already_doied']);

    }
}

CW::register('page_handler', new DoiPageData());
