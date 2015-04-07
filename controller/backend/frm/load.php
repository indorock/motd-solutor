<?php

class IndexPageData extends Motd_Model_PageDataBackend {

    public function indexAction($request) {
        $this->ignoreTemplate = true;
        try {
            $model = $request->getParam('model');
            $idx = $request->getParam('idx');
            $m = //CW::getInst('mq/model/'.str_replace("_", "/",$model));
            $m = CW::getInst(str_replace("_", "/",$model));
            $m->load($idx);
            $m->loadForm();

            $rows = CW::sql()->query("SELECT * FROM form_autocomplete WHERE model like ?", "text", $model);
            foreach($rows as $row) {
                $handler = $row['handler'];
                if(!$handler)
                    $handler = 'cw_model_mdm_formautocomplete';
                $inst = CW::getInst($handler);
                $inst->modelLoad($row['model'], $row['field'], $row['lookup'], $m);
            }

            echo CW_JSON::encode( array(
                "objId" => $m->getId(),
                "data" => $m->toArray()
            ));
        } catch(Exception $e) {
            echo CW_JSON::encode( array("isError" => true, "errorMsg" => $e->getMessage(), "trace" => $e->getTraceAsString() ) );
        }
    }
}

CW::register('page_handler', new IndexPageData());
