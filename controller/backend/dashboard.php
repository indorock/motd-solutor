<?php

class DashboardPageData extends Motd_Model_PageDataBackend {

    public function indexAction($request) {
        $this->getTpl()->assign("subtemplate", "dashboard.html");
    }

}

CW::register('page_handler', new DashboardPageData());
