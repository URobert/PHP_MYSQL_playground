<div class="container-fluid" id="signUp_container">
  <div class="row">
  <div class="col-md-6">
  <h3 id="sUP">SIGN UP</h3> 
    <div class="SignUp_FORM">
    <form action='/home2/signUp' class="signUpclass" method="post">
        <input type="text" name="username" class="inputFields" placeholder="Username*"><br><br> 
        <input type="password" name="password" class="inputFields" placeholder="Password*"><br><br>
        <input type="password" name="passwordVerify" class="inputFields" placeholder="PasswordCheck*"><br><br>
        <input type="text" name="emailAddress" class="inputFields"  placeholder="Email Address*"><br><br>
        <div id="status">
        Account status:<br><input type="radio" name="status" value="active" class="radioB" checked/>Active<br>
               <input type="radio" name="status" value="inactive" class="radioB"/>Inactive<br>
        <input type="submit" id="signUpButton" value="Sign Up">
        </div>
    </form>
    </div> <!-- end of contact_form -->
  </div> <!--end of col-xs-6 -->
  

<style>
    

#signUp_container{
    margin-top:5%;
    text-align: center;
    border:solid;
    border-color:#5bc0de;
    width:40%;
    max-width:270px;
    max-height: 570px;
}

#status{
    margin-right: -125px; 
}

.SignUp_FORM{
  height:auto;
}

#sUP{ 
    margin-top:-0px;
    color:black;
    padding:25px;
    margin-right: -125px;
}

input:focus {
    outline-width: 0;
}

.inputFields{
    border:hidden;
    border-bottom: 2px solid #d3d3d3;    
    margin-right: 39px; 
    min-width: 220px;
    width:auto;
    -webkit-transition: 0.5s ease;
            transition: 0.5s ease;
  
  
}

.inputFields:hover{
    -webkit-transition: 0.5s ease;
            transition: 0.5s ease;
    border-bottom: 2px solid black;
    min-width: 220px;
    width:auto;
    margin-right: 39px;
}


#signUpButton{
  color:gray;
  border:solid;
  border-width:thin;
  padding:10px;
  margin-top:5px;
}

#signUpButton:hover{
  color:black;
}

.signUp_container{
  margin-top:-10px;
}
</style>