<?php
namespace TestProject\Controller\Location;
use Symfony\Component\HttpFoundation\Request;

class County extends \TestProject\Controller\BaseController {
    
    public function __construct($app) {        
        $this->connect = $app['connect'];    
    }
    
    public function homeAction(){
        return $this->render(['countylist'  =>  $this->getCountyList()]);
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
    
    public function getCounty($id){
        $sqlRequest = "SELECT * FROM county WHERE id=" . $id;
        $result = $this->connect->query($sqlRequest);
        foreach ($result as $element){
            $county [] = array('id'=> $element['id'], 'name'=> $element['name']);
        }
        return $county;
    }    
    
    public function addCountyAction ($request) {
    if ($request->getMethod() === "POST"){
        
        $county = $request->get('county');
        // TEST FIELDS FOR NON-EMPTY AND LENGTH
         if  ( !$county )  { 
            echo '<script language="javascript">';
            echo 'alert("County filed can not be empty.")';
            echo '</script>'; 
         } else {
            // REFACTOR INSERT QUERIES
            $checkCounty = "SELECT * FROM county WHERE name=". "'" . $county. "'" . " limit 1";
            $resultCounty = $this->connect->query($checkCounty);
            if ($resultCounty->num_rows){
                foreach ($resultCounty as $county){
                    $countyId = $county['id'];                                                          
                }
                #echo "County ". $county['name'] . " already exists in DB.";
                echo "<script>alert('County already exists in DB.')</script>";
            }else{                        
                $addNewCounty = 'INSERT INTO county (name) VALUES ('    
                 ."'"  . $_POST['county'] . "'" .')';
                if ($this->connect->query($addNewCounty) === TRUE) {
                    #echo "County successfully added:" . $_POST['county'] . "<br>";
                    echo "<script>
                          window.location.href='/home2';
                          </script>";
                    $_SESSION['message'] = "County successfully added."; 
                    $countyId = mysqli_insert_id($this->connect);
                }
            }
            
         }
    }//end of POST method check
    return $this->render([ 'counties' => $this->getCountyList() ]);         
}

    public function editCountyAction($request){
        $id = $request->get('id');
        #print_r(count($_GET));
        if ($request->getMethod() == "GET"){
            return $this->render( ['county'  =>  $this->getCounty($id) ] );
        } else {
            $countyid = $request->get("countyid");
            $name = $request->get("name");
            $sqlUpdate = 'UPDATE county SET name="' . $name .'"WHERE id=' . $id;
            if ($this->connect->query($sqlUpdate) === TRUE) {
                //echo "County successfully updated." . "<br>";
                //echo "New name: " . $name . "<br>";
                //echo "<a href='/../../home'>Go back</a>";
                //exit();
                echo "<script>
                 alert('County successfully updated.');
                 window.location.href='/home2';
                 </script>";
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
                #echo $cName . " could not be deteled. Only empty (without registred cities) counties can be deleted. ";
                echo "<script>
                 alert('That county can not be deteled. Only empty (without registred cities) counties can be deleted.');
                 window.location.href='/home2';
                 </script>";
            }else{
                $deleteQuery = 'DELETE FROM county WHERE id=' . $id;
                if ($this->connect->query($deleteQuery) === TRUE){
                echo "<script>
                 alert('County deleted.');
                 window.location.href='/home2';
                 </script>";  
                }
            }       
        return $this->render( ['id' => $id, 'countyName' => $cName]);         
    }
    
    public function searchLocationAction($request){
        if ($request->getMethod() == "POST"){
            $searchField = $request->get('userSearch');
            if ($request->get('SearchBy') == "County"){
                $category = "County";
                return $this->searchHelp($searchField, $category);
            }else{
                //Searching by city
                if ($request->get('SearchBy') == "City"){
                $category = "City";
                return $this->searchHelp($searchField, $category);
                }
            }
        }else{
            $listQuery = "SELECT county.name AS County, city.name AS City,county.id
                          FROM county JOIN city WHERE county.id =   city.county_id ORDER BY county.name;";
            $result = $this->connect->query($listQuery);
            $countiesAndCities = array();
            foreach ($result as $row){
            $countiesAndCities [] = $row;
            }
            return $this->render(['countiesAndCities' => $countiesAndCities]); 
        }
    }
    public function searchHelp($searchTerm, $category){
            $countiesAndCities = [];
            $sqlReq = "SELECT * FROM
                      (SELECT county.name AS County, city.name AS City,county.id FROM county JOIN city WHERE county.id =city.county_id ORDER BY county.name) AS C
                       WHERE " . $category . "='" . $searchTerm . "';";
            $result = $this->connect->query($sqlReq);
            if ($result->num_rows == 0){
                echo "No result was found.";
            }
            foreach ($result as $row){
            $countiesAndCities [] = $row;
            }
        return $this->render(['countiesAndCities' => $countiesAndCities]);
    }
    
    
}//end of countyList class

?>