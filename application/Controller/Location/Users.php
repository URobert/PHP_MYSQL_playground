<?php 
namespace TestProject\Controller\Location;
use Symfony\Component\HttpFoundation\Request;


class Users extends \TestProject\Controller\BaseController{
    
    public function __construct($app){
        $this->connect = $app['connect'];
    }
    
    public function ListUsersAction($request){
        if(!isset($_SESSION['user_search']))  {
            $_SESSION['user_search'] = array();
        }
        $filters = $_SESSION['user_search'];
        $user = $request->get("username", @$filters['user']);
        $email = $request->get("email", @$filters['email']);
        $status = $request->get("status",@$filters['status']);
           
        if ($request->getMethod() === "POST"){
            $filters['user']= $user;
            $filters['email']= $email;
            $filters['status']= $status;    
            $_SESSION['user_search'] = $filters;   
        }
        
        $users =  $this->SeachUsers($user, $email, $status);
        
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
        //LIMIT FOR PAGINATION
        //$currentPage;
        //$rowsPerPage;
        //$totalNrPages;
        //
        //$sqlReq .= " LIMIT 2 OFFSET " . $offsetPagination;
        $sqlReturn = $this->connect->query($sqlReq);
        while($row = $sqlReturn->fetch_assoc()) {
            $users[] = $row;
        }
        //$offsetPagination += 2;
        //echo $offsetPagination;
        return $users;
    }

    
}//end of Users class 
