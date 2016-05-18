<html>
    <body>
        <table>
            <thead>
                <th>County </th>
                <th>CITY </th>
                <th>DATE </th>
                <th>TEMP </th>
                <th>MAX_TEMP</th>

            </thead>
            
            <!-- <tbody>
                <?php /* while($row = $fullConent->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['city_id'] ?></td>
                    <td><?= $row['countyID'] ?></td>
                    <td><?= $row['nameCounty'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td id=temp><strong><?= $row['value'] ?></strong></td>
                </tr>
                <?php endwhile; */?>
            </tbody>-->
            
            <tbody>
                <?php while($row = $fullConent->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['County'] ?></td>
                    <td><?= $row['CITY'] ?></td>
                    <td><?= $row['DATE'] ?></td>
                    <td><?= $row['TEMP'] ?></td>
                    <td><?= $row['MAX_TEMP'] ?></td>

                </tr>
                <?php endwhile; ?>
            </tbody>
            
            
            
        </table>
    </body>
</html>

<style>
    #temp{
        text-align: center;
    }
    table{
        border:solid;
    }
    tr{
        border: solid;
    }
    td {
        border:solid;
        
    }
</style>