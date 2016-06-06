<html>
    <head>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <script src="/js/jquery-1.12.3.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Ledger' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <style>
            thead{
                background:orange;
                font-weight:500;
                border-bottom:solid;
                border-color:black;
            }
            
            .city_id, .source_id{
                max-width:100px;
                background:gray;
            }
        </style>

         <div class ="container">
                <div class="col-md-8">
                    <table class="table table-striped">
                        <caption>Show Weather Report</caption>
                        <thead>
                            <th class="col-md-1">#</th>
                            <th class="col-md-2">City</th>
                            <th class="col-md-2">Date</th>
                            <th class="col-md-1">Temp</th>
                            <th class="col-md-1">Min-Temp</th>
                            <th class="col-md-1">Max-Temp</th>
                            <th class="col-md-1">Humidity</th>
                            <th class="col-md-1">Wind</th>                            
                        </thead>
                    <?php $i = 1; foreach ($cityWeatherInfo as $entry): ?>
                        <tr>
                            <td class="col-md-1"><?= $i ?></td>
                            <td class="col-md-2"><?= $entry['city_id'] ?></td>
<!--                            <td class="col-md-2"><?= $entry['date'] ?></td> -->  
<!--                            <td class="col-md-2"><?= $entry['temp'] ?>°C</td>
                            <td class="col-md-2"><?= $entry['min_temp'] ?>°C</td>
                            <td class="col-md-2"><?= $entry['max_temp'] ?>°C</td>-->
<!--                            <td class="col-md-2"><?= $entry['humidity'] ?>°C</td>
                            <td class="col-md-2"><?= $entry['Wind'] ?>°C</td>   -->       
                        </tr>
                    <?php $i++; ?>
                    <?php endforeach ?>
                    </table>
                </div>
         </div> <!-- end of container -->