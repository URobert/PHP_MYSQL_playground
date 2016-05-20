<?php

namespace TestProject\Controller\Statistics;

class MostPopularPage implements \TestProject\Controller\ControllerInterface {
    
    public function __construct($app) {
    $this->connect = $app['connect'];
    $this->templating = $app['templating'];
    }  
 
    public function action() {

    $sqlDomains ='SELECT domain,main_page, clicks
    FROM (SELECT * FROM wikidata ORDER by clicks DESC) AS T
    GROUP BY domain
    ORDER BY clicks DESC LIMIT 10';
    
    $result  = $this->connect->query($sqlDomains);
    $templating = $this->templating;
    return $templating('mpPageTemplate', ['domains' => $result]);
    }
    
}