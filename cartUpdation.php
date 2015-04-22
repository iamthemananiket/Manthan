<?php

	include 'init.php';

	if(!empty($_POST)) {
		$custId = $_POST['Cust_id'];
		$pId = $_POST['P_id'];
		addToCart($custId, $pId);
		header('Location: cart.php');
	}

?>