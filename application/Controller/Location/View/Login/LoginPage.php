<?php #var_dump($_SESSION) ?>


<div class="container loginContainer">
    <form action="/home2/login" method="post" class="loginFrom">
        <input type="text" placeholder="Username" name="Username"/>
        <input type="password" placeholder="Password" name="Password"/>
        <input type="submit" value="Login" class="btn btn-primary" id="logIN"/>
    </form>
</div>

<div id="signUp">
    <h4>You don't have an account yet? You can sign up and create an account for free.</h4>
    <a href= "/home2/signUp" class="btn btn-info">Sign Up</a>
</div>

<style>
    .loginContainer{
        text-align: center;
        margin-top: 12%;
    }
    
    #logIN{
        
    }
    
    #signUp{
        text-align: center;
    }
</style>