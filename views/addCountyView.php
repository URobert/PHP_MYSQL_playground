<html>
    <body>      
        <table class= "counties">
            <thead>Counties in current DB: </thead>
            <?php foreach($counties as $county): ?>
            <tr>
                <td><?= $county['name'] ?></td>
            </tr>
            <?php endforeach ?>
        </table>
        <form action="/counties/AddCounty" method="post">
        <p>Add new county:</p>
        <input type="text" name="county" id="county" class="countyField">
        <input type="submit" value="Add"><br>
        <a href="/home" class="button">Back</a>
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
    console.log($("#county").val());
    if (($("#county").val()).length < 3) {
        alert("None of the fields can be empty. Use full names for both citites and counties.");
    }else{
        console.log("script goes on");
    }
</script>-->

<!--<script language=javascript>
    $(".countyField").hide();
    
    $("#countyid").change(function (){
        console.log($(this).val());
        if ( $(this).val() == -1 ){
            $(".countyField").fadeIn("show");
        } else {
            $(".countyField").hide();
        }
    });
</script>-->