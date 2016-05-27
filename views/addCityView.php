<html>
    <body>      
        <form action="/cities/<?=$countyId?>/AddCity" method="post">
        <!--<p>County:</p><input type="text" name="county" id="county" value="<?=$countyId?>" readonly=true><br>-->
        <p>County:</p><input type="text" name="county" id="county" value="<?=$countyName[0]['name']?>" readonly=true><br>
        <p>Add new city:</p>
        <input type="text" name="city" id="city" class="cityField">
        <input type="hidden" name="county_id" value="<?=$countyId?>">
        <input type="submit" value="Add"><br><br>
        <a href="/home" class="button">Back</a>
        </form>

<style>
    a{
        
    }
    form{
        text-align: center;
        margin-top:50px;
    }
    
    .counties,td{
        margin-top:10px;
        margin-left:10px;
    }
    
    #county{
        background: gray;
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