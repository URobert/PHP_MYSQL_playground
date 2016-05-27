<?php
namespace TestProject\Controller\County;
use Symfony\Component\HttpFoundation\Request;
class Edit {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];
    }
    
    public function execute(Request $request){
        $id = $request->get('id');
        #print_r(count($_GET));
        $templating = $this->templating;
        if ($request->getMethod() == "GET"){
            return $templating('editView', ['county'  =>  $this->getCounty($id) ] );
        } else {
            $countyid = $request->get("countyid");
            $name = $request->get("name");
            $sqlUpdate = 'UPDATE county SET id='. $countyid .',name="' . $name .'"WHERE id=' . $id;
            if ($this->connect->query($sqlUpdate) === TRUE) {
                echo "County successfully updated." . "<br>";
                echo "New ID: " . $countyid . "<br>";
                echo "New name: " . $name . "<br>";
                echo "<a href='/../../home'>Go back</a>";
                exit;
            } else {
                echo "Error updating record: " . $this->connect->error;
            }

                #return $templating('editView', ['county'  =>  $this->getCounty() ] );   
        }   
    }
    
    public function getCounty($id){
        $sqlRequest = "SELECT * FROM county WHERE id=" . $id;
        $result = $this->connect->query($sqlRequest);
        #$row = $result->fetch_row();
        #var_dump($row);
        foreach ($result as $element){
            $county [] = array('id'=> $element['id'], 'name'=> $element['name']);
        }
        return $county;
    }
}//end of Edit Class

?>