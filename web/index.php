<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/',function (){
    return "OK.";}
    );

$app->get('/test',function (){
    return "WhAT?";}
    );

$app->get('/sqlConnect', function (){
    $link = mysqli_connect('localhost', 'root', 'cozacu','mysql');
        if (!$link) {
        die('Failed to connect: ' . mysql_error());
        }
    $returnMessage = 'Connection succesful!';
    #mysql_close($link); object given in /var/www/html/TestProject/web/index.php
    return $returnMessage;
    });

    
$app->run();