<html>
    <body>
        <form action="/counties/add" method="post">
          
        <!-- get county list from DB -->
        <?php
        include_once 'Add.php';
        $requestCountyList = "SELECT * FROM county";
        $returedList = $this->connect->query($requestCountyList);
        var_dump($returedList);    
              
        ?>  
          County:
          <select name='countyid'>
            <option value='0'>-select county-</option>
            <option value='1'>Bihor</option>
            <option value='1'>Bihor</option>
            <option value='1'>Bihor</option>
            <option value='1'>Bihor</option>
          </select>
        
         <input type="text" name="county" id="county">
          City:
          <input type="text" name="city" id="city">
          <input type="submit" value="Add">
        </form>
        
    </body>
</html>



<style>
    form{
        text-align: center;
        margin-top:50px;
    }
</style>

<!--<script language=javascript>
    console.log($("#county").val());
    if (($("#county").val()).length < 3) {
        alert("None of the fields can be empty. Use full names for both citites and counties.");
    }else{
        console.log("script goes on");
    }
</script>-->