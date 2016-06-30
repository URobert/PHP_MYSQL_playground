<?php

namespace TestProject\Controller\Location;

class Users extends \TestProject\Controller\BaseController
{
    public function __construct($app)
    {
        $this->connect = $app['connect'];
    }

    public function ListUsersAction($request)
    {
        if (!isset($_SESSION['user_search'])) {
            $_SESSION['user_search'] = array();
        }
        //BRING IN SESSION INFO FROM DB
        $savedSession = \ORM::for_table('user_sessions');
        $session = $savedSession->find_one($_SESSION['userId']);
        $decoded = json_decode($session['session_info']);
        
        if($decoded->user != "" || $decoded->email != "" || $decoded->status != ""){
            $user = $request->get('username', $decoded->user);
            $email = $request->get('email',$decoded->email);
            $status = $request->get('status',$decoded->status);
        } else {
            $filters = $_SESSION['user_search'];
            $user = $request->get('username', @$filters['user']);
            $email = $request->get('email', @$filters['email']);
            $status = $request->get('status', @$filters['status']);
        }
        
        if ($request->getMethod() == 'GET') {
            $filters['user'] = $user;
            $filters['email'] = $email;
            $filters['status'] = $status;
            $_SESSION['user_search'] = $filters;
        }
        
        //SAVING SESSION INFO INTO DB AS WELL
        $userSession = \ORM::for_table('user_sessions');
        $result = $userSession->find_one($_SESSION['userId']);
        $result
           ->set('session_info',json_encode($filters))
           ->save();
        //----------------------------------
        
        $usersAndPages = $this->SeachUsers($user, $email, $status);

        return $this->render(['users' => $usersAndPages['users'], 
                              'username' => $user,
                              'email' => $email,
                              'status' => $status,
                              'pagination' => $usersAndPages['pagination']
                            ]);
    }

    public function SeachUsers($username, $email, $status)
    {
        $users = [];
        $sqlReq  = \ORM::for_table('user');
        
        
        //SEACH ONLY BY STATUS
        if ($status != '') {
            $sqlReq->where('status', $status);
        }
        
        //SEACH BY USER
        if (!empty($username)) {
            $sqlReq->where_like('username', "$username%");
        }
        //SEACH BY EMAIL
        if (!empty($email)) {
            $sqlReq->where_like('email', "%$email%");
        }
        
        $number_per_page = 2;
        $current_page = isset($_GET['pn']) ? $_GET['pn'] : 1;
        
        $total = $sqlReq->count();
        $pages = ceil($total/$number_per_page);
        $is_first_page = $current_page == 1;
        $is_last_page  = $current_page == $pages;

        $result = $sqlReq
            ->offset($number_per_page * ($current_page - 1))
            ->limit($number_per_page)
            ->find_many();
            
        foreach ($result as $entry){
            $users [] = $entry;
        }

        return [
            'users' => $users,
            'pagination' => [
                'total' => $total,
                'pages' => $pages,
                'current_page' => $current_page,
                'is_first_page' => $is_first_page,
                'is_last_page'  => $is_last_page
            ]
        ];
    }
}//end of Users class 
