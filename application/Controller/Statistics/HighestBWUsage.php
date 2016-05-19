<?php

namespace TestProject\Controller\Statistics;

class HighestBWUsage {
    
    public function __construct($app) {
    $this->connect = $app['connect'];
    $this->templating = $app['templating'];
    }
    
    public function action (){
    $sqlQuery3 = 'SELECT id, SUBSTR(CONCAT(domain,".",main_page),1,10) Domain_MainPage,
            CASE
            WHEN (Round(cs / Pow(1024, 4), 2)> 1) THEN CONCAT(Round(cs / Pow(1024, 4), 2)," ","TB")
            WHEN (Round(cs / Pow(1024, 3), 2)> 1) THEN CONCAT(Round(cs / Pow(1024, 3), 2)," ","GB")
            WHEN (Round(cs / Pow(1024, 2), 2)> 1) THEN CONCAT(Round(cs / Pow(1024, 2), 2)," ","MB")
            ELSE NULL
            END AS SIZE
            FROM
            (SELECT id,domain,main_page,Sum(clicks * size) AS CS 
            FROM wikidata GROUP BY main_page) AS W
            ORDER BY CS DESC limit 20';
            
    $result= $this->connect->query($sqlQuery3);
    $templating = $this->templating;
    return $templating('highestUsageB', ['fullContent' => $result]);
    }
    
}

