<html>
    <body>
        <h1>County Selected= <?php print_r($county[0]['name']) ?> </h1>
        <h2>Edit County information</h2>
        <!--<form class=topform action="/counties/edit/?id='<?=$county[0]['id']?>'" method="get" > -->
        <form id="target" method="post">
            Rename County: <input type="text" name="name" id="rename"><br><br>
            <input type="submit" value="Submit changes">
            <input class="intro" type="hidden" name="id" value='<?=$county[0]['id']?>' id='<?=$county[0]['id']?>' readonly><br><br>
            <input type="hidden" name="countyid" id="countyid"><br><br>
        </form>
    </body>
</html>

<style>
    #target,h2{
        text-align: center;
    }
    .intro{
        background: gray;
        font-style: italic;
    }
</style>


<script language=javascript>
$( "#target" ).submit(function( event ) {
     var rename = $( " #rename" ).val();
     if (rename == "") {
        alert( "None of the fields can be empty." );
        event.preventDefault();
     }
    
});
</script>
