<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$connect = mysqli_connect('localhost','root','cozacu','test1');

if (!$connect){
    die('Failed to connect.' . mysql_error());
};
$returnMessage = 'Connection established!' . '<br>';

//====================================MAIN PAGE
$app->get('/',function (){
    $numberArray = [];
    for ($i = 1; $i <= 100; $i++){
        $numberArray[] = [$i,rand(1,100)];
    }

    return templating('template1', ['nrArray' => $numberArray]);
    });

function templating ($path, $arguments) {
    ob_start();
    extract($arguments);
    require sprintf('../views/%s.php',$path);
    $res = ob_get_clean();
    return $res;
}

//=====================================TEST
$app->get('/testing',function (){
    $what = 'WHAT?';
    return templating ('what',['whatKey' => $what]);
    });

    function templatingWhat ($path, $arguments) {
        ob_start();
        extract($arguments);
        require sprintf('..views/%s.php',$path);
        $res = ob_get_clean();
        return $res;               
        }

    
//=================================SQL CONNECT
$app->get('/sqlConnect', function (){
    $link = mysqli_connect('localhost', 'root', 'cozacu','mysql');
        if (!$link) {
        die('Failed to connect: ' . mysql_error());
        }
    $returnMessage = 'Connection succesful!';
    #mysql_close($link); object given in /var/www/html/TestProject/web/index.php
    return $returnMessage;
    });


//==================================SQL Simple county import
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


//=============================SQL FILTERED County-City import (v2)
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


//==============================WIKIFILE IMPORT importWiki.php
$app->get('/wikiImport', function (){
    //CONNECTING TO DB
    $connect = mysqli_connect('localhost', 'root', 'cozacu','test1');
    $returnMessage = "FFFFFFF.......";
        if (!$connect) {
            die('Connection failed!' . mysql_error());
        }
    $returnMessage = 'Connection was succesful!' . '<br>';
    
    //GETTING FILE CONTENT (TO BE IMPORTED) AND SEPARATING LINES
        $myfile =  fopen("test", "r") or die("Sorry mate, can't open your file.");
        $count = 0;
        while(null != ($line = fgets($myfile)) && $count <= 30) {
                $count++; 
                //echo fgets($myfile) . "<br>";
                $element = explode(" ", $line);
                
    $returnMessage .= $element[1] . "<br>";
                $sql = 'INSERT INTO wikidata (domain, main_page, clicks, size) VALUES (
                \'' . $element[0] . '\',
                \'' . $element[1] . '\',
                \'' . $element[2] . '\',
                \'' . $element[3] . '\')';
                
            if (mysqli_query($connect, $sql) === TRUE) {
    $returnMessage .= "Wiki info updated to DB" . "<br>";
            }
        }
    return $returnMessage;
    });


//=========================MOST POPULAR PAGE/DOMAIN mostPopularBeta.php
$app->get('/mostPopular', function () use($connect){

    $sqlDomains ='SELECT domain,main_page, clicks
    FROM (SELECT * FROM wikidata ORDER by clicks DESC) AS T
    GROUP BY domain
    ORDER BY clicks DESC LIMIT 10';
    
    $result  = $connect->query($sqlDomains);
    
    return templatingMostPopular('mpPageTemplate', ['domains' => $result]);

    });

    function templatingMostPopular ($path, $arguments) {
        ob_start();
        extract($arguments);
        require sprintf('../views/%s.php',$path);
        $res = ob_get_clean();
        return $res;               
        }

//=========================Highest Bandwidth Usage H_B_Usage.php
$app->get('/highestBandwithUsage', function (){
    $returnMessage= "FFFFFFF.....";
            $connect = mysqli_connect('localhost', 'root', 'cozacu', 'test1');
            if (!$connect){
                die('Connection failed, mate.' . mysql_error());
            }else{
    $returnMessage = 'Connection established !' . '<br>';
            }
                $sqlQuery3 = 'SELECT id, SUBSTR(CONCAT(domain,".",main_page),1,10) Domain_MainPage,
            CASE
            WHEN (Round(cs / Pow(1024, 4), 2)> 1) THEN CONCAT(Round(cs / Pow(1024, 4), 2)," ","TB")
            WHEN (Round(cs / Pow(1024, 3), 2)> 1) THEN CONCAT(Round(cs / Pow(1024, 3), 2)," ","GB")
            WHEN (Round(cs / Pow(1024, 2), 2)> 1) THEN CONCAT(Round(cs / Pow(1024, 2), 2)," ","MB")
            ELSE NULL
            END AS SIZE
            FROM
            (SELECT id,domain,main_page,Sum(clicks * size) AS CS 
            FROM wikidata GROUP BY main_page) AS W
            ORDER BY CS DESC limit 20';
            
            $result3= $connect->query($sqlQuery3);
    $returnMessage .= '<br>' . 'ID'. ' Page'. ' Size' . '<br>';
            while($row = $result3->fetch_assoc()){
    $returnMessage .= $row['id'] . " " . $row['Domain_MainPage'] . " " . $row['SIZE'] . " " . "<br>";
            }
            return $returnMessage;
});

