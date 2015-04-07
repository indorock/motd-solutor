<?php

class Motd_Model_RawPageData extends Motd_Model_PageData {

    public function beforeAction($request, $siteSearch) {
        $res = parent::beforeAction($request, $siteSearch);
        if($res === false)
            return false;
        if($this->template && $request->get('content', false))
            $this->mainTpl = $this->template;
        return $res;        
    }
}
