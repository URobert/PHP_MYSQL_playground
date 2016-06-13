<?php
namespace TestProject\Controller\Location;
use Symfony\Component\HttpFoundation\Request;

class Login extends \TestProject\Controller\BaseController{
    
    public function __construct($app){
        $this->connect = $app['connect'];
    }
    
    public function LoginPageAction ($request){
        if (isset($_SESSION['userId'])){
            header("Location: /home2");
            exit;
        }
//var_dump($_SESSION);
//var_dump($_POST);
        if ($request->getMethod() === "POST"){
            $user = $request->get('Username');
            $password = $request->get('Password');
            if ("admin" == $user && "admin" == $password ){
                $_SESSION['userId'] = 1;
                header("Location: /home2");
                exit;
            }
        }
        return $this->render();
    }
    
    public function LogoutPageAction ($request){
        session_destroy();
        header('Location: /home2/login');
        exit;
        return $this->render();
    }
}//end of class 