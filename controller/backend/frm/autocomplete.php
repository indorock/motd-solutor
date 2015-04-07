<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    public function indexAction($request) {
        $this->ignoreTemplate = true;
        $row = CW::sql()->queryOne("SELECT * FROM form_autocomplete WHERE model like ? and field like ?",
            array("text", "text"), array($request->getParam('model'), $request->getParam('field')));
        if(!$row)
            echo CW_JSON::encode(array());
        else {
            $handler = $row['handler'];
            if(!$handler)
                $handler = 'cw_model_mdm_formautocomplete';
            $inst = CW::getInst($handler);
            $inst->request($row['model'], $row['field'], $row['lookup'], $request->getParam('value'));
        }
    }


}

CW::register('page_handler', new IndexPageData());
