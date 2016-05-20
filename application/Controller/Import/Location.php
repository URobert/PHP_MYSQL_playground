<?php

namespace TestProject\Controller\Import;


class Location implements \TestProject\Controller\ControllerInterface {
    
    protected $connect;
    protected $source_file = "judete.csv";
    
    public function __construct($app) {
        $this->connect = $app['connect'];
    }
    
    public function action() {
        $returnMessage = "FFFFFFF.......";
        $fileContent = file_get_contents($this->source_file);
        $lines = explode("\n", $fileContent);
        
        for ($i=1; $i < count($lines) -1; $i++){
            $elements = explode(",", $lines[$i]);
            $sql = 'INSERT INTO county (name) VALUES (\'' . $elements[1] . '\')';
            echo "<br>";
            echo $sql;
     
            if (mysqli_query($this->connect, $sql) === TRUE) {
                #printf("County added!\n");
                $returnMessage = "<br>"."Counties added to DB!" . "<br>";
            }       
        }
        return $returnMessage;
    }
}