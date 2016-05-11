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
$app->run();