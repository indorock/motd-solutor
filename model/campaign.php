<?php

class Motd_Model_Campaign extends CW_Core_DBEntity{

    protected $table = 'campaign';
    protected $idFld = "id";

    public function getActiveCampaign(){
        $campaign = $this->loadBy(array('active'=>1),'ORDER BY created_at DESC');
        if(!$campaign->getId())
            throw new CW_Core_Exception_Ignore('No active campaign found!');

        return $campaign;
    }

}