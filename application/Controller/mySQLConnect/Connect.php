<?php

namespace TestProject\Controller\mySQLConnect;

class Connect implements \TestProject\Controller\ControllerInterface {
    protected $connect;

    public function __construct($app){
        
    }
    
    public function action(){
        $message = "Connection was established!";
        return $message;
    }
} 