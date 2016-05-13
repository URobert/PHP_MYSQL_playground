<html>
    <body>
        <table class="counties">
            <thead>
                <caption>Orase per Judet:</caption>
                <th>County</th>
                <th>Nr. Cities</th>
            </thead>
            
           
                <?php while ($entry = $citiesInCouties->fetch_assoc()): ?>
                <tr>
                    <td><?= $entry['countyName'] ?></td>
                    <td><?= $entry['nrCities'] ?></td>
                </tr>
                <?php endwhile; ?>
        </table>
        
        <br>        
        <table class="counties">        
            <thead>
                <caption>Orase fara judete asignate:</caption>
                <th>CityID</th>
                <th>City</th>
            </thead>
                
                <?php while ($entry = $citiesWithNoCounty->fetch_assoc()): ?>
                <tr>
                    <td><?= $entry['id'] ?></td>
                    <td><?= $entry['name'] ?></td>
                </tr>
                <?php endwhile; ?>
                
        </table>
        
        <br>
        <table class="counties">
           <thead>
               <caption>Judete fara orase asignate:</caption>
               <th>CountyID</th>
               <th>County</th>
           </thead>
           
               <?php while ($entry = $countiesWithNoCities->fetch_assoc()): ?>
               <tr>
                   <td><?= $entry['id'] ?></td>
                   <td><?= $entry['countyNAME'] ?></td>
               </tr>
               <?php endwhile; ?>
        </table>
        
        <br>
        <table class="counties">
            <thead>
                <caption>Judete cu doua sau mai multe orase:</caption>
                <th>County</th>
                <th>Nr. Cities</th>
            </thead>
            <tbody>
                <?php while ($entry = $countiesWithMoreThanTwoCities->fetch_assoc()): ?>
                <tr>
                    <td><?= $entry['countyName'] ?></td>
                    <td><?= $entry['nrCities'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </body>
    
</html>


<style>
    .counties{
      text-align: center;
      min-width: 200px;
    }
</style>