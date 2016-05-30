<?php namespace TestProject\Controller\County; ?>
<html>
			<body>
					<a href="/home" class="button">Back</a><br><br>
			</body>
</html>

<style>
.wrapper{
    margin-left: 45%;
}

.btn-danger, btn {
    padding: 5px;
}

</style>
              	
<!--<script language=javascript>
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
</script>-->