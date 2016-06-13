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
            return $this->render(['users'=>$users]);
        }else{
            $sql = "SELECT * FROM user";
            $returedList = $this->connect->query($sql);
            foreach($returedList as $user){
                $users [] = $user;
            }
            return $this->render(['users'=>$users]);
        }
    }
    
    public function SeachUsers($username, $email, $status){
        $users = [];
            //SEACH BY USER
            if ( !empty($username) && empty($email) && $status == "all"){
                $sqlReq = "SELECT * FROM user WHERE username LIKE'".  $username . "%'";
                $sqlReturn = $this->connect->query($sqlReq);
                while($row = $sqlReturn->fetch_assoc()) {
                    $users[] = $row;
                }
                return $users;
            }
            //SEACH BY EMAIL
            if ( !empty($email) && empty($username) && $status == "all"){
                $sqlReq = "SELECT * FROM user WHERE email LIKE'".  $email . "%'";
                $sqlReturn = $this->connect->query($sqlReq);
                while($row = $sqlReturn->fetch_assoc()) {
                    $users[] = $row;
                }
                return $users;
            }
            //SEACH ONLY BY STATUS
            if ( empty($username) && empty($email) && !empty($status)){
                #echo $status;
                if ($status == 'all'){
                    $sqlReq = "SELECT * FROM user";                   
                }else{
                    $sqlReq = "SELECT * FROM user WHERE status LIKE'".  $status . "%'";    
                }
                $sqlReturn = $this->connect->query($sqlReq);
                while($row = $sqlReturn->fetch_assoc()) {
                    $users[] = $row;
                }
                return $users;
            }
    }
    
}//end of Users class 
