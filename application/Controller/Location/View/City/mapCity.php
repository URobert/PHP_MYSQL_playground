<?php echo "Imported cities will be displayed here." . "<br>" ?>

<?php
$listofCities [] = ['Oradea','Salonta','Marghita','Sacueni','Beius', 'Alesd', 'Vascau', 'Nucet'];
$appId = "01ffc2b8227e5302ffa7f8555ba7738e";


foreach ($listofCities[0] as $city){
    $response =  file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=' . $city .
                                   '&APPID='.$appId.'&units=metric');
    $response = json_decode($response);
    echo $response->name . " ";
    echo $response->main->temp . "<br>";


}
//
//$response =  file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=London&APPID=01ffc2b8227e5302ffa7f8555ba7738e&units=metric');
//$response = json_decode($response);
//echo $response->name . "<br>";
//echo $response->main->temp;

//echo "<pre>";
//print_r($response);
//echo "</pre>";
?>