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
    
    public function mapCityAction ($request) {
        $listofCities [] = ['Oradea','Beius', 'Alesd', 'Nucet','Brasov','Bucuresti','London'];
        $appId = "01ffc2b8227e5302ffa7f8555ba7738e";
        $cityAndTemp = array ();
        
        
        //Getting DB cities and obtaining differences between request and db cities
        $citiesInDB = 'Select name FROM city_map';
        $result = $this->connect->query($citiesInDB);
        foreach ($result as $row){
            $listInDB [] = $row['name'];
        }
        $diffToImport = array_diff($listofCities[0], $listInDB);
        #$list = implode("','",$diffToImport);
        foreach ($diffToImport as $city){
            $sqlInsertCities = "INSERT INTO city_map (name, source_id) VALUES ('" . $city ."', 1)";
            if ($this->connect->query($sqlInsertCities) === TRUE){
            }
        }
        
        $completeList = "SELECT * FROM city_map ORDER BY name";
        $result = $this->connect->query($completeList);
        foreach ($result as $city){
            $allCities [] = ['name' => $city['name'], 'source_id' => $city['source_id'], 'id' => $city['id'] ,'city_id' => $city['city_id']];
        }        
        
        #var_dump($allCities);
        foreach ($allCities as $city){
            $response =  file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=' . $city['name'] . '&APPID='.$appId.'&units=metric');
            $response = json_decode($response);
            $cityAndTemp [] = ['city'=>$response->name, 'temp'=>$response->main->temp, 'source_id'=> $city['source_id'], 'id'=> $city['id'] ,'city_id' => $city['city_id']]; 
        }        
        return $this->render (['cityAndTemp' => $cityAndTemp]);        
    }
    
    public function searchCityAction($request){
        
        //get search term
         if (isset($_GET['term'])) {
            $searchTerm = $_GET['term'];         
            //get matched data from skills table
            $data = array();
            $query = $this->connect->query("SELECT * FROM city WHERE name LIKE '".$searchTerm."%' ORDER BY name ASC");
            while ($row = $query->fetch_assoc()) {
                #$data[] = $row['name'];
                $data[] = ['label' => $row['name'], 'value' => $row['id']];
            }       
            //return json data
            $dbCityList  = json_encode($data);
           return $dbCityList;
         }else{
           return $this->render();
         }
    }
    
    public function searchCity2Action($request){
        $listInDB = array();
        if ( !null == $request->get('userSearch')){
            $realCities = "Select * FROM city WHERE name LIKE '" . $request->get('userSearch') . "%'";
            $result = $this->connect->query($realCities);
            foreach ($result as $city){
                $listInDB [] = ['id'=>$city['id'], 'name'=>$city['name']];
            }
        }
        return $this->render(['mapid' => $request->get('mapid'), 'realCityList' => $listInDB]);
    }    
    
    public function mapNewCityAction($request){
        $mapid = $request->get('mapid');
        $targetid = $request->get('targetid');
        //echo "mapid=" . $mapid . "<br>  ".
        //     "targetid=" .  $targetid;
        //echo "UPDATE city_map SET city_id=". $targetid . " WHERE id=" . $mapid;
        $updateDB = $this->connect->query("UPDATE city_map SET city_id=". $targetid . " WHERE id=" . $mapid);
        header("Location: http://example.local/cities/map");
        exit;
        #return $this->render();

    }
}//end of City class