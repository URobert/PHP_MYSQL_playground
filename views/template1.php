<table>
    <thead>
        <th>Number <?php echo $x ?></th>
        <th>Random Nr.</th>
    </thead>
   
    <tbody>
    <?php foreach ($nrArray AS $i): ?>
        <tr>
            <td><?php echo $i[0]; ?></td>
            <td><?php echo $i[1]; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>