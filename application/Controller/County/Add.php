<?php

namespace TestProject\Controller\County;
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
            
            // TEST FIELDS FOR NON-EMPTY AND LENGTH
             if  ( !$this->checkFields() )  { 
                echo '<script language="javascript">';
                echo 'alert("None of the fields can be empty. Use full names for both citites and counties.")';
                echo '</script>'; 
             } else {
                // REFACTOR INSERT QUERIES
                if ( (int)$_POST['countyid'] >= 0 ) {
                    $countyId = $_POST['countyid'];
                } else {
                    $checkCounty = "SELECT * FROM county WHERE name=". "'" . $_POST['county']. "'" . " limit 1";
                    $resultCounty = $this->connect->query($checkCounty);
                    if ($resultCounty->num_rows){
                        foreach ($resultCounty as $county){
                            $countyId = $county['id'];                                                          
                        }
                        echo "County already exists in DB.";
                    }else{                        
                        echo $_POST['county'] . "County NOT FOUND." . "<br>";
                        $addNewCounty = 'INSERT INTO county (name) VALUES ('
                         ."'"  . $_POST['county'] . "'" .')';
                        if ($this->connect->query($addNewCounty) === TRUE) {
                            echo "County sucessfuly added:" . $_POST['county'] . "<br>";
                            $countyId = mysqli_insert_id($this->connect);
                        }
                    }
                }
                //ADD THE CITY
               $checkCity = "SELECT * FROM city WHERE name='" . $_POST['city']. "' AND county_id =". $countyId . " limit 1";
               $resultCounty = $this->connect->query($checkCity);
                if ($resultCounty->num_rows){
                    echo "City already exists in DB."; 
                }else{
                    $addNewCity = 'INSERT INTO city (county_id,name) VALUES ('
                    . $countyId . ','
                    ."'"  . $_POST['city'] . "'" .')';
                    if ($this->connect->query($addNewCity) === TRUE) {
                       echo "City sucessfuly added:" . $_POST['city'] . "<br>";
                    }                          
                }
             }
        }//end of POST method check
        return $templating('manualCountyAdd', [ 'counties' => $this->getCountyList() ]);         
    }
    
    function checkFields(){
        
        if (empty($_POST['city'])){
             return false;
         }
         
         if ((int)$_POST['countyid'] <= 0
             && empty($_POST['county'])  ){
            return false;
         }
         
        return true;
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
} //end of class

