<?php

class SignupPageData extends Motd_Model_PageData {
    public $mainTpl = "campaigns/default.html";

    public function indexAction($request){
        $campaign = CW::model('campaign');
        if($campaign_id = (int)$request->getParam('campaign_id'))
            $campaign->load($campaign_id);
        else
            $campaign->getActiveCampaign($request);
        if(!$campaign->getId())
            throw new CW_Core_Exception_Ignore('No campaign found!');

        $template = "campaigns/".$campaign->getId().".html";
        if($this->getTpl()->tplFileExists($template)){
            $this->mainTpl = $template;
        }

        $this->assign('campaign', $campaign);
        if($errs = $request->getParam('errors')){
            $this->assign('errors', explode(',',$errs));
        }
    }

    public function postAction($request){
        $this->ignoreTemplate = true;

        $errors = array();

        if($request->isPost()){
            $email = $request->getParam('email');
            $agecheck = $request->getParam('agecheck');
            if($email=='' || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors[] = 'email';
            }elseif(!$agecheck){
                $errors[] = 'age';
            }
            if(!count($errors)){
                $user = CW::model('user');
                $user->loadByEmail($email);
                if (!$user->getId()) {
                    $user->setEmail($email);
                    $user->getExtData()->setCampaignId($request->getParam('campaign_id'));
                    $user->save('motd_signup');
                    $id = $user->getId();
                    $user->load($id); // reload user to get code
                }
                $ret = CW::model('emailtrigger')->send('doi',$email,false,$user);
                if($ret){
                    $this->redirect('signup?success=1');
                }
            }else{
                $this->redirect('signup?errors='.implode(',',$errors));
            }
        }else{
            $this->redirect('signup');
        }

    }
}

CW::register('page_handler', new SignupPageData());
