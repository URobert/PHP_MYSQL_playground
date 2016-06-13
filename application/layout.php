<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <script src="/js/jquery-1.12.3.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Ledger' rel='stylesheet' type='text/css'>
    </head>
    <body>        
    <style>
        .container0{
                    background: #090f0f;
                    position:fixed;
                    width:100%;
                    z-index:1;
                    margin-left:-1px;
                    min-width:270px;
                  }
                  
        h3,#R{
          color:#cccccc;
          font: 400 30px/1.3 'Bree Serif', Georgia, serif;
          text-decoration: none;
        }
        
        .btn-group{
            margin-top:35px;
        }
              
        .navTop {
            color:#cccccc;
            font: 400 15px/1.3 'Bree Serif', Georgia, serif;
            padding:7px;
        }
        
        .navTop:hover{
            color:white;
        }
    
        
        .container1{
            margin-top:50px;
        }
        
        body{
            background:white;
        }
        
        a{
            color:black;
            font: 400 20px/1.3 'Bree Serif', Georgia, serif;
        }
        
        .inner{
           max-height: 5px;
        }
             
    </style>

    <!-- Building the navbar -->    
     <nav class="navbar navbar-default">
        <div class="container-fluid container0">
          <div class="navbar-header">
            <button type="button" id="nav-button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <h3><a href="/home2" id="R">Romania</a></h3>
          </div>
    
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li><div class ="btn-group">
                <a href="/counties/AddCounty" id="addCounty" class="navTop" >Add new county</a></div>
              </li>
              <li><div class ="btn-group">
                 <a href="/cities/map" id="mapCounty" class="navTop">Import and go to map</a></div>
              </li>
              <li><div class ="btn-group">
                <a href="/cities/weather" id="weather" class="navTop">Weather Forecast</a></div>
              </li>
              <li><div class ="btn-group">
                <a href="/home2/search" id="weather" class="navTop">Search Location</a></div>
              </li>
              <li><div class ="btn-group">
              <?php if(isset($_SESSION['userId'])): ?>
                <a href="/home2/logout" id="weather" class="navTop">Logout</a></div>
              <?php else: ?>
                <a href="/home2/login" id="weather" class="navTop">Login</a></div>
              <?php endif ?>
              </li>
            </ul>
          </div>
      </nav>
       </div> <!-- end of first container | end of navbar-->
       MAIN_CONTENT
       
    </body>
</html>