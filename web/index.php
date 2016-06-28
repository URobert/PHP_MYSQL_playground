<?php
session_start();
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


ORM::configure('mysql:host=localhost;dbname=test1');
ORM::configure('username', 'root');
ORM::configure('password', 'cozacu');

$connect = mysqli_connect('localhost','root','cozacu','test1');

    if (!$connect){
        throw new Exception('Failed to connect.' . mysql_error());
    };

function changeQueryString($name, $value) {
    parse_str($_SERVER['QUERY_STRING'], $temporary);
    $temporary[$name] = $value;
    return http_build_query($temporary);
}

function changePage($base, $target_page) {
    return $base . "?" . changeQueryString('pn', $target_page);
}

$app = new Silex\Application();
$app['debug'] = true;
$app['connect'] = $connect;

$parser = new Symfony\Component\Yaml\Parser();
$routes = $parser->parse(file_get_contents(__DIR__.'/../config/routes.yml'));

$app->before(function(Request $request, Silex\Application $app) {
    if (!isset($_SESSION['userId']) && ($request->getPathInfo() !== '/home2/login')
        && ($request->getPathInfo() !== '/home2/signUp'))
    {
        return $app->redirect('/home2/login');
    }
});

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