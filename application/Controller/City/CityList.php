<?php
namespace TestProject\Controller\City;

class CityList {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];    
    }
    
    public function action(){
        $templating = $this->templating; 
        return $templating('cityView', ['cityList'  =>  $this->getCityList() ] );
    }
    
    function getCityList(){
        $cities = array();
        $requestCityList = "SELECT * FROM city";
        $returedList = $this->connect->query($requestCityList);
        #var_dump($returedList);
        foreach ($returedList as $city){
            $cities [] = array('id'=> $city['id'], 'name'=> $city['name']);
        }
        return $cities;
    }
}//end of countyList class
