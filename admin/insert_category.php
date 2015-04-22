<!DOCTYPE html>
<html>
<head>
	<title>Insert Category</title>
</head>
<body>
	<h3>Enter Category Details</h3>
	<form method="post" action="">
	<table>
		<tr>
			<td>Category Name*</td>
			<td><input type="text" id="Category_name" name="Category_name" required><br></td>
		</tr>
		<tr>
			<td><input type="submit" value="Insert Category" name="submit"><br></td>
		</tr>
	</table>
	</form>
</body>
</html>

<?php

	include '../init.php';

	if(!empty($_POST)) {
		$categoryName = $_POST['Category_name'];
		$insertCategoryQuery = "INSERT INTO `category` (`Category_name`) VALUES ('$categoryName');";
		mysql_query($insertCategoryQuery);
		echo "Inserted successfully!";
	}

?>