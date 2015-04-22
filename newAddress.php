<?php

	include 'init.php';
	includeHeader();

	if(isset($_SESSION['P_id'])) {
		$pIdList = $_SESSION['P_id'];
		$cartQtyList = $_SESSION['Cart_qty'];
		unset($_SESSION['P_id']);
		unset($_SESSION['Cart_qty']);
	} else if(!empty($_POST)) {
		$pIdList = $_POST['P_id'];
		if(loggedIn()) {
			$cartQtyList = $_POST['Cart_qty'];
		}
	}

?>

	<h2 style="padding-left: 20px;">Delivery Information</h2>

	<form action="payment.php" method="post">
		<ul style="list-style-type: none; padding-left: 20px;">
			Name*<br>
			<li><input type="text" name="Name" required></li><br>
			Shipping Address*<br>
			<li><textarea name="Shipping_address" id="Shipping_address" cols="50" rows="4" required></textarea></li><br>
			Landmark<br>
			<li><input type="text" name="Landmark" placeholder="Optional"></li><br>
			Pincode*<br>
			<li><input type="text" name="Pincode" required></li><br>
			City*<br>
			<li><input type="text" name="City" required></li><br>
			State*<br>
			<li><input type="text" name="State" required></li><br>
			Mobile Number*<br>
			<li><input value="+91" readonly="Readonly text" type="text" size="1"><input type="text" name="Mobile_no"></li><br>
			<?php if(loggedIn()) { ?>
				<li><input type="checkbox" name="SaveAddress"> Save Address</li><br>
			<?php }
				if(loggedIn()) {
					foreach ($pIdList as $pId) {
						echo '<input type="hidden" name="P_id[]" value="'. $pId. '">';
					}
					foreach ($cartQtyList as $cartQty) {
						echo '<input type="hidden" name="Cart_qty[]" value="'. $cartQty. '">';
					}
				} else {
					echo '<input type="hidden" name="P_id" value="'. $pIdList. '">';
				}
			?>
			<li><input type="submit" value="Proceed to Payment" name="paymentNewAddress" style="font-size: 18px;"></li>
		</ul>
	</form>

<?php

	include 'footer.html';

?>