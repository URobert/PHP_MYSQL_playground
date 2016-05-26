<?php
namespace TestProject\Controller\County;

class Edit {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];    
    }
    
    public function action(){
        print_r($_GET);
        $templating = $this->templating;
        
        return $templating('countyListView', ['countylist'  =>  $this->getCountyList() ] );
    }
    
    function getCountyList(){
        $counties = array();
        $requestCountyList = "SELECT * FROM county";
        $returedList = $this->connect->query($requestCountyList);
        #var_dump($returedList);
        foreach ($returedList as $county){
            $counties [] = array('id'=> $county['id'], 'name'=> $county['name']);
        }
        return $counties;
    }
    
    function displayCityList($county){
        
    } 
    
}//end of countyList class









?>