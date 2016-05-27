<?php
namespace TestProject\Controller\City;
use Symfony\Component\HttpFoundation\Request;

class CityList {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];    
    }
    
    public function action(Request $request){
        $id = $request->get('id');
        $templating = $this->templating; 
        return $templating('cityListView', ['cityList'  =>  $this->getCityList($id) ,
                                            'countyId' => $id ] );
    }
    
    function getCityList($id){
        $cities = array();
        $requestCityList = "SELECT * FROM city WHERE county_id=" . $id;
        $returedList = $this->connect->query($requestCityList);
        foreach ($returedList as $city){
            $cities [] = array('id'=> $city['id'], 'name'=> $city['name']);
        }
        return $cities;
    }
}//end of countyList class
