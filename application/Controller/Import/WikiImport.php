<?php

namespace TestProject\Controller\Import;

class WikiImport implements \TestProject\Controller\ControllerInterface {
    
    protected $connect;
    protected $source_file = 'test';
    
    public function __construct($app){
        $this->connect = $app['connect'];
    }
    
    public function action () {
    //GETTING FILE CONTENT (TO BE IMPORTED) AND SEPARATING LINES
    $returnMessage = ""; 
        $myfile =  fopen("$this->source_file", "r") or die("Sorry mate, can't open your file.");
        $count = 0;
        while(null != ($line = fgets($myfile)) && $count <= 30) {
                $count++; 
                //echo fgets($myfile) . "<br>";
                $element = explode(" ", $line);
                
    $returnMessage .= $element[1] . "<br>";
                $sql = 'INSERT INTO wikidata (domain, main_page, clicks, size) VALUES (
                \'' . $element[0] . '\',
                \'' . $element[1] . '\',
                \'' . $element[2] . '\',
                \'' . $element[3] . '\')';
                
            if (mysqli_query($this->connect, $sql) === TRUE) {
    $returnMessage .= "Wiki info updated to DB" . "<br>";
            }
        }
    return $returnMessage;
    }
    
}