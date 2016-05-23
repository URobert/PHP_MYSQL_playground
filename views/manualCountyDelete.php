<html>

<div class="wrapper">    
<table class="counties">        
            <thead>
                <caption>Lista orase:</caption>
                <th>CityID</th>
                <th>City</th>
            </thead>
                
                <?php while ($entry = $fullConent->fetch_assoc()): ?>
                <tr>
                    <td><?= $entry['id'] ?></td>
                    <td><?= $entry['name'] ?></td>
                    <td><button>Delete</button></td>
                </tr>
                <?php endwhile; ?>

</table>
</div>
</html>

<style>
    .wrapper{
        margin-left: 45%;
</style>