<?php

namespace TestProject\Controller\LandingPage;

class RandomIntro implements \TestProject\Controller\ControllerInterface {


    public function __construct($app) {
        $this->templating = $app['templating'];
    }
    
    public function action(){
    $numberArray = [];
        for ($i = 1; $i <= 100; $i++){
        $numberArray[] = [$i,rand(1,100)];
        }
        $templating = $this->templating;
        return $templating('template1', ['nrArray' => $numberArray]);
    }

}
