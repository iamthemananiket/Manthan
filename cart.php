<?php

	include 'init.php';
	includeHeader();
	notLoggedInRedirect();

?>

<!DOCTYPE html>
<html>

	<body>

		<h2>Shopping Cart (<?php $items = getCountOfItemsInCart(); echo $items; ?> Item<?php if($items != 1) echo 's'; echo ')'; ?></h2>

		<?php if($items != 0) { ?>

			<table>

				<thead>
					<th style="width: 50%; text-align: left; padding-left: 15px;">Item Description</th>
					<th style="width: 10%;">Item Code</th>
					<th style="width: 10%;">Price</th>
					<th style="width: 10%;">Quantity</th>
					<th style="width: 10%;">Amount</th>
				</thead>

<?php

	$custId = $_SESSION['Cust_id'];
	$getCartIdQuery = mysql_query("SELECT `Cart_id` FROM `cart` WHERE `Cust_id` = $custId;");
	$cartIds = array();
	$pIdList = array();
	$cartQtyList = array();
	for ($i = 0; $i < mysql_num_rows($getCartIdQuery); $i++) {
		$cartIds[$i] = mysql_result($getCartIdQuery, $i);
	}
	$reqdFields = array('Img_url', 'P_name', 'Price');
	$fields = '`' . implode('`, `', $reqdFields) . '`';
	$subTotal = 0;
	for ($i = 0; $i < count($cartIds); $i++) {
		$pId = mysql_result(mysql_query("SELECT `P_id` FROM `cart` WHERE `cart_id` = $cartIds[$i];"), 0);
		$pIdList[$i] = $pId;
		$query = mysql_query("SELECT $fields FROM `products` WHERE `P_id` = $pId;");
	?>

			<form action="cartValidation.php" method="post" style="text-align: right; clear: both; padding-top: 10px;">

			<tr>
					<td style="text-align: left;">
						<img src=<?php echo '"' . (mysql_result($query, 0, 'Img_url') == null ? 'images/imageNotAvailable.jpg' : mysql_result($query, 0, 'Img_url')) . '"';?> class="productImageInCart">
						<?php echo mysql_result($query, 0, 'P_name');?>
					</td>
					<td>
						<?php echo $pId; ?>
					</td>
					<td>
						<?php echo "Rs. " . mysql_result($query, 0, 'Price');?>
					</td>
					<td>
						<select name=<?php echo '"qtySelect' . $i . '"';?>>
							<?php
								$cartQtyList[$i] = mysql_result(mysql_query("SELECT `Cart_qty` FROM `cart` WHERE `Cart_id` = $cartIds[$i];"), 0);
								$availabilityQuery = "SELECT `availability` FROM `products` WHERE `P_id` = $pId;";
								$totalAvailable = mysql_result(mysql_query($availabilityQuery), 0);
								for ($j = 0; $j <= $totalAvailable; $j++) {
									echo '<option value="' . $j . '" ';
									if($cartQtyList[$i] == $j) {
										echo 'selected = "selected"';
									}
									echo '>' . $j . '</option>';
								}
							?>
						</select>
					</td>
					<td>
						<?php
							$amount = mysql_result($query, 0, 'Price') * mysql_result(mysql_query("SELECT `Cart_qty` FROM `cart` WHERE `Cart_id` = $cartIds[$i];"), 0);
							echo "Rs. " . $amount;
							$subTotal += $amount;
						?>
					</td>
				</tr>

	<?php
	}

?>
		
		</table>

		<br>

		<div class="cartSum">
			<ul>
				<li>Subtotal: Rs. <?php echo $subTotal; ?></li>
				<li>Delivery Charges: Rs. 100.00</li>
			</ul>
		</div>

		<hr style="width: 17%; float: right; margin-top: -5px;">

		<div class="orderTotal">
			
			<b>Order Total: Rs. <?php echo $subTotal + 100.00; ?></b><br><br>

		</div>

			<?php
				foreach($cartIds as $cartId) {
					echo '<input type="hidden" name="Cart_id[]" value="'. $cartId. '">';
				}
				foreach ($pIdList as $pId) {
					echo '<input type="hidden" name="P_id[]" value="'. $pId. '">';
				}
			?>
			<input type="submit" value="Update Cart and Continue Shopping" name="submit" style="font-size: 18px; padding: 8px 16px;">
			<input type="submit" value="Proceed to Checkout" name="submit" style="font-size: 18px; padding: 8px 16px;">
			<br><br>

		</form>

		<?php } else { ?>
			<p>The cart is empty</p>
		<?php } ?>

	</body>

</html>

<?php

	include 'footer.html';

?>