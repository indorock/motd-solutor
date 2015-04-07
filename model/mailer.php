<?php

class Motd_Model_Mailer {

    public function send($to, $template, $params) {    

    	$tmps = array(
    		"doi" => array(
    			"subject" => "Bitte bestaetigen Sie ihre Email",
    			"msg" => " http://xxx.bsolut.com/doi/".$params["hash"]
    		),
    		
    	);

    	if(!isset($tmps[$template]))
    		return false;

    	$t = $tmps[ $template ];
    	return mail($to, $t["subject"], $t["msg"] );
    }
    
}

