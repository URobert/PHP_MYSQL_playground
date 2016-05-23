<?php

namespace TestProject\Controller\Counties;

class Delete {
    public function __construct($app){
        $this->connect = $app["connect"];
        $this->templating = $app["templating"];
    }
    
    
    public function action () {
        $sqlQuery = 
        
        $templating = $this->templating;
        
        return $templating('manualCountyAdd', [null]);         
    }
}

