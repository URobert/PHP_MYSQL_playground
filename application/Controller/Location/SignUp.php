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
                                $username = $_POST['username'];
                                $password = $_POST['password'];
                                $email = $_POST['emailAddress'];
                                if ($_POST['status'] == 'active'){
                                        $status = 1;
                                }else{
                                        $status = 0;
                                }
                                $addUser = "INSERT INTO user (username,password,email,status)
                                VALUES ('$username','$password', '$email', $status)";
                                if ($this->connect->query($addUser) === TRUE){
                                $getId = "SELECT id from user where username='$username'";
                                $result = $this->connect->query($getId);
                                $id = $result->fetch_assoc()['id'];
                                $_SESSION['userId'] = $id;
                                header('Location: /home2');
                                exit;
                                }
                                
                        }else{
                                echo "Passwords do not match.";
                        }
                }
                return $this->render();
        }
}