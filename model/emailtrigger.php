<?php

class Motd_Model_Emailtrigger extends CW_Core_DBEntity {

    protected $table = "emailtemplates";

    public function loadByName($name) {
        return $this->doLoad(" WHERE name like :name", null, array("name" => $name));
    }

    public function getActiveTemplates() {
        $rows = CW::sql()->query("SELECT name, variants FROM ".$this->table." WHERE active=1 order by ord");
        if(!$rows)
            return array();
        $res = array();
        foreach ($rows as $row) {
            $template = CW::model('emailtrigger');
            $t = $template->loadByName($row['name']);
            $res[$row['name']] = array('base' => $t);
            if($row['variants']){
                $variants = json_decode($row['variants'],true);
                $res[$row['name']]['variants'] = $variants;
            }
        }
        return $res;
    }

    public function getTemplate($default) {
        $res = parent::getTemplate($default);
        if (!$res)
            $res = $this->getName();
        return $res;
    }

    public function getTitle($default) {
        $res = parent::getTitle($default);
        if (!$res)
            $res = $this->getName();
        return $res;
    }

    public function getLangpre($default) {
        $res = parent::getLangpre($default);
        if (!$res)
            $res = $this->getName();
        return $res;
    }

    function getEmailTemplate($name) {
        $entry = $this->loadByName($name);
        if (!$entry->getId())
            return false;

        return $entry->getTemplate($name);
    }

    //---- Events
    public function onUserCreate($user) {
        $this->send('doi',$user->getEmail(), array(),$user);
    }

    //---- Actions

    public function send($name,$to,$inparams=false,$object = false) {
        $template = $this->getEmailTemplate($name);
        if (!$template)
            throw new Exception('missing email template');
        $langpre = $this->getLangpre(false);
        $params = $this->getParams($name,$to,$inparams,$object);
        if (is_array($inparams))
            $params = array_merge($params,$inparams);
        return CW::getSingleton('mailer')->sendFromTemplate($template, $to, $params,false,$langpre);
    }

    public function getParams($name,$to,$inparams,$object) {
        $res = array();

        switch($name){
            case 'doi':
            case 'doi_confirm':
                $doilink = 'samplelink';
                if ($object) {
                    $doilink = checkPathSep(CW::cfg()->getSetting('BASEURL_NO_LANG_HTTPS'). CW::cfg()->getBasedir()) ."doi/".$object->getCode()."_".sha1($object->getEmail());
                }
                $res = array('actionlink' => $doilink);
                break;
        }
        return $res;
    }

}