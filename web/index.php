<link rel="stylesheet" href="/css/bootstrap.min.css">
<script src="/js/jquery-1.12.3.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
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
function template ($path, $arguments) {
    ob_start();
    extract($arguments);
    #echo debug_backtrace()[1]['function'];
    #echo debug_backtrace()[1]['class'];
    $object = debug_backtrace()[1]['class'];
    $reflect = new ReflectionClass($object);
    $dirName = $reflect->getShortName();
    #require sprintf('../application/Controller/Location/View/County/%s.php',$path);
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