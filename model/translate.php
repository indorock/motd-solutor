<?php

class Motd_Model_Translate extends CW_Model_Translate{

    public $default_values = array(
        'ns' => 'core',
        'lang' => 'en',
        'txt' => 'translation_tag',
        'val' => '**Translated Text Here**'
    );

    public $can_delete = true;

}