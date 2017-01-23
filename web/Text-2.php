<?php
$totalPrice = 0;
?>
<table>
<thead>
<tr>
<th>Artikel</th>
<th>Antal</th>
<th>Pris/st</th>
<th>Summa</th>
</tr>
</thead>
<?php
for ($i=0; $i < count($products); $i++) {
$item = $products[$i]["title"];
$price = $products[$i]["price"];
$quantity = $_POST[$i];
$totalItemPrice = $price * $quantity;
if ($quantity == 0) {
continue;
}
$totalPrice += $totalItemPrice;
?>
<tbody>
<tr>
<td> <?php echo $item ?></td>
<td> <?php echo $quantity ?>st</td>
<td> <?php echo $price ?>kr</td>
<td> <?php echo $totalItemPrice ?>kr</td>
</tr>
</tbody>
</table>