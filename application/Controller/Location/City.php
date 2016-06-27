<?php

namespace TestProject\Controller\Location;

use Symfony\Component\HttpFoundation\Request;

class City extends \TestProject\Controller\BaseController
{
    public function __construct($app)
    {
        $this->connect = $app['connect'];
    }

    public function cityListAction(Request $request)
    {
        $id = $request->get('id');

        return $this->render(['cityList' => $this->getCityList($id), 'countyId' => $id, ]);
    }

    public function getCityList($id)
    {
        $cities = array();
        $requestCityList = \ORM::for_table('city')
                    ->where('county_id', $id)
                    ->find_many();        
        foreach ($requestCityList as $city){
            $cities [] = array('id' => $city['id'], 'name' => $city['name']);
        }
        
        return $cities;
    }
    
    public function getCounty($id)
    {
        $countyName = array();
        $requesCounty = \ORM::for_table('county')
                    ->where('id', $id)
                    ->find_one();  
        $countyName [] = array('name' => $requesCounty['name']);
        
        return $countyName;
    }

    public function addCityAction($request)
    {
        $id = $request->get('id');

        if ($request->getMethod() === 'POST') {

            // TEST FIELDS FOR NON-EMPTY AND LENGTH
            $city = $request->get('city');
            if (!$city) {
                echo '<script language="javascript">';
                echo 'alert("City filed can not be empty.")';
                echo '</script>';
            } else {
                // REFACTOR INSERT QUERIES`
                $checkCity = \ORM::for_table('city')
                    ->where('name', $_POST['city'])
                    ->where('county_id', $id)
                    ->find_one();
                if ($checkCity) {
                        $cityId = $checkCity->id;
echo "<script>
       alert('This city already exists in this county.');
      </script>";
                } else {
                    $addNewCity = 'INSERT INTO city (name,county_id)
                                   VALUES ("'.$request->get('city').'",'.$id.')';
                    if ($this->connect->query($addNewCity) === true) {
echo "<script>
       alert('City sucessfuly added.');
      </script>";
                        $cityId = mysqli_insert_id($this->connect);
                    }
                }
            }
        }//end of POST method check
        return $this->render(['cities' => $this->getCityList($id),
                              'countyId' => $id,
                              'countyName' => $this->getCounty($id), ]);
    }

    public function deleteCityAction($request)
    {
        $id = $request->get('id');
        $cities = \ORM::for_table('city')
            ->where('id',$id)
            ->delete_many();
echo "<script>
       alert('City deleted');
       window.location.href='/home2';
     </script>";
     
        return $this->render(['id' => $id]);
    }

    public function mapCityAction($request)
    {
        $listofCities [] = ['Oradea', 'Beius', 'Alesd', 'Nucet', 'Brasov', 'Bucuresti', 'London','Timisoara'];
        $appId = '01ffc2b8227e5302ffa7f8555ba7738e';
        $cityAndTemp = array();

        //Getting DB cities and obtaining differences between request and db cities
        $citiesInDB = \ORM::for_table('city_map')
            ->select('name')
            ->find_many();
        foreach ($citiesInDB as $row) {
            $listInDB [] = $row['name'];
        }
        $diffToImport = array_diff($listofCities[0], $listInDB);
        foreach ($diffToImport as $city) {
            $sqlInsertCities = "INSERT INTO city_map (name, source_id) VALUES ('".$city."', 1)";
            $this->connect->query($sqlInsertCities); 
        }
        
        $completeList = \ORM::for_table('city_map')
            ->order_by_asc('name')
            ->find_many();
        foreach ($completeList as $city) {
            $allCities [] = ['name' => $city['name'], 'source_id' => $city['source_id'], 'id' => $city['id'], 'city_id' => $city['city_id']];
        }
        foreach ($allCities as $city) {
            $responseJson = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$city['name'].'&APPID='.$appId.'&units=metric');
            $response = json_decode($responseJson);
            if ($response->cod == 200){ 
                $cityAndTemp [] = ['city' => $response->name, 'temp' => $response->main->temp, 'source_id' => $city['source_id'], 'id' => $city['id'], 'city_id' => $city['city_id']];
            }
        }

