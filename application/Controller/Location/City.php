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

        return $this->render(['cityList' => $this->getCityList($id),
                                            'countyId' => $id, ]);
    }

    public function getCityList($id)
    {
        $cities = array();
        $requestCityList = 'SELECT * FROM city WHERE county_id='.$id;
        $returedList = $this->connect->query($requestCityList);
        foreach ($returedList as $city) {
            $cities [] = array('id' => $city['id'], 'name' => $city['name']);
        }

        return $cities;
    }

    public function getCity($id)
    {
        $cities = array();
        $requestCityList = 'SELECT * FROM city WHERE county_id='.$id;
        $returedList = $this->connect->query($requestCityList);
        foreach ($returedList as $city) {
            $cities [] = array('id' => $city['id'], 'name' => $city['name']);
        }

        return $cities;
    }

    public function getCounty($id)
    {
        $countyName = array();
        $requesCounty = 'SELECT name FROM county WHERE id='.$id;
        $return = $this->connect->query($requesCounty);
        foreach ($return as $county) {
            $countyName [] = array('name' => $county['name']);
        }

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
                $checkCity = 'SELECT * FROM city WHERE name="'.$_POST['city'].'" AND county_id='.
                $id.' limit 1';
                $result = $this->connect->query($checkCity);
                if ($result->num_rows) {
                    foreach ($result as $city) {
                        $cityId = $city['id'];
                    }
                    #echo "City ". $city['name'] . " already exists in this county.";
                    echo "<script>
                           alert('This city already exists in this county.');
                          </script>";
                } else {
                    $addNewCity = 'INSERT INTO city (name,county_id)
                                   VALUES ("'.$request->get('city').'",'.$id.')';
                    if ($this->connect->query($addNewCity) === true) {
                        #echo "City sucessfuly added:" . $_POST['city'] . "<br>";
                        echo "<script>
                               alert('City sucessfuly added.');
                              </script>";
                        $cityId = mysqli_insert_id($this->connect);
                    }
                }
            }
        }//end of POST method check
        return $this->render(['cities' => $this->getCity($id),
                                            'countyId' => $id,
                                            'countyName' => $this->getCounty($id), ]);
    }

    public function deleteCityAction($request)
    {
        $id = $request->get('id');
        $cities = 'DELETE FROM city WHERE id='.$id;
        $result = $this->connect->query($cities);
        echo "<script>
               alert('City deleted');
               window.location.href='/home2';
             </script>";

        return $this->render(['id' => $id]);
    }

    public function mapCityAction($request)
    {
        $listofCities [] = ['Oradea', 'Beius', 'Alesd', 'Nucet', 'Brasov', 'Bucuresti', 'London'];
        $appId = '01ffc2b8227e5302ffa7f8555ba7738e';
        $cityAndTemp = array();

        //Getting DB cities and obtaining differences between request and db cities
        $citiesInDB = 'Select name FROM city_map';
        $result = $this->connect->query($citiesInDB);
        foreach ($result as $row) {
            $listInDB [] = $row['name'];
        }
        $diffToImport = array_diff($listofCities[0], $listInDB);
        #$list = implode("','",$diffToImport);
        foreach ($diffToImport as $city) {
            $sqlInsertCities = "INSERT INTO city_map (name, source_id) VALUES ('".$city."', 1)";
            if ($this->connect->query($sqlInsertCities) === true) {
            }
        }

        $completeList = 'SELECT * FROM city_map ORDER BY name';
        $result = $this->connect->query($completeList);
        foreach ($result as $city) {
            $allCities [] = ['name' => $city['name'], 'source_id' => $city['source_id'], 'id' => $city['id'], 'city_id' => $city['city_id']];
        }
        foreach ($allCities as $city) {
            $response = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.$city['name'].'&APPID='.$appId.'&units=metric');
            $response = json_decode($response);
            $cityAndTemp [] = ['city' => $response->name, 'temp' => $response->main->temp, 'source_id' => $city['source_id'], 'id' => $city['id'], 'city_id' => $city['city_id']];
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
        $cityWeatherInfo = $this->weatherSearchFilter($weatherInfo['county'], $weatherInfo['city'], $weatherInfo['from'], $weatherInfo['to']);

        return $this->render(['cityWeatherInfo' => $cityWeatherInfo, 'county' => $county, 'city' => $city, 'dateFrom' => $dateFrom, 'dateTo' => $dateTo]);
    }

    public function weatherSearchFilter($county, $city, $from, $to)
    {
        $cityWeatherInfo = [];
        //WHEN FULL SEARCH DETAILS ARE PROVIDED
        if (!empty($county) && !empty($city) && !empty($from) && !empty($to)) {
            //CHECK IF THE CITY IS IN THAT COUNTY
            $checkCountyID = "SELECT id FROM county WHERE name = '".$county."'";
            $check1 = $this->connect->query($checkCountyID);
            $checkCity = "SELECT county_id FROM city WHERE id = (SELECT city_id FROM city_map WHERE name= '".$city."')";
            $check2 = $this->connect->query($checkCity);
            if ($check1->fetch_assoc()['id'] != $check2->fetch_assoc()['county_id']) {
                echo 'No such city in that county.';
                $cityWeatherInfo = [];

                return $cityWeatherInfo;
            }
            $sqlQuery = "SELECT weather.id, city_map.name, weather.date, weather.temp, weather.min_temp, weather.max_temp, weather.humidity, weather.wind
                         FROM weather
                         JOIN city_map ON city_map.city_id = weather.city_id
                         WHERE city_map.name LIKE '".$city."%'
                         AND weather.date >= '".$from."'
                         AND weather.date <= '".$to."';";
            $sqlReturn = $this->connect->query($sqlQuery);
            while ($row = $sqlReturn->fetch_assoc()) {
                $cityWeatherInfo[] = $row;
            }

            return $cityWeatherInfo;
        } else {
            //CITY AND DATE
            if (!empty($city) && !empty($from) && !empty($to)) {
                $sqlQuery = "SELECT weather.id, city_map.name, weather.date, weather.temp, weather.min_temp, weather.max_temp, weather.humidity, weather.wind
                             FROM weather
                             JOIN city_map ON city_map.city_id = weather.city_id
                             WHERE city_map.name LIKE '".$city."%'
                             AND weather.date >= '".$from."'
                             AND weather.date <= '".$to."';";
                $sqlReturn = $this->connect->query($sqlQuery);
                if ($sqlReturn) {
                    while ($row = $sqlReturn->fetch_assoc()) {
                        $cityWeatherInfo[] = $row;
                    }
                }

                return $cityWeatherInfo;
            }
            //NO DATE PROVIDED
            if (!empty($city) && empty($from) && empty($to)) {
                $sqlQuery = "SELECT weather.id, city_map.name, weather.date, weather.temp, weather.min_temp, weather.max_temp, weather.humidity, weather.wind
                             FROM weather
                             JOIN city_map ON city_map.city_id = weather.city_id
                             WHERE city_map.name LIKE '".$city."%'";
                $sqlReturn = $this->connect->query($sqlQuery);
                if ($sqlReturn) {
                    while ($row = $sqlReturn->fetch_assoc()) {
                        $cityWeatherInfo[] = $row;
                    }
                }

                return $cityWeatherInfo;
            }
            //ONLY START DATE
            if (!empty($city) && !empty($from) && empty($to)) {
                $sqlQuery = "SELECT weather.id, city_map.name, weather.date, weather.temp, weather.min_temp, weather.max_temp, weather.humidity, weather.wind
                             FROM weather
                             JOIN city_map ON city_map.city_id = weather.city_id
                             WHERE city_map.name LIKE '".$city."%'
                             AND weather.date >= '".$from."'";
                $sqlReturn = $this->connect->query($sqlQuery);
                while ($row = $sqlReturn->fetch_assoc()) {
                    $cityWeatherInfo[] = $row;
                }

                return $cityWeatherInfo;
            }
            //ONLY END DATE
            if (!empty($city) && empty($from) && !empty($to)) {
                $sqlQuery = "SELECT weather.id, city_map.name, weather.date, weather.temp, weather.min_temp, weather.max_temp, weather.humidity, weather.wind
                             FROM weather
                             JOIN city_map ON city_map.city_id = weather.city_id
                             WHERE city_map.name LIKE '".$city."%'
                             AND weather.date <= '".$to."';";
                $sqlReturn = $this->connect->query($sqlQuery);
                while ($row = $sqlReturn->fetch_assoc()) {
                    $cityWeatherInfo[] = $row;
                }

                return $cityWeatherInfo;
            }
        }
    }
}//end of City class
