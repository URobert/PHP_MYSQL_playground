<?php
namespace TestProject\Controller\Location;
use Symfony\Component\HttpFoundation\Request;

class County {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->template = $app['template'];    
    }
    
    public function homeAction(){
        $template = $this->template;
        
        return $template(   ['countylist'  =>  $this->getCountyList() ] );
    }
    
    public function getCountyList(){
        $counties = array();
        $requestCountyList = "SELECT * FROM county";
        $returedList = $this->connect->query($requestCountyList);
        #var_dump($returedList);
        foreach ($returedList as $county){
            $counties [] = array('id'=> $county['id'], 'name'=> $county['name']);
        }
        return $counties;
    }
    
    public function checkFields(){         
         if ( empty($_POST['county']) ){
            return false;
         }
         
        return true;
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
    
    public function addCountyAction ($request) {
    $template = $this->template;
    if ($request->getMethod() === "POST"){
        
        // TEST FIELDS FOR NON-EMPTY AND LENGTH
         if  ( !$this->checkFields() )  { 
            echo '<script language="javascript">';
            echo 'alert("County filed can not be empty.")';
            echo '</script>'; 
         } else {
            // REFACTOR INSERT QUERIES
            $checkCounty = "SELECT * FROM county WHERE name=". "'" . $_POST['county']. "'" . " limit 1";
            $resultCounty = $this->connect->query($checkCounty);
            if ($resultCounty->num_rows){
                foreach ($resultCounty as $county){
                    $countyId = $county['id'];                                                          
                }
                echo "County ". $county['name'] . " already exists in DB.";
            }else{                        
                $addNewCounty = 'INSERT INTO county (name) VALUES ('
                 ."'"  . $_POST['county'] . "'" .')';
                if ($this->connect->query($addNewCounty) === TRUE) {
                    echo "County sucessfuly added:" . $_POST['county'] . "<br>";
                    $countyId = mysqli_insert_id($this->connect);
                }
            }
            
         }
    }//end of POST method check
    return $template([ 'counties' => $this->getCountyList() ]);         
}

    public function editCountyAction($request){
        $id = $request->get('id');
        #print_r(count($_GET));
        $template = $this->template;
        if ($request->getMethod() == "GET"){
            return $template( ['county'  =>  $this->getCounty($id) ] );
        } else {
            $countyid = $request->get("countyid");
            $name = $request->get("name");
            $sqlUpdate = 'UPDATE county SET name="' . $name .'"WHERE id=' . $id;
            if ($this->connect->query($sqlUpdate) === TRUE) {
                echo "County successfully updated." . "<br>";
                echo "New name: " . $name . "<br>";
                echo "<a href='/../../home'>Go back</a>";
                exit;
            } else {
                echo "Error updating record: " . $this->connect->error;
                exit();
            }
        }   
    }    

    public function deleteCountyAction ($request) {
        $id = $request->get('id');
        $county = 'SELECT name FROM county WHERE id=' . $id;
        $cities =  'SELECT * FROM city WHERE county_id='. $id;
        $result = $this->connect->query($county);
        $cName = mysqli_fetch_row($result)[0];
        $citiesResult = $this->connect->query($cities);
    
            if (mysqli_fetch_row($citiesResult)[1]){
                echo $cName . " could not be deteled. Only empty (without registred cities) counties can be deleted. ";
            }else{
                $deleteQuery = 'DELETE FROM county WHERE id=' . $id;
                if ($this->connect->query($deleteQuery) === TRUE){
                    echo $cName . " was deleted !";   
                }
            }
        
        $template = $this->template;        
        return $template( ['id' => $id, 'countyName' => $cName]);         
    }       
    
    
}//end of countyList class

?>