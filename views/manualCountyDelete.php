<?php namespace TestProject\Controller\Counties; ?>
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
                <tr>
                    <td><?= $entry['id'] ?></td>
                    <td><?= $entry['name'] ?></td>
                    <td><button class='btn btn-danger deleteButton' data-id='<?= $entry['id'] ?>'>Delete</button></td>
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
              	
<script language=javascript>
    $('.deletebutton').click(function() {
       var deleteRow = $(this).attr('data-id');
       //console.log(deleteRow + " was deleted");       
        $.ajax({
          type: "POST",
          url: "/county/delete" ,
          data: { id:deleteRow },
          success : function() { 
                     //location.reload();
                     console.log(deleteRow + " was deleted");                           
  
          },
          error       : function() { console.log("Service call failed")}
        });           
       return false;
    });
</script>