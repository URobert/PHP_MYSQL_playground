<?php

namespace TestProject\Controller\County;
use Symfony\Component\HttpFoundation\Request;

class AddCounty {
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
                echo 'alert("County filed can not be empty.")';
                echo '</script>'; 
             } else {
                // REFACTOR INSERT QUERIES
                $checkCounty = "SELECT * FROM county WHERE name=". "'" . $_POST['county']. "'" . " limit 1";
                $resultCounty = $this->connect->query($checkCounty);
                if ($resultCounty->num_rows){
                    foreach ($resultCounty as $county){
                        $countyId = $county['id'];                                                          
                    }
                    echo "County ". $county['name'] . " already exists in DB.";
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
        }//end of POST method check
        return $templating('addCountyView', [ 'counties' => $this->getCountyList() ]);         
    }
    
    function checkFields(){         
         if ( empty($_POST['county']) ){
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

