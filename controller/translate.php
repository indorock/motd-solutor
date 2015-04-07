<?php

class TranslatePageData extends Motd_Model_PageData {

    public function indexAction($request) {
        $translate = CW::getSingleton('core/translate');
        if (!$translate->isInlineEdit())
            return false;

        $this->ignoreTemplate = true;
        $lang = CW::app()->getLang();

        $isMagicQuotes = get_magic_quotes_gpc();

        $toTranslate = $request->get('translate');
        foreach($toTranslate as $trans) {

            if($isMagicQuotes) {
                $trans['new'] = stripslashes( $trans['new'] );
                $trans['scope'] = stripslashes( $trans['scope'] );
                $trans['org'] = stripslashes( $trans['org'] );
            }
            $newVal = str_replace(array("\r","\n"),"", $trans["new"]);
            $translate->updateTranslation($lang,$trans["scope"],$trans["org"],$newVal,true);
        }
    }
}

CW::register('page_handler', new TranslatePageData());

