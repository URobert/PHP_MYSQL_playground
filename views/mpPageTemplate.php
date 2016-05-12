<html>
    <body>
        <table>
            <thead>
                <th>Domain</th>
                <th>Main_Page</th>
                <th>Clicks</th>
            </thead>
            
            <?php while($element = $domains->fetch_assoc()): ?>
            <tr>
                <td><?= $element["domain"] ?></td>
                <td><?= urldecode($element["main_page"]) ?></td>
                <td><?= $element["clicks"]?></td>
            </tr>
            <?php endwhile; ?> 
        </table>
    </body>
</html>
