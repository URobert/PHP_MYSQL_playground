<html>
    <head>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
        <script src="/js/jquery-1.12.3.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Ledger' rel='stylesheet' type='text/css'>
    </head>
    <body>        

        <div class ="container">
            <div class="row">
                <div class="col-md-8">
                    <a href="/counties/AddCounty" id="addCounty" class="btn btn-primary">Add new county</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered">
                    <?php foreach ($countylist as $county): ?>
                        <tr>
                            <td class="col-md-5 inner"><a href="/counties/edit/<?= $county['id'] ?>" id='<?php $county['id']?>'><?= $county['name']?></a></td>
                            <td class="col-md-5 inner"><a href="/cities/<?= $county['id'] ?>" id='<?php $city['id']?>'>List of citites</a></td>
                            <td class="col-md-2 inner"><a href="/counties/delete/<?= $county['id'] ?>" id='<?php $county['id']?>' class="btn btn-danger">Delete</a></td>
                        </tr>
                    <?php endforeach ?>
                    </table>
                </div> <!-- end of row -->
            </div>
        </div> <!-- end of container -->  
    </body>
</html>

