<html>
    <body>
        
    <a href="/counties/AddCounty" id="addCounty">Add new county</a>

        <table class="counties"  width="250px" border=1>
            <thead>
                <caption>Lista judete:</caption>
            </thead>
            <?php foreach ($countylist as $county): ?>
                <tr>
                    <td><a href="/counties/edit/<?= $county['id'] ?>" id='<?php $county['id']?>'><?= $county['name']?></a></td>
                    <td><a href="/cities/index/<?= $county['id'] ?>" id='<?php $county['id']?>'>cities</a></td>
                    <td><a href="/counties/delete/<?= $county['id'] ?>" id='<?php $county['id']?>'>X</a></td>

                </tr>
            <?php endforeach ?>            
        </table>
    </body>
</html>

<style>
    .counties{
        margin-top: 10%;
        margin-left: 40%;
    }
    
    #addCounty{
        color:red;
        font-weight: bold;
        
    }
</style>

