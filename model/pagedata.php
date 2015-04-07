<?php

class Motd_Model_PageData extends CW_Core_PageData {

    protected $template = null;

    public function beforeAction($request, $siteSearch) {
        $res = parent::beforeAction($request, $siteSearch);
        if($res === false)
            return false;
        if($request->isAjax())
            $this->ignoreTemplate = true; 
        if($this->template)
            $this->assign('template', $this->template);
        return $res;        
    }
}
