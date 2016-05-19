<?php

namespace TestProject\Controller\Statistics;



class MaxTemperature{
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];

    }
    
    public function action (){
    $temperatureQuery ='SELECT * 
                 FROM   (SELECT *, 
                                ROUND(Max(T.temp),2) AS MAX_TEMP 
                         FROM   (SELECT county.NAME       AS County, 
                                        city.NAME         AS CITY, 
                                        temperature.date  AS DATE, 
                                        temperature.value AS TEMP 
                                 FROM   city, 
                                        county, 
                                        temperature 
                                 WHERE  city.id = temperature.city_id 
                                        AND county.id = city.county_id 
                                 ORDER  BY temperature.value DESC) AS T 
                         GROUP  BY T.county, 
                                   T.city, 
                                   T.date, 
                                   T.temp 
                         ORDER  BY T.temp DESC) AS TT 
                 GROUP  BY TT.county';
    $templating = $this->templating;
    return $templating('temperatureTemplate',['fullConent' => $this->connect->query($temperatureQuery)]);
    }
}

