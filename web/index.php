<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.12.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$connect = mysqli_connect('localhost','root','cozacu','test1');

    if (!$connect){
        throw new Exception('Failed to connect.' . mysql_error());
    };

$app = new Silex\Application();
$app['debug'] = true;
$app['connect'] = $connect;
$app['templating'] = 'templating';

function templating ($path, $arguments) {
    ob_start();
    extract($arguments);
    require sprintf('../views/%s.php',$path);
    $res = ob_get_clean();
    return $res;
}

//==================================1. MAIN PAGE (random NR.)
$app->get('/', array(new TestProject\Controller\LandingPage\RandomIntro($app), 'action'));

//==================================2. TEST (what)
$app->get('testing', array(new TestProject\Controller\Test\Testing($app), 'action'));
    
//==================================3.SQL CONNECT (simple connect)
$app->get('/sqlConnect', array(new TestProject\Controller\mySQLConnect\Connect($app), 'action'));

//==================================4. SQL Simple county import (county import)
$app->get('/addCounties', array(new TestProject\Controller\Import\Location($app), 'action'));

//==================================5. SQL FILTERED County-City import (v2)
$app->get('/countyCityImport', array(new TestProject\Controller\Import\CountyAndCityImport($app), 'action'));

//==================================6. WIKIFILE IMPORT (importWiki.php)
$app->get('/wikiImport', array(new TestProject\Controller\Import\WikiImport($app), 'action'));

//==================================7. MOST POPULAR PAGE/DOMAIN mostPopularBeta.php
$app->get('/mostPopular', array(new TestProject\Controller\Statistics\MostPopularPage($app), 'action'));

//==================================8. Highest Bandwidth Usage H_B_Usage.php
$app->get('/highestBandwithUsage', array(new TestProject\Controller\Statistics\HighestBWUsage($app), 'action'));

//==================================9. Display MAX temperature by County and City
$app->get('/temperature',array(new TestProject\Controller\Statistics\MaxTemperature($app), 'action'));

//=================================10. Counties and Cities - multiple queries
$app->get('/counties-and-cities', array(new TestProject\Controller\Statistics\County_City_Stats($app), 'action'));

$app->run();