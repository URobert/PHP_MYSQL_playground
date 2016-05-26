<?php
namespace TestProject\Controller\County;

class Home {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];    
    }
    
    public function action(){
        $templating = $this->templating;
        
        return $templating('homeView', ['countylist'  =>  $this->getCountyList() ] );
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