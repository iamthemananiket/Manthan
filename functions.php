<?php

	function custData($custId) {
		$data = array();
		$custId = (int)$custId;
		$func_num_args = func_num_args();
		$func_get_args = func_get_args();
		if($func_num_args > 1) {
			unset($func_get_args[0]);
			$fields = '`' . implode('`, `', $func_get_args) . '`';
			$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `customer` WHERE `Cust_id` = $custId;"));
			return $data;
		}
	}

	function signUpCust($signUpData) {
		array_walk($signUpData, 'sanitizeArray');
		$signUpData['Password'] = md5($signUpData['Password']);
		$fields = '`' . implode('`, `', array_keys($signUpData)) . '`';
		$data = '\'' . implode('\', \'', $signUpData) . '\'';
		$query = "INSERT INTO `customer` ($fields) VALUES ($data);";
		mysql_query($query);
	}

	function custExists($email) {
		$email = sanitize($email);
		$query = mysql_query("SELECT count(`Cust_email`) FROM `customer` WHERE `Cust_email` = '$email';");
		return (mysql_result($query, 0) == 1) ? true : false;
	}

	function sanitize($data) {
		return mysql_real_escape_string($data);
	}

	function sanitizeArray(&$data) {
		$data = mysql_real_escape_string($data);
	}

	function login($email, $password) {
		$custId = getCustId($email);
		$email = sanitize($email);
		$password = md5($password);
		$query = mysql_query("SELECT count(`Cust_id`) FROM `customer` WHERE `Cust_email` = '$email' AND `Password` = '$password';");
		return (mysql_result($query, 0) == 1) ? $custId : false;
	}

	function getCustId($email) {
		$email = sanitize($email);
		$query = mysql_query("SELECT `Cust_id` FROM `customer` WHERE `Cust_email` = '$email';");
		return (mysql_result($query, 0, 'Cust_id'));
	}

	function loggedIn() {
		return isset($_SESSION['Cust_id']) ? true : false;
	}

	function protectPage() {
		if(!loggedIn()) {
			header('Locatin: protected.php');
			exit();
		}
	}

	function loggedInRedirect() {
		if(loggedIn()) {
			header('Location: protected.php');
		}
	}

	function notLoggedInRedirect() {
		if(!loggedIn()) {
			header('Location: protectedCart.php');
		}
	}

	function getProductIdList($search) {
		$categoryIdQuery = mysql_query("SELECT `Category_id` FROM `category` WHERE `Category_name` = '$search';");
		$count = mysql_num_rows($categoryIdQuery);
		if($count > 0) {
			$categoryId = mysql_result($categoryIdQuery, 0);
			$pIdQuery = mysql_query("SELECT `P_id` FROM `product_to_category` WHERE `Category_id` = $categoryId;");
		} else {
			$pIdQuery = mysql_query("SELECT `P_id` FROM `products` WHERE `P_name` LIKE '%$search%';");
		}
		$count = mysql_num_rows($pIdQuery);
		$pIdList = array();
		for ($i = 0; $i < $count; $i++) {
			$pIdList[$i] = mysql_result($pIdQuery, $i, 'P_id');
		}
		return $pIdList;
	}

	function getDetailsFromProductIds($searchResult, $sort) {
		$reqdFields = array('P_id', 'P_name', 'Price', 'Img_url');
		$fields = '`' . implode('`, `', $reqdFields) . '`';
		$searchResult = implode(', ', $searchResult);
		if(mysql_query("SELECT count(`P_id`) FROM `products` WHERE `P_id` IN ($searchResult);") == 0) {
			echo '<p>No results found</p>';
		} else {
			$countQuery = mysql_query("SELECT count(`P_id`) FROM `products` WHERE `P_id` IN ($searchResult);");
			$count = mysql_result($countQuery, 0, 'count(`P_id`)');
			if($sort == 'sortByName') {
				$prodQuery = mysql_query("SELECT $fields FROM `products` WHERE `P_id` IN ($searchResult) ORDER BY `P_name`;");
			} else if($sort == 'sortByPrice') {
				$prodQuery = mysql_query("SELECT $fields FROM `products` WHERE `P_id` IN ($searchResult) ORDER BY `Price`;");
			} else {
				$prodQuery = mysql_query("SELECT $fields FROM `products` WHERE `P_id` IN ($searchResult) ORDER BY `P_id`;");
			}
			for ($i = 0; $i < $count; $i++) {
				$idList[$i] = mysql_result($prodQuery, $i, 'P_id');
				$nameList[$i] = mysql_result($prodQuery, $i, 'P_name');
				$priceList[$i] = mysql_result($prodQuery, $i, 'Price');
				$imgUrlList[$i] = mysql_result($prodQuery, $i, 'Img_url');
				if($imgUrlList[$i] == "")
					$imgUrlList[$i] = "images/imageNotAvailable.jpg";
			}
			return array($idList, $nameList, $priceList, $imgUrlList);
		}
	}

	function getSingleProductDetails($pId) {
		$reqdFields = array('P_name', 'Price', 'Img_url', 'Color', 'Size', 'Availability', 'Description');
//		$reqdDetailsFields = array('Description');
//		$reqdSubFields = array('P_name', 'Price', 'Img_url', 'Color', 'Size', 'Availability', 'P_type');
		
		$fields = '`' . implode('`, `', $reqdFields) . '`';
//		$detailsFields = '`' . implode('`, `', $reqdDetailsFields) . '`';
//		$subFields = '`' . implode('`, `', $reqdSubFields) . '`';
		
		$query = mysql_query("SELECT $fields FROM `products` WHERE `P_id` = $pId;");
//		$detailsQuery = mysql_query("SELECT $detailsFields FROM `product_details` WHERE `P_id` = $pId;");
//		$subQuery = mysql_query("SELECT $subFields FROM `sku` WHERE `P_id` = $pId;");

		$data = array();
		for($i = 0; $i < count($reqdFields); $i++) { 
			$data[$i] = mysql_result($query, 0, $reqdFields[$i]);
		}
			
/*		$subData = array();
		for ($i = 0; $i < count($reqdSubFields); $i++) { 
			$subData[$i] = mysql_result($subQuery, 0, $reqdSubFields[$i]);
		}
*/
		return array($data/*, $subData*/);
	}

	function includeHeader() {
		if(loggedIn()) {
			include 'headerIfLoggedIn.html';
		} else {
			include 'headerIfNotLoggedIn.html';
		}
	}

	function getCustEmail() {
		if(loggedIn()) {
			$custId = $_SESSION['Cust_id'];
			$query = mysql_query("SELECT `Cust_email` FROM `customer` WHERE `Cust_id` = $custId;");
			return mysql_result($query, 0);
		}
	}

	function getCountOfItemsInCart() {
		if(loggedIn()) {
			$custId = $_SESSION['Cust_id'];
			$query = mysql_query("SELECT sum(`Cart_qty`) FROM `cart` WHERE `Cust_id` = $custId;");
			$numRows = mysql_result($query, 0);
			return $numRows == null ? 0 : $numRows;
		}
	}

	function addToCart($custId, $pId) {
		$checkExistsQuery = mysql_query("SELECT `Cart_id` FROM `cart` WHERE `Cust_id` = $custId AND `P_id` = $pId;");
		if(mysql_num_rows($checkExistsQuery) == 1) {
			$cartId = mysql_result($checkExistsQuery, 0);
			$cartUpdateQuery = mysql_query("UPDATE `cart` SET `Cart_qty` = `Cart_qty` + 1 WHERE `Cart_id` = $cartId;");
		} else {
			$reqdFields = array('Cust_id', 'P_id', 'Cart_qty');
			$fields = '`' . implode('`, `', $reqdFields) . '`';
			$data = array($custId, $pId, 1);
			$data = '\'' . implode('\', \'', $data) . '\'';
			$cartInsertQuery = mysql_query("INSERT INTO `cart` ($fields) VALUES ($data);");
		}
	}

	function getPriceOfProduct($pId) {
		$query = mysql_query("SELECT `Price` FROM `products` WHERE `P_id` = $pId;");
		return mysql_result($query, 0);
	}

	function getSimilarProductIds($pId) {
		$pName = mysql_result(mysql_query("SELECT `P_name` FROM `products` WHERE `P_id` = '$pId';"), 0);
		$nameParts = explode(" ", $pName);
		$check = "";
		foreach ($nameParts as $str) {
			$check = $check . "`P_name` LIKE ('%" . $str . "%')";
			if($str != $nameParts[count($nameParts) - 1]) {
				$check = $check . " OR ";
			}
		}
		$similarProductQuery = mysql_query("SELECT `P_id` FROM `products` WHERE " . $check . ";");
		$pIdList = array();
		for ($i = 0; $i < mysql_num_rows($similarProductQuery); $i++) {
			if(mysql_result($similarProductQuery, $i) != $pId) {
				array_push($pIdList, mysql_result($similarProductQuery, $i));
			}
		}
		return $pIdList;
	}

?>