<?php

namespace TestProject\Controller\Test;

class Testing {
    
    public function __construct($app){
        #$this->what = $app['WHAT?'];
        $this->templating = $app['templating'];
    }
    
    public function action(){
    $what = 'WHAT?';
    $templating = $this->templating;
    return $templating('what',['whatKey' => $what]);
        
    }
}
