<?php

class Motd_Model_User extends CW_Model_Share_User{

    protected function _beforeSave(&$changedData, $action){
        $res = parent::_beforeSave($changedData, $action);
        if($res === false) return false;
        if($action === self::ACTN_INSERT)
            $this->setRegisterIp( ip2long(CW::getRemoteAddr(false)) );
        return $res;
    }

    public function handleDoi($request){
        $hash = $request->getParam(0);
        if(!$hash || strpos($hash, '_')===false)
            throw new CW_Core_Exception_Ignore('Missing or invalid DOI key supplied');
        $parts = explode('_', $hash);
        if(count($parts) != 2)
            throw new CW_Core_Exception_Ignore('Missing or invalid DOI key supplied');

        $this->loadBy(array('code'=>$parts[0]));
        if(!$this->getId())
            throw new CW_Core_Exception_Ignore('Invdalid DOI key supplied');
        if($parts[1] != sha1($this->getEmail()))
            throw new CW_Core_Exception_Ignore('Invalid DOI key supplied');

        $already_doied = false;

        if(strtotime($this->getDoiAt())>0){
            $already_doied = true;
        }else{
            $this->setDoiAt(CW::getNow()->format('Y-m-d H:i:s'));
            $this->save('doi');
        }

        $countrycode = null;
        if(function_exists('geoip_country_code_by_name'))
            $countrycode = strtolower(geoip_country_code_by_name($request->getRemoteAddr()));

        $params = array('already_doied'=>$already_doied, 'user_country'=>strtolower($countrycode));
        CW::getSingleton('emailtrigger')->send('doi_confirm',$this->getEmail(),$params,$this);

        return array('already_doied'=>$already_doied);
    }

}