<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

//MAIN PAGE
$app->get('/',function (){
    return "OK.";}
    );

//TEST
$app->get('/test',function (){
    return "WhAT?";}
    );

//SQL CONNECT
$app->get('/sqlConnect', function (){
    $link = mysqli_connect('localhost', 'root', 'cozacu','mysql');
        if (!$link) {
        die('Failed to connect: ' . mysql_error());
        }
    $returnMessage = 'Connection succesful!';
    #mysql_close($link); object given in /var/www/html/TestProject/web/index.php
    return $returnMessage;
    });

//SQL Simple county import
$app->get('/addCounties', function (){
    $link = mysqli_connect('localhost', 'root', 'cozacu','test1');
    $returnMessage = "FFFFFFF.......";
    
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
       $fileContent = file_get_contents("judete.csv");
       $lines = explode("\n", $fileContent);
       
        for ($i=1; $i < count($lines) -1; $i++){
            $elements = explode(",", $lines[$i]);
            $sql = 'INSERT INTO county (name) VALUES (\'' . $elements[1] . '\')';
            echo "<br>";
            echo $sql;
            
    
            if (mysqli_query($link, $sql) === TRUE) {
                #printf("County added!\n");
                $returnMessage = "<br>"."Counties added to DB!" . "<br>";
            }       
        }
        return $returnMessage;
});

//SQL FILTERED County-City import (v2)
$app->get('/countyCityImport', function (){
    //CONNECTING TO DB
    $returnMessage = "FFFFFFF.......";
    $connect = mysqli_connect('localhost', 'root', 'cozacu','test1');
    if (!$connect) {
        die('Connection failed!' . mysql_error());
    }
    $returnMessage = "Connection was succesfull" . "<br>";
    
    //GETTING FILE CONTENT (TO BE IMPORTED) AND SEPARATING LINES
       $fileContent = file_get_contents("orase_judete.csv");
       $lines = explode("\n", $fileContent);
    
        foreach ($lines as $line){
            $elements = explode(",", $line);
            
            $checkCounty = "SELECT * FROM county WHERE name=". "'".trim($elements[1])."' limit 1";
            $resultCounty = $connect->query($checkCounty);
            if ($resultCounty){
                $temp_county_ID = $resultCounty->fetch_assoc()["id"];
                    if($temp_county_ID){
                        //ADD THE CITY INTO CITIES WITH GIVEN COUNTY_ID;
                        $checkCity = "SELECT * FROM city WHERE name="."'".trim($elements[0])."' limit 1";
                        $resultCity = $connect->query($checkCity)->fetch_assoc();
                        
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
});
$app->run();