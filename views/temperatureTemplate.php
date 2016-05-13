<html>
    <body>
        <table>
            <thead>
                <th>CityID</th>
                <th>CountyID</th>
                <th>County</th>
                <th>City</th>
                <th>Date</th>
                <th>Temperature</th>
            </thead>
            
            <tbody>
                <?php while($row = $fullConent->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['city_id'] ?></td>
                    <td><?= $row['countyID'] ?></td>
                    <td><?= $row['nameCounty'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td id=temp><strong><?= $row['value'] ?></strong></td>
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
</style>