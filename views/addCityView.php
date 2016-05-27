<html>
    <body>      
        <table class= "cities">
            <thead>Cities in the DB: </thead>

            <?php foreach($cities as $city): ?>
            <tr>
                <td><?= $city['name'] ?></td>
            </tr>
            <?php endforeach ?>
        </table>
        <form action="/cities/AddCity" method="post">
        <p>Add new city:</p>
        <input type="text" name="city" id="city" class="cityField">
        <input type="submit" value="Add">
        </form>
        
<style>
    form{
        text-align: center;
        margin-top:50px;
    }
    
    .counties,td{
        margin-top:10px;
        margin-left:10px;
    }
</style>

    </body>
</html>

<!--<script language=javascript>
$( "#target" ).submit(function( event ) {
     var countyid = $( " #countyid" ).val();
     var rename = $( " #rename" ).val();
     if (countyid == "" || rename == "") {
        alert( "None of the fields can be empty." );
        event.preventDefault();
     }
    
});
</script>-->