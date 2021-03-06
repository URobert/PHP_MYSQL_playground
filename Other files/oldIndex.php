<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;
$connect = mysqli_connect('localhost','root','cozacu','test1');

    if (!$connect){
        throw new Exception('Failed to connect.' . mysql_error());
    };

$app['connect'] = $connect;
$app['templating'] = 'templating';

function templating ($path, $arguments) {
    ob_start();
    extract($arguments);
    require sprintf('../views/%s.php',$path);
    $res = ob_get_clean();
    return $res;
}

//==================================== 1. MAIN PAGE (random NR.)
    $app->get('/',function () use($app){
        $numberArray = [];
        for ($i = 1; $i <= 100; $i++){
            $numberArray[] = [$i,rand(1,100)];
        };
        return $app['templating']('template1', ['nrArray' => $numberArray]);
    });
    #$toBeReturned = $app->get('/', array(new TestProject\Controller\LandingPage\randomIntro, 'action'));
    #print_r($toBeReturned);
    #return $app['templating']('template1', ['nrArray' => $toBeReturned]);
    #});}

//=====================================2. TEST (what)
$app->get('/testing',function () use($app){
    $what = 'WHAT?';
    return $app['templating']
    ('what',['whatKey' => $what]);
    });
    
//=================================3.SQL CONNECT (simple connect)
$app->get('/sqlConnect', array(new TestProject\Controller\mySQLConnect\Connect($app), 'action'));

//==================================4. SQL Simple county import (county import)
$app->get('/addCounties', array(new TestProject\Controller\Import\Location($app), 'action'));

//============================= 5. SQL FILTERED County-City import (v2)

$app->get('/addCounties', array(new TestProject\Controller\Import\Location($app), 'action'));
//$app->get('/countyCityImport', function () use($connect){
//    //CONNECTING TO DB
//    $returnMessage = "FFFFFFF.......";
//    $connect = mysqli_connect('localhost', 'root', 'cozacu','test1');
//    if (!$connect) {
//        die('Connection failed!' . mysql_error());
//    }
//    $returnMessage = "Connection was succesfull" . "<br>";
//    
//    //GETTING FILE CONTENT (TO BE IMPORTED) AND SEPARATING LINES
//       $fileContent = file_get_contents("orase_judete.csv");
//       $lines = explode("\n", $fileContent);
//    
//        foreach ($lines as $line){
//            $elements = explode(",", $line);
//            
//            $checkCounty = "SELECT * FROM county WHERE name=". "'".trim($elements[1])."' limit 1";
//            $resultCounty = $connect->query($checkCounty);
//            if ($resultCounty){
//                $temp_county_ID = $resultCounty->fetch_assoc()["id"];
//                    if($temp_county_ID){
//                        //ADD THE CITY INTO CITIES WITH GIVEN COUNTY_ID;
//                        $checkCity = "SELECT * FROM city WHERE name="."'".trim($elements[0])."' limit 1";
//                        $resultCity = $connect->query($checkCity)->fetch_assoc();
//                        
//                        if ($resultCity){
//    $returnMessage .= $elements[0] . " already exists." . "<br>";
//    
//                        }else{ //CITY NOT IN DB
//                            $addNewCity = 'INSERT INTO city (county_id,name) VALUES ('
//                             . $temp_county_ID . ','
//                           ."'"  . trim($elements[0]) . "'" .')';
//                           if ($connect->query($addNewCity) === TRUE) {
//    $returnMessage .="City sucessfuly imported:" . $elements[0] . "<br>";
//                           }
//                        }
//                                         
//                    }else{ //COUNTY NOT IN DB
//    $returnMessage .= $elements[1] . "County NOT FOUND." . "<br>";
//                        $addNewCounty = 'INSERT INTO county (name) VALUES ('
//                           ."'"  . trim($elements[1]) . "'" .')';
//                           if ($connect->query($addNewCounty) === TRUE) {
//    $returnMessage .= "County sucessfuly imported:" . $elements[1] . "<br>";
//                           }
//                           //ADD THE CITY
//                           $temp_county_ID = mysqli_insert_id($connect);
//                           $addNewCity = 'INSERT INTO city (county_id,name) VALUES ('
//                             . $temp_county_ID . ','
//                           ."'"  . trim($elements[0]) . "'" .')';
//                           if ($connect->query($addNewCity) === TRUE) {
//    $returnMessage .= "City sucessfuly imported:" . $elements[0] . "<br>";
//                           }
//                        }
//            }
//        }
//    return $returnMessage;
//});


//==============================6. WIKIFILE IMPORT (importWiki.php)
$app->get('/wikiImport', function () use($connect){
    //CONNECTING TO DB
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


//=========================7. MOST POPULAR PAGE/DOMAIN mostPopularBeta.php
$app->get('/mostPopular', function () use($connect){

    $sqlDomains ='SELECT domain,main_page, clicks
    FROM (SELECT * FROM wikidata ORDER by clicks DESC) AS T
    GROUP BY domain
    ORDER BY clicks DESC LIMIT 10';
    
    $result  = $connect->query($sqlDomains);
    return templating('mpPageTemplate', ['domains' => $result]);

    });

//=========================8. Highest Bandwidth Usage H_B_Usage.php
$app->get('/highestBandwithUsage', function () use ($connect){
    $returnMessage = 'Connection established !' . '<br>';
    
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
    return templating('highestUsageB', ['fullContent' => $result3]);
    });

//=========================9. Display MAX temperature by County and City
$app->get('/temperature', function () use ($connect) {
       /*$temperatureQuery = 'Select * FROM
               (SELECT temperature.city_id, county.id AS countyID, county.name AS nameCounty, city.name, temperature.date, temperature.value
               FROM temperature, city, county
               WHERE temperature.city_id=city.id
               AND city.county_id=county.id
               ORDER BY value DESC) AS T
               GROUP BY countyID';*/       
        
        $temperatureQuery ='SELECT * 
                            FROM   (SELECT *, 
                                           ROUND(Max(T.temp),2) AS MAX_TEMP 
                                    FROM   (SELECT county.NAME       AS County, 
                                                   city.NAME         AS CITY, 
                                                   temperature.date  AS DATE, 
                                                   temperature.value AS TEMP 
                                            FROM   city, 
                                                   county, 
                                                   temperature 
                                            WHERE  city.id = temperature.city_id 
                                                   AND county.id = city.county_id 
                                            ORDER  BY temperature.value DESC) AS T 
                                    GROUP  BY T.county, 
                                              T.city, 
                                              T.date, 
                                              T.temp 
                                    ORDER  BY T.temp DESC) AS TT 
                            GROUP  BY TT.county';
    return templating('temperatureTemplate',['fullConent' => $connect->query($temperatureQuery)]);
    });

//==============================10. Counties and Cities - multiple queries
$app->get('/counties-and-cities', function () use ($connect){
    
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
        
        return templating('countyTemplate',
                              ['citiesInCouties' => $connect->query($citiesInCounties),
                               'citiesWithNoCounty'=> $connect->query($citiesWithNoCounty),
                               'countiesWithNoCities'=> $connect->query($countiesWithNoCities),
                               'countiesWithMoreThanTwoCities' =>$connect->query($countiesWithMoreThanTwoCities)]);
    });

$app->run();