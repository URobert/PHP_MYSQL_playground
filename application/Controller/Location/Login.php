<?php

namespace TestProject\Controller\Location;

class Login extends \TestProject\Controller\BaseController
{
    public function __construct($app)
    {
        $this->connect = $app['connect'];
    }

    public function LoginPageAction($request)
    {
        if (isset($_SESSION['userId'])) {
            header('Location: /home2');
            exit;
        }

        if ($request->getMethod() === 'POST') {
            $user = $request->get('Username');
            $password = password_verify($request->get('Password'), PASSWORD_BCRYPT);
            $dbUser = \ORM::for_table('user')
                ->where('username', $user)
                ->where('password', $password)
                ->where('status', 1)
                ->find_one();
            if ($dbUser) {
                $_SESSION['userId'] = $dbUser->id;
                //SAVING SESSION INFO INTO DB AS WELL
                #1. Check for session info in DB
                $checkSession = \ORM::for_table('user_sessions')->find_one();
                if (!$checkSession){
                    $userInfo = \ORM::for_table('user_sessions')->create();
                    $userInfo
                        ->set('user_id',$dbUser->id)
                        ->save();
                }
                header('Location: /home2');
                exit;
            }
        }

        return $this->render();
    }

    public function LogoutPageAction($request)
    {
        session_destroy();
        header('Location: /home2/login');
        exit;

        return $this->render();
    }
}//end of class 
