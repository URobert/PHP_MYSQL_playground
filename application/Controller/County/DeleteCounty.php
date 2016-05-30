<?php

namespace TestProject\Controller\County;
use Symfony\Component\HttpFoundation\Request;

class DeleteCounty {
    public function __construct($app){
        $this->connect = $app["connect"];
        $this->templating = $app["templating"];
    }
    
    
    public function action (Request $request) {
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
        
        $templating = $this->templating;        
        return $templating('deleteCountyV', ['id' => $id, 'countyName' => $cName]);         
    }

}
