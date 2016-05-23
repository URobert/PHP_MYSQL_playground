<?php

namespace TestProject\Controller\Counties;

class Add {
    public function __construct($app){
        $this->templating = $app["templating"];
    }
    
    public function action () {
        $templating = $this->templating;
        
        return $templating('manualCountyAdd', [null]);         
    }
}

