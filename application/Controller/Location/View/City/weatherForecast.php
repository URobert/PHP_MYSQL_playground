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
    .myform {
        margin-top:25px;
    }
    #importUpdate{
        float:right;
    }
</style>

<div class="container containerF">
    <div class="col-md-12 myform">
    <form action="/cities/weather" method="post">
    County:<input type="text" name="county" value="<?= $county; ?>"/>
    *City:<input type="text" name="city" value="<?= $city; ?>" />
    From:<input type="text" name="from" placeholder="YYYY-MM-DD" value="<?= $dateFrom; ?>"/>
    To:<input type="text" name="to" placeholder="YYYY-MM-DD" value="<?= $dateTo; ?>"/>
    <input type="submit" name="SearchWeather" value="Search" class="btn btn-primary"/>
    </form>
    </div>
</div>    

<div class ="container">
        <div class="col-md-12">
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
                    <td class="col-md-2"><?= $entry['name'] ?></td>
                    <td class="col-md-2"><?= $entry['date'] ?></td> 
                    <td class="col-md-2"><?= $entry['temp'] ?>°C</td>
                    <td class="col-md-2"><?= $entry['min_temp'] ?>°C</td>
                    <td class="col-md-2"><?= $entry['max_temp'] ?>°C</td>
                    <td class="col-md-2"><?= $entry['humidity'] ?></td>
                    <td class="col-md-2"><?= $entry['wind'] ?></td>          
                </tr>
            <?php ++$i; ?>
            <?php endforeach ?>
            </table>
        </div>
</div> <!-- end of container -->
<a href="/home2" class="button">RETURN TO MAIN PAGE</a>
<a href="/cities/weatherImport" class="button" id="importUpdate">Import and Update</a></div>