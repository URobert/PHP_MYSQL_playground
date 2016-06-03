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
            form {
                text-align: center;
                margin-top: 50px;
            }
        </style>
        <form action="/cities/map/search2?mapid=<?= $mapid ?>" method=post>
            <p>Seach city:</p>
            <input type="text" name="userSearch"/>
            <input type="submit" value="Submit"/>
        </form>
        
        <?php if (count($realCityList) > 0): ?>
        <div class = "container searchResult">
            <div class = "row">
                <div class="col-md-4 col-md-offset-4">
                <table class = "table table-bordered">
                    <?php foreach ($realCityList as $city): ?>
                        <tr>
                            <td class="col-md-1 success"><?= $city['name']?></td>
                            <td class="col-md-1 success">
                                <form action="/cities/map/success" method="get">
                                    <input type='hidden' name='mapid' value='<?= $mapid ?>'/>
                                    <input type='hidden' name='targetid' value='<?= $city['id']; ?>'/>
                                    <input type='submit' value='MAP'/>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </table>
                </div>
            </div>
        </div <!--end of container-->
        <?php endif ?>  
    </body> 
</html>