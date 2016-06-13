<?php #var_dump($_SESSION) ?>


<div class="container loginContainer">
    <form action="/home2/login" method="post" class="loginFrom">
        <input type="text" placeholder="Username" name="Username"/>
        <input type="password" placeholder="Password" name="Password"/>
        <input type="submit" value="Login" class="btn btn-primary" id="logIN"/>
    </form>
</div>

<style>
    .loginContainer{
        text-align: center;
        margin-top: 12%;
    }
    
    #logIN{
        
    }
</style>