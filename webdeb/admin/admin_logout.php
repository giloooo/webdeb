<?php
	session_start();
	if (!isset($_SESSION['email']) && !isset($_SESSION['password']))
	{
		header('location: ../index.php');
	}
	else
	{
		session_destroy();
		header('location: admin_login.php');
	}
?>