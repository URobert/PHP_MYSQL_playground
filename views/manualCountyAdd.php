<html>
    <body>
        <form action="/counties/add" method="post">
           <!--<?php print_r($fullCountyList) ?>--> 
          County:
          <select name='countyid' id='countyid'>
            <option value='0'>-add new-</option>
            <?php for($i = 0; $i < count($fullCountyList); $i+=1): ?>
            <option value='<?php echo $fullCountyList[$i] ?>'><?php echo $fullCountyList[$i] ?></option>
            <?php endfor ?>
            <option value='-1'>Other</option>
          </select>
            <div class="countyField"> 
            <input type="text" name="county" id="county">
            </div>
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
        console.log($("#countyid option:selected").text());
        if ( $("#countyid option:selected").text() == "Other" ){
            $(".countyField").fadeIn("show");
        }
    });
</script>