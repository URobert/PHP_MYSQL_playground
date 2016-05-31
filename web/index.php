<?php
// web/index.php
require_once __DIR__.'/../vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;

$connect = mysqli_connect('localhost','root','cozacu','test1');

    if (!$connect){
        throw new Exception('Failed to connect.' . mysql_error());
    };

$app = new Silex\Application();
$app['debug'] = true;
$app['connect'] = $connect;
$app['templating'] = 'templating';
$app['template'] = 'template';

//function templating ($path, $arguments) {
//    ob_start();
//    extract($arguments);
//    require sprintf('../views/%s.php',$path);
//    $res = ob_get_clean();
//    return $res;
//}

//Almost Mirror to templating. Used for restructoring all the templates
/* Note: for this version to work properly, a naming standard must be kept.
 * All templates must have the same name (excepting the Action ending) as the function that triggers them.
 * */
function template ($arguments) {
    ob_start();
    extract($arguments);
    $path = debug_backtrace()[1]['function'];
    $path = str_replace('Action', '', $path);
    #echo $path;
    $object = debug_backtrace()[1]['class'];
    $reflect = new ReflectionClass($object);
    $dirName = $reflect->getShortName();
    require sprintf('../application/Controller/Location/View/%s/%s.php',$dirName,$path); 
    $res = ob_get_clean();
    return $res;
}

$parser = new Symfony\Component\Yaml\Parser();
$routes = $parser->parse(file_get_contents(__DIR__.'/../config/routes.yml'));

foreach ($routes as $route){
    //var_dump($route);
    $app->{$route["method"]}($route["url"], function(Request $request) use($route, $app) {
        $reflection = new ReflectionClass("TestProject\\Controller\\" . $route["controller"]);
        $instance = $reflection->newInstance($app);
        
        $action =  isset($route['function']) ? $route['function'] . 'Action' : 'action';
        return $instance->{$action}($request);
    });
}

$app->run();