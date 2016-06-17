<?php
namespace TestProject\Controller\Location;
use Symfony\Component\HttpFoundation\Request;

class Users extends \TestProject\Controller\BaseController{
    
    public function __construct($app){
        $this->connect = $app['connect'];
    }
    
    public function ListUsersAction($request){
        $users = array ();
        $user = $request->get("username");
        $email = $request->get("email");
        $status = $request->get("status");
        
        if ($request->getMethod() === "POST"){
            $users =  $this->SeachUsers($user, $email, $status);
        }else{
            $sql = "SELECT * FROM user";
            $returedList = $this->connect->query($sql);
            foreach($returedList as $entry){
                $users [] = $entry;
            }
        }
        return $this->render(['users'=>$users, 'username'=>$user, 'email'=>$email, 'status'=>$status]);
    }
    
    public function SeachUsers($username, $email, $status){
        $users = [];
        $sqlReq = "SELECT * FROM user WHERE 1 ";
        //SEACH BY USER
        if ( !empty($username) ){
            $sqlReq .= " AND username LIKE'".  $username . "%'";
        }
        //SEACH BY EMAIL
        if ( !empty($email)){
            $sqlReq .= " AND email LIKE'%".  $email . "%'";
        }
        //SEACH ONLY BY STATUS
        if ($status != ""){
            $sqlReq .= " AND status='".  $status . "'";    
        }
        $sqlReturn = $this->connect->query($sqlReq);
        while($row = $sqlReturn->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    
}//end of Users class 
