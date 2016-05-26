<?php
namespace TestProject\Controller\County;

class Edit {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];    
    }
    
    public function action(){
        #print_r(count($_GET));
        $countySelected ="";
        $templating = $this->templating;
        if (count($_GET) === 1){
            $countySelected = $this->getCounty();
        return $templating('editView', ['county'  =>  $this->getCounty() ] );
        } else {
             if  ( !$this->checkFields() )  {
                #echo "Filed can not be empty";
             } else {
                echo "County successfully updated.";
             }
        return $templating('editView', ['county'  =>  $countySelected ] );   
        }
          
    }
    
    function getCounty(){
        $sqlRequest = "SELECT * FROM county WHERE id=" . $_GET['id'];
        $result = $this->connect->query($sqlRequest);
        #$row = $result->fetch_row();
        #var_dump($row);
        foreach ($result as $element){
            $county [] = array('id'=> $element['id'], 'name'=> $element['name']);
        }
        return $county;
    }

    function checkFields(){
    
    if (empty($_GET['countyid'])){
         return false;
     }
     
     if (empty($_GET['name'])  ){
        return false;
     }
     
    return true;
    }
}//end of Edit Class

?>