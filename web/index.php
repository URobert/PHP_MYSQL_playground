<?php
session_start();
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

$connect = mysqli_connect('localhost','root','cozacu','test1');

    if (!$connect){
        throw new Exception('Failed to connect.' . mysql_error());
    };

$app = new Silex\Application();
$app['debug'] = true;
$app['connect'] = $connect;

$parser = new Symfony\Component\Yaml\Parser();
$routes = $parser->parse(file_get_contents(__DIR__.'/../config/routes.yml'));

//if (isset($_SESSION['userId'])){
//    foreach ($routes as $route){
//        $app->{$route["method"]}($route["url"], function(Request $request) use($route, $app) {
//            $reflection = new ReflectionClass("TestProject\\Controller\\" . $route["controller"]);
//            $instance = $reflection->newInstance($app);
//            $instance->setRouteInformation($route);
//            $action =  isset($route['function']) ? $route['function'] . 'Action' : 'action';
//            return $instance->{$action}($request);
//        });
//    }    
//}else{
//    $app->{$routes[0]["method"]}($routes[0]["url"], function(Request $request) use($routes, $app) {
//         $reflection = new ReflectionClass("TestProject\\Controller\\" . $routes[0]["controller"]);
//            $instance = $reflection->newInstance($app);
//            $instance->setRouteInformation($routes[0]);
//            $action =  isset($routes[0]['function']) ? $routes[0]['function'] . 'Action' : 'action';
//            return $instance->{$action}($request);
//    });
///   header ('Location: /home2/login');
//    die();
//    #return $app->redirect('/home2/login');
//}


foreach ($routes as $route){
    $app->{$route["method"]}($route["url"], function(Request $request) use($route, $app) {
        $reflection = new ReflectionClass("TestProject\\Controller\\" . $route["controller"]);
        $instance = $reflection->newInstance($app);
        
        $instance->setRouteInformation($route);
        $action =  isset($route['function']) ? $route['function'] . 'Action' : 'action';
        return $instance->{$action}($request);
    });
}
$app->run();