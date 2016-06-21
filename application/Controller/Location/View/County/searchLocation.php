<style>
    thead{
        background: green;
        color:white;
        font-weight: bold;
    }
    
    .seach{
        text-align: center;
    }
    
    form {
        text-align: center;
        margin-top: 50px;
    }
    

</style>

<div class ="container container1">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="/home2/search" method=post>
                <select name="SearchBy">
                    <option value="County" <?php if ( isset($category) && $category == "County") echo "selected";?>>by county</option>
                    <option value="City" <?php if ( isset($category) && $category == "City") echo "selected";?>>by city</option>
                </select>
                <?php if(isset($_POST['submit'])) 
                $selected_val = $_POST['Search'];
                ?>
                <input type="text" name="userSearch" id="userSearch" value="<?php if ( isset($searchTerm)) echo $searchTerm; ?>"/>
                <input type="submit" value="Search" class="btn btn-primary"/></span>
            </form>                    
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>County</td>
                        <td>City</td>
                    </tr>
                </thead>
            <?php
                $county = array ();
                $county[0] = "";
                $i = 1;
            ?>
            <?php foreach ($countiesAndCities as $row): ?>
                <tr>
                    <td class="col-md-4 inner"><a href="/counties/edit/<?= $row['id'] ?>" id='<?php $row['id']?>'>
                    <?php $county[$i] = $row['County']; if ($row['County'] != $county[$i-1]) echo $row['County']; else echo ""; $i += 1; ?></a>
                    <td class="col-md-4 inner"><a href="/cities/<?= $row['id'] ?>" id='<?php $row   ['id']?>'><?= $row['City']?></a></td>
                </tr>
            <?php endforeach ?>
            </table>
        </div> <!-- end of row -->
    </div>
</div> <!-- end of container -->

