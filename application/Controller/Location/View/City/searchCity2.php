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
            <input type="text"/>
            <input name="targetid" type='hidden'/>
            <input type="submit" value="Submit"/>
        </form>
    </body>
</html>