        return $this->render(['cityAndTemp' => $cityAndTemp]);
    }

    public function searchCityAction($request)
    {
        $searchTerm = $request->get('term');
        if ($searchTerm) {
            //get matched data from skills table
            $data = array();
            $query = $this->connect->query("SELECT name as label, id as value FROM city WHERE name LIKE '".$searchTerm."%' ORDER BY name ASC");
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            //return json data
            $dbCityList = json_encode($data);

            return $dbCityList;
        } else {
            return $this->render();
        }
    }

    public function searchCity2Action($request)
    {
        $listInDB = array();
        if (!null == $request->get('userSearch')) {
            $realCities = "Select id, name FROM city WHERE name LIKE '".$request->get('userSearch')."%'";
            $result = $this->connect->query($realCities);
            foreach ($result as $city) {
                $listInDB [] = $city;
            }
        }

        return $this->render(['mapid' => $request->get('mapid'), 'realCityList' => $listInDB]);
    }

    public function mapNewCityAction($request)
    {
        $mapid = $request->get('mapid');
        $targetid = $request->get('targetid');
        $updateDB = $this->connect->query('UPDATE city_map SET city_id='.$targetid.' WHERE id='.$mapid);
        header('Location: http://example.local/cities/map');
        exit;
        #return $this->render();
    }

    public function weatherForecastImportAction($request)
    {

        //GET LIST OF CITIES FOR WEATHER REPORT  
        $result = $this->connect->query('SELECT * FROM city_map');
        foreach ($result as $city) {
            $cities [] = ['city_id' => $city['city_id'], 'name' => $city['name']];
        }

        //CALLING API
        $appId = '01ffc2b8227e5302ffa7f8555ba7738e';
        $cityWeatherInfo = array();

        foreach ($cities as $city) {
            $response = file_get_contents('http://api.openweathermap.org/data/2.5/forecast/daily?q='.$city['name'].'&mode=json&units=metric&cnt=7'.'&APPID='.$appId.'&units=metric');
            $response = json_decode($response, true);
            for ($i = 0; $i < 7; ++$i) {
                $sqlRequest = 'INSERT INTO weather
            (city_id,date,temp,min_temp,max_temp,humidity,wind)
            VALUES ('
            .$city['city_id'].
            ',FROM_UNIXTIME('
            .$response['list'][$i]['dt'].'),'
            .$response['list'][$i]['temp']['day'].','
            .$response['list'][$i]['temp']['min'].','
            .$response['list'][$i]['temp']['max'].','
            .$response['list'][$i]['humidity'].','
            .$response['list'][$i]['speed'].')';
                $this->connect->query($sqlRequest);
            }
        }

        return $this->render();
    }

    public function weatherForecastAction($request)
    {
        if (!isset($_SESSION['weather_info'])) {
            $_SESSION['weather_info'] = array();
        }
        $weatherInfo = $_SESSION['weather_info'];
        $county = $request->get('county', @$weatherInfo['county']);
        $city = $request->get('city', @$weatherInfo['city']);
        $dateFrom = $request->get('from', @$weatherInfo['from']);
        $dateTo = $request->get('to', @$weatherInfo['to']);

        if ($request->getMethod() === 'POST') {
            $cityWeatherInfo = [];
            $weatherInfo['county'] = $county;
            $weatherInfo['city'] = $city;
            $weatherInfo['from'] = $dateFrom;
            $weatherInfo['to'] = $dateTo;
            $_SESSION['weather_info'] = $weatherInfo;
        }
        //EXECUTE SEARCH BY FILTERED INFORMATION
        $cityWeatherInfo = $this->weatherSearchFilter(@$weatherInfo['county'], @$weatherInfo['city'], @$weatherInfo['from'], @$weatherInfo['to']);
        return $this->render(['cityWeatherInfo' => $cityWeatherInfo, 'county' => $county, 'city' => $city, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }

    public function weatherSearchFilter($county, $city, $from, $to)
    {
        
        $baseQuery = \ORM::for_table('weather')
            ->join('city_map', ['city_map.city_id', '=', 'weather.city_id'])
            ->join('city', ['city_map.city_id', '=', 'city.id'])
            ->join('county', ['county.id', '=', 'city.county_id'])
            ->select_many(
                'weather.id',
                'city_map.name',
                'weather.date',
                'weather.temp',
                'weather.min_temp',
                'weather.max_temp',
                'weather.humidity',
                'weather.wind'
            );
        
        if ($county) {
            $baseQuery->where_like('county.name', "$county%");
        }
        
        if ($city) {
            $baseQuery->where_like('city.name', "$city%");
        }
        
        if ($from) {
            $baseQuery->where_gte('date', $from);
        }
        
        if ($to) {
            $baseQuery->where_lte('date', $to);
        }
        
        return $baseQuery->find_many();
        
    }//end of weatherSearchFilter function 
}//end of City class
