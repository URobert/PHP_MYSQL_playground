<style>
    thead{
        background:crimson;
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
        <div class="col-md-4">
            <table class="table table-striped">
                <caption>List of imported cities</caption>
                <thead>
                    <th class="col-md-1">#</th>
                    <th class="col-md-2">City</th>
<!--                            <th class="col-md-2">Temperature</th>-->
                    <th class="col-md-1">city_ID</th>
<!--                            <th class="col-md-1">source_ID</th>-->
                </thead>
            <?php $i = 1; foreach ($cityAndTemp as $entry): ?>
                <tr>
                    <td class="col-md-1"><?= $i ?></td>
                    <td class="col-md-2"><a href="/cities/map/search2?mapid=<?= $entry['id'] ?>"</a><?= $entry['city'] ?></td>
<!--                            <td class="col-md-2"><?= $entry['temp'] ?>°C</td>-->
                    <td class="col-md-1"><input type='text' value='<?= $entry['city_id']?>' class='city_id' readonly></td>
<!--                            <td class="col-md-1"><input type='text' value='<?= $entry['source_id']?>' class='source_id' readonly></td>-->
                </tr>
            <?php ++$i; ?>
            <?php endforeach ?>
            </table>
        </div>
 </div> <!-- end of container -->
