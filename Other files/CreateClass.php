<?php

#echo "ok mate";

class Person {
    const AVG_LIFE_SPAN = 79;
    
    private $firstName;
    private $lastName;
    private $yearBorn;

    function __construct($tempFirst="", $tempLast="", $tempBorn=""){
        echo "Person Construct".PHP_EOL;
        $this->firstName = $tempFirst;
        $this->lastName= $tempLast;
        $this->yearBorn = $tempBorn;
    }
    
    public function getFirstName(){
        return $this->firstName.PHP_EOL;;
    }
    
    public function setFirstName($temp){
        $this->firstName = $temp;
    }
    
    protected function getFullName(){
        echo "Person->getFullName()".PHP_EOL;
        return  $this->firstName." ".$this->lastName.PHP_EOL;
    }

}

$myObject = new Person("Alex","Wade",1989);

class Author extends Person{
    public static $centuryPopular= "19th"; 
    private $penName = " Mark T.";
    
    public function getPenName()
    {
     return $this->penName.PHP_EOL;   
    }
    
    public function getCompleteName(){
    return  $this->getFullName(). $this->penName;
    }
    
    public static function getCenturyAuthorWasPopular(){
        return self::$centuryPopular;
    }
}

echo Author::getCenturyAuthorWasPopular();