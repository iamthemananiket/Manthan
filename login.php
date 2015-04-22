<?php

	include 'init.php';
	
	loggedInRedirect();
	includeHeader();

?>

<!DOCTYPE html>
<html>

	<body>

		<h2 style="padding-left: 20px;">Login to your account</h2>

		<form action="" method="post">
			<ul style="list-style-type: none; padding-left: 20px;">
				<li><input type="email" name="Cust_email" placeholder="Enter Email Address" required></li><br>
				<li><input type="password" placeholder="Password" name="Password" required></li><br>
				<li><input type="submit" value="Login" name="login" style="padding: 8px 20px;"></li>
			</ul>
		</form>

		<a href="forgotPassword.php" class="forgotPass" style="padding-left: 20px;">Forgot Password?</a><br><br>

	</body>

</html>

<?php

	if(!empty($_POST)) {
		$email = $_POST['Cust_email'];
		$password = $_POST['Password'];
	}
	if(empty($_POST)) {
		
	} else if(!custExists($email)) {
		echo 'Email doesn\'t exist<br><br>';
	} else {
		$login = login($email, $password);
		if(!$login) {
			echo 'The email or password is incorrect<br><br>';
		} else {
			$_SESSION['Cust_id'] = $login;
			header('Location: index.php');
			exit();
		}
	}

?>

<?php

	include 'footer.html';

?>