<?php

class Motd_Model_Mailer extends CW_Core_Mail_Mailer {

    public function sendFromTemplate($template, $to, $params=array(), $translate_params=null, $langpre=false){
        if(!$template)
            return false;

        try{
            $emailTpl = CW::model('emailtemplate', 'emails/' . $template . '.html');
            $emailTpl->assign("cdnroot", CW::cfg()->getCdnroot(null));
            $emailTpl->assign('date', CW::getNow()->format('d/m/Y'));
            foreach($params as $k => $v){
                $emailTpl->assign($k, $v);
            }
            $trans = CW::getSingleton('core/translate');

            $from = CW::getSetting('from_email_address', 'test@unirkn.test');
            $fromname = CW::getSetting('from_email_name', 'Unikrn');

            if(!$translate_params) // NB: no objects allowed within $translate_params array
                $translate_params = $params;

            $subject = CW__($langpre . '_subject', $translate_params, 'email', false, 'Subject missing');
            $tId = $trans->addDefaultParameter($params);

            if(CW::isConsole())
                $emailTpl->assign('skinroot', CW::cfg()->getSetting('cron_skinroot'));

            $emailTpl->assign("cdnroot_static", CW::cfg()->getCdnrootStatic($emailTpl->getAssign('skinroot') . 'static/'));
            if(!$langpre)
                $langpre = $template;
            $emailTpl->assign("langpre", $langpre);

            $msg = $emailTpl->toString();

            $this->SendRawMail(Array('to' => $to, 'body' => $msg, 'subject' => $subject, 'from' => $from, 'fromname' => $fromname, 'ishtml' => true));
            $trans->removeDefaultParameter($tId);
            return true;

        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}

