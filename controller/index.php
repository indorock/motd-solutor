<?php

class IndexPageData extends Motd_Model_PageData {
    public $ignoreTemplate = true;
}

CW::register('page_handler', new IndexPageData());
