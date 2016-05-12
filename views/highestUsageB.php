<html>
    <body>
        <table>
            <thead>
                <th>ID</th>
                <th>PAGE</th>
                <th>SIZE</th>
            </thead>
            <tbody>
                <?php while($row = $fullContent->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td> 
                    <td><?= urldecode($row['Domain_MainPage']) ?></td>
                    <td><?= $row['SIZE'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </body>
</html>




