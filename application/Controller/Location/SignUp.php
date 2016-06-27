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
                        if ($_POST['password'] === $_POST['passwordVerify'] && strlen($_POST['password'] >= 4)){
                                $username = $_POST['username'];
                                $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
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
                                        if ($status == 1){
                                                header('Location: /home2');
                                                exit;                                                
                                        }else{
                                           $_SESSION['userId'] = "";
                                                header('Location: /home2/logout');
                                                exit;       
                                        }
                                }
                        }else{
                                if ( strlen($_POST['password'] <= 4) ){
                                echo ("Password is too short. Please retry.");
                                }else{
                                echo "Passwords do not match.";                                        
                                }
                        }
                }
                return $this->render();
        }
}