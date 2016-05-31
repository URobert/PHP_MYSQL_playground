<?php
namespace TestProject\Controller\Location;
use Symfony\Component\HttpFoundation\Request;

class City {
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->template = $app['template'];   
    }
    
    public function cityListAction(Request $request){
        $id = $request->get('id');
        $template = $this->template; 
        return $template( ['cityList'  =>  $this->getCityList($id) ,
                                            'countyId' => $id ] );
    }
    
    public function getCityList($id){
        $cities = array();
        $requestCityList = "SELECT * FROM city WHERE county_id=" . $id;
        $returedList = $this->connect->query($requestCityList);
        foreach ($returedList as $city){
            $cities [] = array('id'=> $city['id'], 'name'=> $city['name']);
        }
        return $cities;
    }
    
    public function checkFields(){         
         if ( empty($_POST['city']) ){
            return false;
         }
        return true;
    }
    
    public function getCity($id){
        $cities = array();
        $requestCityList = "SELECT * FROM city WHERE county_id=" . $id;
        $returedList = $this->connect->query($requestCityList);
        foreach ($returedList as $city){
            $cities [] = array('id'=> $city['id'], 'name'=> $city['name']);
        }
        return $cities;
    }
    
    public function getCounty($id){
        $countyName = array();
        $requesCounty = "SELECT name FROM county WHERE id=" . $id;
        $return = $this->connect->query($requesCounty);
        foreach ($return as $county){
            $countyName [] = array('name'=> $county['name']);
        }
        return $countyName;
    }      
    
    public function addCityAction ($request) {
        $id = $request->get('id');
        $template = $this->template;
        if ($request->getMethod() === "POST"){
            
            // TEST FIELDS FOR NON-EMPTY AND LENGTH
             if  ( !$this->checkFields() )  { 
                echo '<script language="javascript">';
                echo 'alert("City filed can not be empty.")';
                echo '</script>'; 
             } else {
                // REFACTOR INSERT QUERIES`
                $checkCity = 'SELECT * FROM city WHERE name="' . $_POST['city'] . '" AND county_id='.
                $id . ' limit 1';
                $result = $this->connect->query($checkCity);
                if ($result->num_rows){
                    foreach ($result as $city){
                        $cityId = $city['id'];                                                          
                    }
                    echo "City ". $city['name'] . " already exists in this county.";
                }else{                        
                    $addNewCity = 'INSERT INTO city (name,county_id)
                                   VALUES ("' . $_POST['city'] . '",' . $id .')';
                    if ($this->connect->query($addNewCity) === TRUE) {
                        echo "City sucessfuly added:" . $_POST['city'] . "<br>";
                        $cityId = mysqli_insert_id($this->connect);
                    }
                }
                
             }
        }//end of POST method check
        return $template([ 'cities' => $this->getCity($id),
                                            'countyId' => $id,
                                            'countyName' => $this->getCounty($id)]);         
    }
    
  
    
    
    
    
}//end of City class