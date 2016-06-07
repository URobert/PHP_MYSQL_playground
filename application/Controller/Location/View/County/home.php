<?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?>
<?php usleep(1000); session_unset(); session_destroy(); ?>

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
                  
        h3{
          color:#cccccc;
          font: 400 30px/1.3 'Bree Serif', Georgia, serif;
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
            background:#a8a8a8;
        }
        
        a{
            color:black;
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
            <h3>Romania</h3>
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
                <a href="/cities/weatherImport" id="weather" class="navTop">Import Weather Forecast</a></div>
              </li>
            </ul>
          </div>
      </nav>
       </div> <!-- end of first container | end of navbar-->



        <div class ="container container1">
<!--            <div class="row btn-group">
                <div class="col-md-3">
                    <a href="/counties/AddCounty" id="addCounty" class="btn btn-primary">Add new county</a>
                </div>
                <div class="col-md-4">
                    <a href="/cities/map" id="mapCounty" class="btn btn-success">Import and go to map</a>
                </div>
                <div class="col-md-4">
                    <a href="/cities/weatherImport" id="weather" class="btn btn-warning">Import Weather Forecast</a>
                </div>                   
            </div>-->
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                    <?php foreach ($countylist as $county): ?>
                        <tr>
                            <td class="col-md-4 inner"><a href="/counties/edit/<?= $county['id'] ?>" id='<?php $county['id']?>'><?= $county['name']?></a></td>
                            <td class="col-md-4 inner"><a href="/cities/<?= $county['id'] ?>" id='<?php $city['id']?>'>List of citites</a></td>
                            <td class="col-md-1 inner"><a href="/counties/delete/<?= $county['id'] ?>" id='<?php $county['id']?>' class="btn btn-danger">Delete</a></td>
                        </tr>
                    <?php endforeach ?>
                    </table>
                </div> <!-- end of row -->
            </div>
        </div> <!-- end of container -->
           
        
        
    </body>
</html>



