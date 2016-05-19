<?php

namespace TestProject\Controller\Statistics;

class County_City_Stats {
    
    public function __construct($app){
        $this->connect = $app['connect'];
        $this->templating = $app['templating'];
    }
    
    public function action (){
        $citiesInCounties = 'SELECT county.id, county.name countyName, COUNT(*) nrCities
                            FROM county
                            INNER JOIN city ON county.id=city.county_id
                            GROUP BY county.name';
         
         
        $citiesWithNoCounty = 'SELECT city.id, city.name, county.name countyNAME
        FROM county RIGHT JOIN city ON county.id=city.county_id WHERE city.county_id IS NULL';
        
        $countiesWithNoCities = 'SELECT county.id, county.name countyNAME, city.name
        FROM county LEFT JOIN city ON county.id=city.county_id WHERE city.name IS NULL';
        
        $countiesWithMoreThanTwoCities = 'SELECT county.id, county.name countyName, COUNT(*) nrCities
        FROM county RIGHT JOIN city ON county.id=city.county_id
        GROUP BY county.name HAVING COUNT(*) >= 2 AND countyName IS NOT NULL';
        
        $templating = $this->templating;
        return $templating('countyTemplate',
                              ['citiesInCouties' => $this->connect->query($citiesInCounties),
                               'citiesWithNoCounty'=> $this->connect->query($citiesWithNoCounty),
                               'countiesWithNoCities'=> $this->connect->query($countiesWithNoCities),
                               'countiesWithMoreThanTwoCities' =>$this->connect->query($countiesWithMoreThanTwoCities)]);
    }
    
}