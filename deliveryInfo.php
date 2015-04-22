<?php

	include 'init.php';
	includeHeader();
	notLoggedInRedirect();

	if(!loggedIn()) {
		$pId = $_POST['P_id'];
	} else {
		$pIdList = $_SESSION['P_id'];
		$cartQtyList = $_SESSION['Cart_qty'];
		unset($_SESSION['P_id']);
		unset($_SESSION['Cart_qty']);
	}

?>

<!DOCTYPE html>
<html>

	<body>

		<h2 style="padding-left: 20px;">Delivery Information</h2>

		<form enctype="multipart/form-data" action="payment.php" method="post">
			<ul style="list-style-type: none; padding-left: 20px;">
				Name*<br>
				<li><input type="text" name="Name" required></li>
				<hr>
				<li>
					<?php
						if(!loggedIn()) {
							echo '<input type="hidden" name="P_id" value="'. $pId. '">';
						} else {
							foreach ($pIdList as $pId) {
								echo '<input type="hidden" name="P_id[]" value="'. $pId. '">';
							}
							foreach ($cartQtyList as $cartQty) {
								echo '<input type="hidden" name="Cart_qty[]" value="'. $cartQty. '">';
							}
						}
						$custId = $_SESSION['Cust_id'];
						$checkAddressQuery = mysql_query("SELECT * FROM `customer_address` WHERE `Cust_id` = $custId;");
						if(mysql_num_rows($checkAddressQuery) > 0) {
							for ($i = 0; $i < mysql_num_rows($checkAddressQuery); $i++) {
								?>
								<input type="radio" name="Address_id"
									value=<?php echo '"' . mysql_result($checkAddressQuery, $i, 'Address_id') . '"'; ?>
									<?php if($i == 0) echo ' checked'; ?>>
									<?php
										echo mysql_result($checkAddressQuery, $i, 'Shipping_address') . ",<br>";
										if(mysql_result($checkAddressQuery, $i, 'Landmark') != null) {
											echo 'Near ' . mysql_result($checkAddressQuery, $i, 'Landmark') . ',<br>';
										}
										echo mysql_result($checkAddressQuery, $i, 'City') . '-' . mysql_result($checkAddressQuery, $i, 'Pincode');
										echo ', ' . mysql_result($checkAddressQuery, $i, 'State') . '<br>';
									?>
								</input>
								<?php
									if($i != mysql_num_rows($checkAddressQuery) - 1) {
								?>
								<hr style="border: 1px dashed rgb(150, 150, 150);">
								<?php
									}
							}
						}
					?>
				</li>
				<hr>
				Mobile Number*<br>
				<li><input value="+91" readonly="Readonly text" type="text" size="1"><input type="text" name="Mobile_no"></li><br>
				<li><input type="submit" value="Proceed to Payment" name="paymentOldAddress" style="font-size: 18px;"></li>
			</ul>
		</form>

		<form enctype="multipart/form-data" action="newAddress.php" method="post" style="padding-left: 20px;">
			<?php
				if(loggedIn()) {
					foreach ($pIdList as $pId) {
						echo '<input type="hidden" name="P_id[]" value="'. $pId. '">';
					}
					foreach ($cartQtyList as $cartQty) {
						echo '<input type="hidden" name="Cart_qty[]" value="'. $cartQty. '">';
					}
				}
			?>
			<input type="submit" value="Proceed with different address" name="paymentNewAddress" style="margin-bottom: 10px; font-size: 18px;">
		</form><br>

	</body>

</html>

<?php

	include 'footer.html';

?>