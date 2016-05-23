<?php

namespace TestProject\Controller\Counties;
use Symfony\Component\HttpFoundation\Request;

class Add {
    public function __construct($app){
        $this->templating = $app["templating"];
    }
    
    public function action (Request $request) {
        $templating = $this->templating;
        //echo "County: " . $_POST["county"]. "&";
        //echo "City: " . $_POST["city"] . "were added";
        var_dump($request->getMethod());
        if ($request->getMethod() === "POST"){
            var_dump($request->get("county"));
        }
        return $templating('manualCountyAdd', [null]);         
    }
}

