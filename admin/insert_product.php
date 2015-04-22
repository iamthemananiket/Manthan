<!DOCTYPE html>
<html>
<head>
	<title>Insert Product</title>
</head>
<body>
	<h3>Enter Product Details</h3>
	<form method="post" action="">
	<table>
		<tr>
			<td>Product Name*</td>
			<td><input type="text" id="P_name" name="P_name" required><br></td>
		</tr>
		<tr>
			<td>Category Id*</td>
			<td><input type="number" id="Category_id" name="Category_id" min="1" required><br></td>
		</tr>
		<tr>
			<td>Product Description</td>
			<td><textarea name="Description" id="Description" cols="40" rows="5"></textarea><br></td>
		</tr>
		<tr>
			<td>Product Image</td>
			<td><input type="text" id="Img_url" name="Img_url" value="images/imageNotAvailable.jpg"><br></td>
		</tr>
		<tr>
			<td>Availability</td>
			<td><input type="number" id="Availability" name="Availability" min="0" value="0"><br></td>
		</tr>
		<tr>
			<td>Price*</td>
			<td><input type="" id="Price" name="Price" required><br></td>
		</tr>
		<tr>
			<td>Color*</td>
			<td><input type="color" id="Color" name="Color"><br></td>
		</tr>
		<tr>
			<td>Size</td>
			<td><input type="text" id="Size" name="Size"><br></td>
		</tr>
		<tr>
			<td><input type="submit" value="Insert Product" name="submit"><br></td>
		</tr>
	</table>
	</form>
</body>
</html>

<?php

	include '../init.php';

	if(!empty($_POST)) {
		$color = $_POST['Color'];
		$size = $_POST['Size'];
		$pName = $_POST['P_name'];
		$imgUrl = $_POST['Img_url'];
		if ($imgUrl == null) {
			$imgUrl = 'images/imageNotAvailable.jpg';
		}
		$availability = $_POST['Availability'];
		$price = $_POST['Price'];
		$description = $_POST['Description'];
		$categoryId = $_POST['Category_id'];
		$checkCategoryQuery = "SELECT `Category_name` FROM `category` WHERE `Category_id` = $categoryId;";
		if (mysql_num_rows(mysql_query($checkCategoryQuery)) > 0) {
			$insertProductQuery = "INSERT INTO `products` (`Color`, `Size`, `P_name`, `Price`, `Img_url`, `Availability`, `Description`) VALUES ('$color', '$size', '$pName', '$price', '$imgUrl', '$availability', '$description');";
			mysql_query($insertProductQuery);
			$getPidQuery = "SELECT `P_id` FROM `products` WHERE `P_name` = '$pName';";
			$pId = mysql_result(mysql_query($getPidQuery), 0);
			$insertProductToCategoryQuery = "INSERT INTO `product_to_category` (`P_id`, `Category_id`) VALUES ('$pId', '$categoryId');";
			mysql_query($insertProductToCategoryQuery);
			echo "Inserted successfully!";
		} else {
			echo "Invalid category! Product not inserted.";
		}
	}

?>