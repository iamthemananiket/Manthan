<?php

	include 'init.php';
	if(loggedIn()) {
		include 'headerIfLoggedInPayment.html';
	} else {
		includeHeader();
	}

	$reqdFields = array('Cust_id', 'Shipping_address', 'Landmark', 'Pincode', 'City', 'State');

	if(!empty($_POST)) {
		$pId = $_POST['P_id'];
		$name = $_POST['Name'];
		$mobNo = $_POST['Mobile_no'];
		if(loggedIn()) {
			$cartQtyList = $_POST['Cart_qty'];
		}
		if (isset($_POST['paymentNewAddress'])) {
			$shippingAddress = $_POST['Shipping_address'];
			$landmark = $_POST['Landmark'];
			$pincode = $_POST['Pincode'];
			$city = $_POST['City'];
			$state = $_POST['State'];
		} else if(isset($_POST['paymentOldAddress'])) {
			$addressId = $_POST['Address_id'];
			$getAddressQuery = mysql_query("SELECT * FROM `customer_address` WHERE `Address_id` = $addressId;");
			$shippingAddress = mysql_result($getAddressQuery, 0, 'Shipping_address');
			$landmark = mysql_result($getAddressQuery, 0, 'Landmark');
			$pincode = mysql_result($getAddressQuery, 0, 'Pincode');
			$city = mysql_result($getAddressQuery, 0, 'City');
			$state = mysql_result($getAddressQuery, 0, 'State');
		}
	}

	echo "<br>Deliver the following product(s) to Mr./Ms. <b>" . $name . "</b>, living at the following address: " . "<br><br>";
	echo $shippingAddress . ",<br>";
	if($landmark != null) {
		echo "Near " . $landmark . ", ";
	}
	echo  $city . " - " . $pincode . ", " . $state . "<br><br>";
	echo "Mob. No.: +91-" . $mobNo . "<br><br>";

	if(loggedIn() && isset($_POST['paymentNewAddress'])) {
		if(isset($_POST['SaveAddress'])) {
			$fields = '`' . implode('`, `', $reqdFields) . '`';
			$data = '\'' . $_SESSION["Cust_id"] . '\', \'' . $shippingAddress . '\', \'' . $landmark . '\', \'' . $pincode . '\', \'' . $city . '\', \'' . $state . '\'';
			mysql_query("INSERT INTO `customer_address` ($fields) VALUES ($data);");
		}
	}

	if(!loggedIn()) {
		$query = mysql_query("SELECT `P_name`, `Price` FROM `products` WHERE `P_id` = $pId;");
		$pName = mysql_result($query, 0, 'P_name');
		$price = mysql_result($query, 0, 'Price');
		echo "<b>Product(s): </b><br>";
		echo $pName . " - Rs. " . $price . "<br>";
		$reduceAvailabilityQuery = mysql_query("UPDATE `products` SET `Availability` = `Availability` - 1 WHERE `P_id` = $pId;");
	} else {
		$total = 100;
		echo "<b>Product(s): </b><br>";
		for ($i = 0; $i < count($pId); $i++) {
			$query = mysql_query("SELECT `P_name`, `Price` FROM `products` WHERE `P_id` = $pId[$i]");
			$pName = mysql_result($query, 0, 'P_name');
			$price = mysql_result($query, 0, 'Price');
			echo $pName . ' - Rs. ' . $price . ' x ' . $cartQtyList[$i] . '<br>';
			$total += $price * $cartQtyList[$i];
			$reduceAvailabilityQuery = mysql_query("UPDATE `products` SET `Availability` = `Availability` - $cartQtyList[$i] WHERE `P_id` = $pId[$i];");
		}
		echo '<br>Total amount: Rs. ' . $total . ' (Rs. 100 delivery charges included)';
		$custId = $_SESSION['Cust_id'];
		$cartEmptyQuery = mysql_query("DELETE FROM `cart` WHERE `Cust_id` = $custId;");
	}

	echo '<br><br><b>Thank you for shopping!</b><br><br>';

?>

<?php

	include 'footer.html';

?>