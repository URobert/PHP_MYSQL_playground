<?php

namespace TestProject\Controller\mySQLConnect;

class Connect{
    protected $connect;
    
 public function action(){
        $message = "Connection was established!";
        return $message;
    }
    
}