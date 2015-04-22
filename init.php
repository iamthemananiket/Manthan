<?php

	include 'functions.php';

/*	error_reporting(0);*/

	session_start();
	$conn_error = "ERROR: Unable to connect";
	
	$host = "127.0.0.1";
	$user = "root";
	$pass = "";
	$db_name = 'manthan';

	$db=@mysql_connect($host,$user,$pass) or die($conn_error);
	mysql_select_db($db_name,$db) or die($conn_error);

	if(loggedIn()) {
		$sessionCustId = $_SESSION['Cust_id'];
		$custData = custData($sessionCustId, 'Cust_id', 'Cust_email', 'Password', 'Cust_phone_no');
	}

?>