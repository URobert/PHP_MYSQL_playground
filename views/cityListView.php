<html>
    <body>
        
    <a href="/cities/<?=$countyId?>/AddCity" id="addCity">Add new city</a>

        <table class="counties"  width="250px" border=1>
            <thead>
                <caption>Lista orase:</caption>
            </thead>
            <?php foreach ($cityList as $city): ?>
                <tr>
                    <td><?= $city['name']?></td>
                    <td><a href="/cities/delete/<?= $city['id'] ?>" id='<?php $city['id']?>'>X</a></td>
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
    
    #addCity{
        color:blue;
        font-weight: bold;
        
    }
</style>