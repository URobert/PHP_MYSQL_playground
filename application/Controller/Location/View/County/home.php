

<html>
    <body>
        <head>
            <link rel="stylesheet" href="/css/bootstrap.min.css">
            <script src="/js/jquery-1.12.3.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>
            <link href='http://fonts.googleapis.com/css?family=Ledger' rel='stylesheet' type='text/css'>
        </head>
            <div class= "wrapper">            
                <a href="/counties/AddCounty" id="addCounty" class="btn btn-primary">Add new county</a>
            </div>    
                    <div class = "container">
                    <div class="row-fluid">
                    <?php foreach ($countylist as $county): ?>
                    <div class="col-md-12 inner">
                            <div class="col-md-4 inner"><a href="/counties/edit/<?= $county['id'] ?>" id='<?php $county['id']?>'><?= $county['name']?></a></div>
                            <div class="col-md-4 inner"><a href="/cities/<?= $county['id'] ?>" id='<?php $city['id']?>'>List of citites</a></div>
                            <div class="col-md-4 inner"><a href="/counties/delete/<?= $county['id'] ?>" id='<?php $county['id']?>' class="btn btn-danger">Delete</a></div>
                    </div>
                    <?php endforeach ?>            
                </div> <!-- end of row -->
            </div> <!-- end of container -->  
    </body>
</html>

<style>
    .counties{
        margin-top: 10%;
        margin-left: 40%;
    }
    
    #addCounty{
        color:white;
        font-weight: bold;
        
    }
    
    .container{
        margin-top: 2%;
        max-width: 270px;
        border: 2px solid gray;
        background-color:rgba(0,0,0,0.8);
    }
    
    .wrapper{
        text-align: center;
        font: 400 15px/1.6 'Ledger', Garamond, Georgia, serif;
    }
    
    body{
        background: url('http://pnimg.net/w/articles/0/545/8da65f4088.png');
    }
    
    a{
      color:white;
      
    }
    
</style>

