<html>
    <body>
        <h1>County Selected= <?php print_r($county[0]['name']) ?> </h1>
        <h2>Edit County information</h2>
        <!--<form class=topform action="/counties/edit/?id='<?=$county[0]['id']?>'" method="get" > -->
        <form id="target">        
            Set CountyID: <input type="text" name="countyid" id="countyid"><br><br>
            Rename County: <input type="text" name="name" id="rename"><br><br>
            <input type="submit" value="Submit changes"> 
        </form>
    </body>
</html>


<style>
    #target,h2{
        text-align: center;
    }
</style>

<script language=javascript>

//if ($( "#countyid").val( {}

$( "#target" ).submit(function( event ) {
     var countyid = $( " #countyid" ).val();
     var rename = $( " #rename" ).val();
     if (countyid == "" || rename == "") {
        alert( "Fields can not be empty." );
     }
    event.preventDefault();
});
</script>
