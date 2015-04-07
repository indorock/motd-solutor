<?php

class Motd_Model_PageDataBackend extends CW_Core_PageData {

    protected $needLogin = true;

    // DEPRECATED: the list of lists is no longer being defined using the array below, but rather in the frm_lists DB table.
    public $validmodels = array();

    public function beforeAction($request, $siteSearch) {

        if (!CW::app()->getLang()) //make sure we have a language set
            CW::app()->setLang('de');

        $this->getTpl()->assign("template", "loggedin.html");

        if(!CW::getSingleton('user/session')->isLoggedIn() && $this->needLogin)
            return $this->redirectIndex();

        $actuser = CW::getSingleton('user/session')->getUser();

        if ($actuser) {
            $actuser->enforceperm('backend');
            $this->getTpl()->assign("actuser", $actuser);
            $userdata = $actuser->getExtData();
            if($lang = $userdata->getLang())
                CW::app()->setLang($lang);
            else
                CW::app()->setLang('de');
        }else
            CW::app()->setLang('de');

        parent::beforeAction($request, $siteSearch);
    }

}
