<?php

namespace TestProject\Controller\City;
use Symfony\Component\HttpFoundation\Request;

class AddCity {
    public function __construct($app){
        $this->connect = $app["connect"];
        $this->templating = $app["templating"];
    }
    
    public function action (Request $request) {
        $templating = $this->templating;
        if ($request->getMethod() === "POST"){
            
            // TEST FIELDS FOR NON-EMPTY AND LENGTH
             if  ( !$this->checkFields() )  { 
                echo '<script language="javascript">';
                echo 'alert("City filed can not be empty.")';
                echo '</script>'; 
             } else {
                // REFACTOR INSERT QUERIES`
                $checkCity = "SELECT * FROM city WHERE name=". "'" . $_POST['city']. "'" . " limit 1";
                $result = $this->connect->query($checkCity);
                if ($result->num_rows){
                    foreach ($result as $city){
                        $cityId = $city['id'];                                                          
                    }
                    echo "City ". $city['name'] . " already exists in DB.";
                }else{                        
                    echo $_POST['city'] . "City NOT FOUND." . "<br>";
                    $addNewCity = 'INSERT INTO city (name) VALUES ('
                     ."'"  . $_POST['city'] . "'" .')';
                    if ($this->connect->query($addNewCity) === TRUE) {
                        echo "City sucessfuly added:" . $_POST['city'] . "<br>";
                        $cityId = mysqli_insert_id($this->connect);
                    }
                }
                
             }
        }//end of POST method check
        return $templating('addCityView', [ 'cities' => $this->getCityList() ]);         
    }
    
    function checkFields(){         
         if ( empty($_POST['city']) ){
            return false;
         }
        return true;
    }
    
    function getCityList(){
        $cities = array();
        $requestCityList = "SELECT * FROM city";
        $returedList = $this->connect->query($requestCityList);
        foreach ($returedList as $city){
            $cities [] = array('id'=> $city['id'], 'name'=> $city['name']);
        }
        return $cities;
    }
} //end of class