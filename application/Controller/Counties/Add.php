<?php

namespace TestProject\Controller\Counties;
use Symfony\Component\HttpFoundation\Request;

class Add {
    public function __construct($app){
        $this->connect = $app["connect"];
        $this->templating = $app["templating"];
    }
    
    public function action (Request $request) {
        #getCountyList();
        $templating = $this->templating;
        #var_dump($request->getMethod());
        if ($request->getMethod() === "POST"){
            $toBeAddedCounty = $request->get("county");
            $toBeAddedCity = $request->get("city");
            
            // TEST FIELDS FOR NON-EMPTY AND LENGTH
             if  ( $this->checkFields()
                  || strlen($toBeAddedCounty) < 3
                  || strlen($toBeAddedCity) < 3)  { 
                echo '<script language="javascript">';
                echo 'alert("None of the fields can be empty. Use full names for both citites and counties.")';
                echo '</script>'; 
             } else {
                
                //CONTINUE WITH CODE 
                $checkCounty = "SELECT * FROM county WHERE name=". "'" . $toBeAddedCounty . "'" . " limit 1";
                $resultCounty = $this->connect->query($checkCounty);
                if ($resultCounty){
                    $temp_county_ID = $resultCounty->fetch_assoc()["id"];
                    if ($temp_county_ID) {
                            //ADD THE CITY INTO CITIES WITH GIVEN COUNTY_ID;
                            $checkCity = "SELECT * FROM city WHERE name="."'".$toBeAddedCity."' limit 1";
                            $resultCity = $this->connect->query($checkCity)->fetch_assoc();
                            
                            if ($resultCity){
                                echo "City: ". $toBeAddedCity. " already exists." . "<br>";
               
                            }else{ //CITY NOT IN DB
                                  $addNewCity = 'INSERT INTO city (county_id,name) VALUES ('
                                  . $temp_county_ID . ','
                                  ."'"  . $toBeAddedCity . "'" .')';
                                 if ($this->connect->query($addNewCity) === TRUE) {
                                    echo "City sucessfuly added:" . $toBeAddedCity . "<br>";
                                 }
                              }
                                             
                          }else{ //COUNTY NOT IN DB
                                echo $toBeAddedCounty . "County NOT FOUND." . "<br>";
                                $addNewCounty = 'INSERT INTO county (name) VALUES ('
                                 ."'"  . $toBeAddedCounty . "'" .')';
                                 if ($this->connect->query($addNewCounty) === TRUE) {
                                echo "County sucessfuly added:" . $toBeAddedCounty . "<br>";
                                }
                                 //ADD THE CITY
                                 $temp_county_ID = mysqli_insert_id($this->connect);
                                 $addNewCity = 'INSERT INTO city (county_id,name) VALUES ('
                                  . $temp_county_ID . ','
                                  ."'"  . $toBeAddedCity . "'" .')';
                                 if ($this->connect->query($addNewCity) === TRUE) {
                                    echo "City sucessfuly added:" . $toBeAddedCity . "<br>";
                                }
                            }
                }
             }
        }//end of POST method check
        $finalCountyList = $this->getCountyList();
        return $templating('manualCountyAdd', [ 'fullCountyList' => $finalCountyList ]);         
    }
    
    function checkFields(){
        $requiredFields = array('county', 'city');
        $errorCheck =  false;
        foreach ($requiredFields as $field){
            if (empty($_POST[$field])){
                $errorCheck = true;
            }
        }
        return $errorCheck;
    }
    
    function getCountyList(){
        $countyList = array();
        $requestCountyList = "SELECT * FROM county";
        $returedList = $this->connect->query($requestCountyList);
        #var_dump($returedList);
        foreach ($returedList as $county){
            $countyList [] = $county['name'];
        }
        return $countyList;
    }
} //end of class

