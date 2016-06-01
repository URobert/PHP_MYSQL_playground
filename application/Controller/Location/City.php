<?php
namespace TestProject\Controller\Location;
use Symfony\Component\HttpFoundation\Request;

class City extends \TestProject\Controller\BaseController{
    
    public function __construct($app){
        parent::__construct($app);
        
        $this->connect = $app['connect'];
    }
    
    public function cityListAction(Request $request){
        $id = $request->get('id');
        return $this->render( ['cityList'  =>  $this->getCityList($id) ,
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
                    #echo "City ". $city['name'] . " already exists in this county.";
                    echo "<script>
                           alert('This city already exists in this county.');
                          </script>";
                }else{                        
                    $addNewCity = 'INSERT INTO city (name,county_id)
                                   VALUES ("' . $_POST['city'] . '",' . $id .')';
                    if ($this->connect->query($addNewCity) === TRUE) {
                    #echo "City sucessfuly added:" . $_POST['city'] . "<br>";
                    
                    echo "<script>
                           alert('City sucessfuly added.');
                          </script>";
                        $cityId = mysqli_insert_id($this->connect);
                    }
                }
                
             }
        }//end of POST method check
        return $this->render([ 'cities' => $this->getCity($id),
                                            'countyId' => $id,
                                            'countyName' => $this->getCounty($id)]);         
    }
    
    public function deleteCityAction ($request) {
        $id = $request->get('id');
        $cities =  'DELETE FROM city WHERE id='. $id;
        $result = $this->connect->query($cities);
        echo "<script>
               alert('City deleted');
               window.location.href='/home2';
             </script>";
        return $this->render( ['id' => $id ]);
    }    
    
    
    
    
}//end of City class