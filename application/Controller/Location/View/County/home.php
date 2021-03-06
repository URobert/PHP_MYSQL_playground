<?php if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
} ?>
<?php #usleep(1000); session_unset(); session_destroy(); ?>

<div class ="container container1">
    <div class="row">
        <div class="col-md-6 col-md-offset-5"><a href="/counties/AddCounty" id="addCounty" class="btn btn-primary">Add new county</a></div>
        <div class="col-md-6 col-md-offset-3">
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

<style>
    #addCounty{
        margin-bottom: 20px;
    }
</style>



