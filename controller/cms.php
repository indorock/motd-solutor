<?php


class MotdCMSPage extends Motd_Model_Cms_PageData {


    protected function processForPage($page) {
        $this->assign("largeHeader", true);
        $handled = parent::processForPage($page);
        if(!$handled) {
            //echo 'here';
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            $this->assign("largeHeader", true);
            $this->assign("nomeanwhile", true);
            $this->assign("template", "404.html");
            $this->assign('sectionname', 'error');
            $this->assign('pagename', '404');
            $handled = true;
        }
        return $handled;
    }

}

CW::register('page_handler', new MotdCMSPage() );
