<?php

namespace TestProject\Controller\Counties;

class action_page {
    public function __construct($app){
    }
    
    public function action () {
        echo "County: " . $_POST["county"]. "&";
        echo "City: " . $_POST["city"] . "were added";
       
    }
}

 ?>