//=========================Display MAX temperature by County and City
$app->get('/temperature', function (){
    $returnMessage = "FFFFFF....";
    
    $connect = mysqli_connect('localhost', 'root', 'cozacu', 'test1');
        if (!$connect){
                die('Connection failed, mate.' . mysql_error());
        }else{
    $returnMessage = 'Connection established !' . '<br>';
    
        $temperatureQuery = 'Select * FROM
                (SELECT temperature.city_id, county.id AS countyID, county.name AS nameCounty, city.name, temperature.date, temperature.value
                FROM temperature, city, county
                WHERE temperature.city_id=city.id
                AND city.county_id=county.id
                ORDER BY value DESC) AS T
                GROUP BY countyID';
    
        $result = $connect->query($temperatureQuery);
        while($endResult = $result->fetch_assoc()){
        $returnMessage .= 'City ID: '. $endResult["city_id"] . '<br>' . 
                          'County ID: '. $endResult["countyID"] . '<br>' .
                          'County Name: ' . $endResult["nameCounty"] . '<br>' .
                          'City: ' . $endResult["name"] . '<br>' .
                          'Date: ' . $endResult["date"] . '<br>' .
                          '<strong>Temperature: ' . $endResult["value"]. '</strong><br>';
        }            
        }
    return $returnMessage;
    });

//==============================Counties and Cities - multiple queries
$app->get('/counties-and-cities', function (){
    $returnMessage = "FFFFFF....";    
    
        $connect = mysqli_connect('localhost', 'root', 'cozacu', 'test1');
        if (!$connect){
                die('Connection failed, mate.' . mysql_error());
        }else{
    $returnMessage = 'Connection established !' . '<br>';
    
    $returnMessage = 'Numar orase per judet:' . '<br>';
        $citiesInCounties = 'SELECT county.id, county.name countyName, COUNT(*) nrCities
                            FROM county
                            INNER JOIN city ON county.id=city.county_id
                            GROUP BY county.name';
         
         
        $citiesWithNoCounty = 'SELECT city.id, city.name, county.name countyNAME
        FROM county RIGHT JOIN city ON county.id=city.county_id WHERE city.county_id IS NULL';
        
        $countiesWithNoCities = 'SELECT county.id, county.name countyNAME, city.name
        FROM county LEFT JOIN city ON county.id=city.county_id WHERE city.name IS NULL';
        
        $countiesWithMoreThanTwoCities = 'SELECT county.id, county.name countyName, COUNT(*) nrCities
        FROM county RIGHT JOIN city ON county.id=city.county_id
        GROUP BY county.name HAVING COUNT(*) >= 2 AND countyName IS NOT NULL';
        
         $result = $connect->query($citiesInCounties);
         while ($endResult = $result->fetch_assoc()){
         $returnMessage .= $endResult["countyName"]. " " . $endResult["nrCities"] . "<br>";
         }
         
         $returnMessage .= '<br>' . 'Orase fara judete asignate: ' . '<br>';
         $result = $connect->query($citiesWithNoCounty);
         while ($endResult = $result->fetch_assoc()){
         $returnMessage .= $endResult["id"]. " " . $endResult["name"] . "<br>";
         }
         
         $returnMessage .= '<br>' . 'Judete fara orase asignate: ' . '<br>';
         $result = $connect->query($countiesWithNoCities);
         while ($endResult = $result->fetch_assoc()){
         $returnMessage .= $endResult["id"]. " " . $endResult["countyNAME"] . "<br>";
         }
         
         $returnMessage .= '<br>' . 'Judete cu doua sau mai multe orase: ' . '<br>';
          $result = $connect->query($countiesWithMoreThanTwoCities);
         while ($endResult = $result->fetch_assoc()){
         $returnMessage .= $endResult["countyName"]. " " . $endResult["nrCities"] . "<br>";
         }
         
        }
        
        return $returnMessage;
    });
    
$app->run();