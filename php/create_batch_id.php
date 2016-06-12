<?php
	session_start();
	include_once 'dbconnect.php';

	if(!isset($_SESSION['user']))
	{
	header("Location: index.php");
	}

	$userid = $_SESSION['user'];
	mysql_query("INSERT INTO requests (user_id) values ('$userid')");
?>