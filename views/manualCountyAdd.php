<html>
    <body>
        <form action="/counties/add" method="post">
          <!--  <?php var_dump($counties) ?> --> 
          County:
          <select name='countyid' id='countyid'>
            <option value='0'>-add new-</option>
            <?php foreach($counties as $county): ?>
            <option value='<?= $county['id'] ?>'><?= $county['name'] ?></option>
            <?php endforeach ?>
            <option value='-1'>Other</option>
          </select>
            <input type="text" name="county" id="county" class="countyField">
          City:
          <input type="text" name="city" id="city">
          <input type="submit" value="Add">
        </form>
        
<style>
    form{
        text-align: center;
        margin-top:50px;
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

<script language=javascript>
    $(".countyField").hide();
    
    $("#countyid").change(function (){
        console.log($(this).val());
        if ( $(this).val() == -1 ){
            $(".countyField").fadeIn("show");
        } else {
            $(".countyField").hide();
        }
    });
</script>