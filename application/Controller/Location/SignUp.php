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
        if ($request->getMethod() == 'POST') {
            if ($request->get('password') === $request->get('passwordVerify') && strlen($request->get('password')) >= 4) {
                $username = $request->get('username');
                $password = password_hash($request->get('password'), PASSWORD_BCRYPT);
                $email = $request->get('emailAddress');
                if ($request->get('status') == 'active') {
                    $status = 1;
                } else {
                    $status = 0;
                }
                $addUser = \ORM::for_table('user')->create();
                $addUser
                    ->set('username', $username )
                    ->set('password', $password )
                    ->set('email', $email)
                    ->set('status', $status)
                    ->save();
                $_SESSION['userId'] = $addUser->id;
                if ($status == 1) {
                    header('Location: /home2');
                    exit;
                } else {
                    $_SESSION['userId'] = '';
                    header('Location: /home2/logout');
                    exit;
                }
                
            } else {
                if (strlen($request->get('password')) <= 3) {
                    echo 'Password is too short. Please retry.';
                } else {
                    echo 'Passwords do not match.';
                }
            }
        }

        return $this->render();
    }
}
