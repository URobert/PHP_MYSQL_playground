<?php

namespace TestProject\Controller\Location;

class SignUp extends \TestProject\Controller\BaseController
{
        public function __construct($app)
        {
                $this->connect = $app['connect'];
        }
    
        public function SignUpFormAction($request)
        {
                if ($request->getMethod()== "POST"){
                        if ($_POST['password'] === $_POST['passwordVerify']){
                                $addUser = "INSERT INTO user (username,password,email,status) VALUES ('Roberto','1111', 'ahoy@yahoo.com', 1)";
                        }
                }
                return $this->render();
        }
}