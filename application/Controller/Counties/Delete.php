<?php

namespace TestProject\Controller\Counties;

class Delete {
    public function __construct($app){
        $this->connect = $app["connect"];
        $this->templating = $app["templating"];
    }
    
    
    public function action () {
        $sqlQuery = "Select * From city";
        
        $templating = $this->templating;
        $deleteQuery = "DELETE FROM city WHERE id=" . var_dump($_POST['id']);
        echo $deleteQuery;
        
        return $templating('manualCountyDelete', ['fullConent' => $this->connect->query($sqlQuery)]);         
    }
    
    public function delRow(){
        #$deleteQuery = "DELETE FROM city WHERE id=" . $_POST['id'];
        #echo $deleteQuery;
    }
    
}
