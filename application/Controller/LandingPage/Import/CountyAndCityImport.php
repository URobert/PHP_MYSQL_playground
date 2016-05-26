<?php

namespace TestProject\Controller\Import;

class CountyAndCityImport implements \TestProject\Controller\ControllerInterface {
    
    protected $connect;
    protected $source_file = "orase_judete.csv";
    
    public function __construct($app){
        $this->connect = $app['connect'];
    }
    

    public function action() {    
        //GETTING FILE CONTENT (TO BE IMPORTED) AND SEPARATING LINES
    $fileContent = file_get_contents($this->source_file);
    $lines = explode("\n", $fileContent);
    $returnMessage= "";
    
        foreach ($lines as $line){
        $elements = explode(",", $line);
        
        $checkCounty = "SELECT * FROM county WHERE name=". "'".trim($elements[1])."' limit 1";
        $resultCounty = $this->connect->query($checkCounty);
            if ($resultCounty){
                $temp_county_ID = $resultCounty->fetch_assoc()["id"];
                    if($temp_county_ID){
                        //ADD THE CITY INTO CITIES WITH GIVEN COUNTY_ID;
                        $checkCity = "SELECT * FROM city WHERE name="."'".trim($elements[0])."' limit 1";
                        $resultCity = $this->connect->query($checkCity)->fetch_assoc();
                        
                        if ($resultCity){
            $returnMessage .= $elements[0] . " already exists." . "<br>";
            
                        }else{ //CITY NOT IN DB
                            $addNewCity = 'INSERT INTO city (county_id,name) VALUES ('
                             . $temp_county_ID . ','
                           ."'"  . trim($elements[0]) . "'" .')';
                           if ($connect->query($addNewCity) === TRUE) {
            $returnMessage .="City sucessfuly imported:" . $elements[0] . "<br>";
                           }
                        }
                                         
                    }else{ //COUNTY NOT IN DB
            $returnMessage .= $elements[1] . "County NOT FOUND." . "<br>";
                        $addNewCounty = 'INSERT INTO county (name) VALUES ('
                           ."'"  . trim($elements[1]) . "'" .')';
                           if ($connect->query($addNewCounty) === TRUE) {
            $returnMessage .= "County sucessfuly imported:" . $elements[1] . "<br>";
                           }
                           //ADD THE CITY
                           $temp_county_ID = mysqli_insert_id($connect);
                           $addNewCity = 'INSERT INTO city (county_id,name) VALUES ('
                             . $temp_county_ID . ','
                           ."'"  . trim($elements[0]) . "'" .')';
                           if ($connect->query($addNewCity) === TRUE) {
            $returnMessage .= "City sucessfuly imported:" . $elements[0] . "<br>";
                           }
                        }
            }
        }
    return $returnMessage;
    }

}