<?php

	include 'init.php';

	if(!empty($_POST)) {
		$cartIdList = $_POST['Cart_id'];
		$pIdList = $_POST['P_id'];
		for($i = 0; $i < count($cartIdList); $i++) {
			$cartQtyList[$i] = $_POST['qtySelect' . $i];
		}
		for ($i = 0; $i < count($cartIdList); $i++) {
			if($cartQtyList[$i] == 0) {
				mysql_query("DELETE FROM `cart` WHERE `Cart_id` = '$cartIdList[$i]';");
				unset($cartIdList[$i]);
				unset($pIdList[$i]);
				unset($cartQty[$i]);
			} else {
				mysql_query("UPDATE `cart` SET `Cart_qty` = '$cartQtyList[$i]' WHERE `Cart_id` = '$cartIdList[$i]';");
			}
		}
		if($_POST['submit'] == "Update Cart and Continue Shopping") {
			header('Location: index.php');
			exit();
		} else if($_POST['submit'] == "Proceed to Checkout") {
			if(count($cartIdList) == 0) {
				header('Location: cart.php');
				exit();
			} else {
				session_start();
				$_SESSION['P_id'] = $pIdList;
				$_SESSION['Cart_qty'] = $cartQtyList;
				$custId = $_SESSION['Cust_id'];
				$checkAddressQuery = mysql_query("SELECT count(*) FROM `customer_address` WHERE `Cust_id` = $custId;");
				if(mysql_result($checkAddressQuery, 0) == 0) {
					header('Location: newAddress.php');
				} else {
					header('Location: deliveryInfo.php');
				}
				exit();
			}
		}
	}
?>