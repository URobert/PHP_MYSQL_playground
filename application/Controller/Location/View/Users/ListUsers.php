<style>
    thead{
        background:#00E5EE;
        font-weight:500;
        border-bottom:solid;
        border-color:black;
    }
    
    .city_id, .source_id{
        max-width:100px;
        background:gray;
    }
    .myform {
        margin-top:25px;
    }
    #importUpdate{
        float:right;
    }
</style>

<div class="container containerF">
    <div class="col-md-12 myform">
    <form action="/home2/users" method="post">
    User:<input type="text" name="username" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"/>
    Email:<input type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
    Status:
    <select name="status">
        <option value="">all</option>
        <option value="1">active</option>
        <option value="0">inactive</option>
    </select>
    <input type="submit" name="SeachUser" value="Search" class="btn btn-primary"/>
    </form>
    </div>
</div>

<div class ="container">
        <div class="col-md-12">
            <table class="table table-striped">
                <caption>Users</caption>
                <thead>
                    <th class="col-md-1">#</th>
                    <th class="col-md-3">User</th>
                    <th class="col-md-3">Email</th>
                    <th class="col-md-2">Status</th>                         
                </thead>
            <?php $i = 1; foreach ($users as $entry): ?>
                <tr>
                    <td class="col-md-1"><?= $i ?></td>
                    <td class="col-md-3"><?= $entry['username'] ?></td>
                    <td class="col-md-3"><?= $entry['email'] ?></td>
                    <td class="col-md-2">
                    <?php if ($entry['status']=='1') echo 'active';
                    else echo 'inactive'
                    ?></td>
                </tr>
            <?php $i++; ?>
            <?php endforeach ?>
            </table>
        </div>
</div> <!-- end of container -->