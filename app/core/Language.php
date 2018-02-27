<?php

namespace App\Core;

class Language extends \App\Core\Controller{

    protected $languages    = [];

    public function __construct($languages){
        
        $this->langModel = $this->model('Language');
        
        $this->languages = $languages;

        foreach($this->languages as $lang){
            $this->$lang = [];
        }
    }

    public function getAll(){

        $langs = $this->langModel->getAll();

        if ($langs && isset($langs) && !empty($langs)){

            foreach($langs as $lang){
                foreach($this->languages as $l){
                    $this->$l[$lang->lang_key] = $lang->$l;          
                }
            }
        }

        $this->writeToFile();
    }

    private function writeToFile(){

        foreach($this->languages as $lang_file){

            $file = '..' . DS . 'app' . DS . 'cache' . DS . 'lang' . DS . $lang_file . DS . 'lang.txt';
            
            $handler = fopen($file,'w');
        
            foreach($this->$lang_file as $k => $v){
                $row = $k . '=' . $v . ';';
                fwrite($handler,$row);
            }

            fclose($handler);
        }
    }
}