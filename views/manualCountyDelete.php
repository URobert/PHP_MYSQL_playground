<html>

<div class="wrapper">    
<table class="counties">        
            <thead>
                <caption>Lista orase:</caption>
                <th>CityID</th>
                <th>City</th>
            </thead>
                <?php $buttonID= "";  ?>
                <?php while ($entry = $fullConent->fetch_assoc()): ?>
                <?php $buttonID = $entry['name'] ?>
                <tr>
                    <td><?= $entry['id'] ?></td>
                    <td><?= $entry['name'] ?></td>
                    <td><button class='btn btn-danger deleteButton' id='<?php echo $buttonID?>'>Delete</button></td>
                </tr>
                <?php endwhile; ?>
        
</table>
</div>
</html>

<style>
.wrapper{
    margin-left: 45%;
}

.btn-danger, btn {
    padding: 5px;
}

</style>
              	
