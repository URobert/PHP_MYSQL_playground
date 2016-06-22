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
        $filters = $_SESSION['user_search'];
        $user = $request->get('username', @$filters['user']);
        $email = $request->get('email', @$filters['email']);
        $status = $request->get('status', @$filters['status']);

        if ($request->getMethod() === 'POST') {
            $filters['user'] = $user;
            $filters['email'] = $email;
            $filters['status'] = $status;
            $_SESSION['user_search'] = $filters;
        }

        $usersAndPages = $this->SeachUsers($user, $email, $status);
        return $this->render(['users' => $usersAndPages['users'], 'textline1'=> $usersAndPages['textline1'], 'textline2'=> $usersAndPages['textline2'],
                              'paginationCtrls' => $usersAndPages['paginationCtrls'],
                              'username' => $user, 'email' => $email, 'status' => $status]);
    }

    public function SeachUsers($username, $email, $status)
    {
        $users = [];
        $sqlReq = 'SELECT * FROM user WHERE 1 ';
        //SEACH BY USER
        if (!empty($username)) {
            $sqlReq .= " AND username LIKE'".$username."%'";
        }
        //SEACH BY EMAIL
        if (!empty($email)) {
            $sqlReq .= " AND email LIKE'%".$email."%'";
        }
        //SEACH ONLY BY STATUS
        if ($status != '') {
            $sqlReq .= " AND status='".$status."'";
        }
        
        //LIMIT FOR PAGINATION
        #$rows = count($users);
        $count = "select count(*) from ($sqlReq) AS T";
        $sqlReturn = $this->connect->query($count);
        $rows = $sqlReturn->fetch_assoc()["count(*)"];
        #$rows = 10; #total number of rows resulted
        $page_rows = 2; #nr of rows that will be displayed by page
        $last = ceil($rows/$page_rows); #the last page
        
        if ($last < 1){
            $last = 1;
        }
        $pagenum = 1;
        //get pagenum from URL
        if ( isset($_GET['pn'] )){
            $pagenum = preg_replace('#[^0-9#', '', $_GET['pn']);
        }
        //keep pagenum > 1
        if ($pagenum < 1){
            $pagenum = 1;
        }else if ($pagenum > $last){
            $pagenum = $last;
            }
        //set the range of rows to query for the chosen $pagenum
        $limit = ' LIMIT ' . ($pagenum - 1) * $page_rows . ',' . $page_rows;
        $sqlReq .= $limit;
        //showing the user what page they are on
        $textline1 = "Users: (<b>$rows</b>)";
        $textline2 = "Page <b>$pagenum</b> of <b>$last</b>";
        //enable pagination control
        $paginationCtrls = '';
        //if more than one page
        if ($last != 1) {
                if ($pagenum > 1){
                    $previous = $pagenum - 1;
                    $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '">Previous</a> $nbsp; &nbsp; ';
                    //render clickable nr links on left of target
                    for ($i = $pagenum - 4; $i < $pagenum; $i++){
                        if ($i > 0){
                            $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn' . $i . '">'.$i.'</a> &nbsp; ';
                        }
                    }
                }
                //render the target page
                $paginationCtrls .= ''. $pagenum .' &nbsp; ';
                //render the clickable links on the right
                for ($i = $pagenum + 1; $i < $last; $i++){
                    $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn' . $i . '">'.$i.'</a> &nbsp; ';
                    if ($i >= $pagenum + 4){
                    break;
                    }
                }
                //Check for last page, generate "next"
                if ($pagenum != $last){
                    $next = $pagenum + 1;
                    $paginationCtrls .= ' &nbsp; &nbsp; <a href="' .$_SERVER['PHP_SELF'].'?pn' . $next . '">Next</a>';
                }
        }
        $sqlReturn = $this->connect->query($sqlReq);
        while ($row = $sqlReturn->fetch_assoc()) {
            $users[] = $row;
        }
        return ['users' => $users, 'textline1' => $textline1, 'textline2' => $textline2, 'paginationCtrls' => $paginationCtrls];
        
        //$sqlReturn = $this->connect->query($sqlReq);
        //while ($row = $sqlReturn->fetch_assoc()) {
        //    $users[] = $row;
        //}
        //return $users;
    }
}//end of Users class 
