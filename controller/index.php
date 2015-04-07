<?php

class IndexPageData extends Motd_Model_PageData {
	protected $template = "index.html";
}

CW::register('page_handler', new IndexPageData());
