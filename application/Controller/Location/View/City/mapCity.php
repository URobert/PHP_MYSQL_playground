<html>
    <head>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <script src="/js/jquery-1.12.3.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Ledger' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <style>
            thead{
                background:crimson;
                font-weight:500;
                border-bottom:solid;
                border-color:black;
            }
        </style>
        
         <div class ="container">
                    <table class="table table-striped">
                        <caption>List of imported cities</caption>
                        <thead>
                            <th class="col-md-1">#</th>
                            <th class="col-md-2">City</th>
                            <th class="col-md-2">Temperature</th>
                            <th class="col-md-1">county_ID</th>
                            <th class="col-md-1">Set/Update</th>                            
                        </thead>
                    <?php $i = 1; foreach ($cityAndTemp as $entry): ?>
                        <tr>
                            <td class="col-md-1"><?= $i ?></td>
                            <td class="col-md-2"><a href="#"><?= $entry['city'] ?></a></td>
                            <td class="col-md-2"><?= $entry['temp'] ?>°C</td>
                            <td class="col-md-1"><input type='text' value='Null' class='county_id'></td>
                            <td class="col-md-1"><button class="btn btn-primary">Set/Update</button></td>
                        </tr>
                    <?php $i++; ?>
                    <?php endforeach ?>
                    </table>            
         </div> <!-- end of container -->
         
    </body>