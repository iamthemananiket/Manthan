<?php

	include 'init.php';

	loggedInRedirect();
	includeHeader();

?>

<!DOCTYPE html>
<html>

	<body>

		<h2 style="padding-left: 20px;">Create a new account</h2>

		<form action="" method="post">
			<ul style="list-style-type: none; padding-left: 20px;">
				<li><input type="email" name="Cust_email" placeholder="Enter Email Address" required></li><br>
				<li><input type="password" name="Password" placeholder="Password" required></li><br>
				<li><input type="text" name="Cust_phone_no" placeholder="Enter Mobile Number" required></li><br>
				<li><input type="submit" value="Create Account" name="create" style="padding: 8px 20px;"></li>
			</ul>
		</form>

	</body>

</html>

<?php

	if(!empty($_POST)) {
		if(custExists($_POST['Cust_email'])) {
			echo 'Email is already registered!';
		} else if(strlen($_POST['Password']) < 6) {
			echo 'Password is too short';
		} else if(strlen($_POST['Cust_phone_no']) != 10 || $_POST['Cust_phone_no'][0] < 7) {
			echo 'Mobile no. is invalid!<br><br>';
		} else {
			$signUpData = array(
				'Cust_email' => $_POST['Cust_email'],
				'Password' => $_POST['Password'],
				'Cust_phone_no' => $_POST['Cust_phone_no'],
			);
			signUpCust($signUpData);
			header('Location: index.php');
			exit();
		}

	}

?>

<?php

	include 'footer.html';

?>