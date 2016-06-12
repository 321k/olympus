<?php
	session_start();
	include_once 'dbconnect.php';

	if(!isset($_SESSION['user']))
	{
	header("Location: index.php");
	}
	$userid = $_SESSION['user'];
	$keyword_1 = mysql_real_escape_string($_POST['keyword_1']);
	$keyword_2 = mysql_real_escape_string($_POST['keyword_2']);
	$keyword_3 = mysql_real_escape_string($_POST['keyword_3']);
	$keyword_4 = mysql_real_escape_string($_POST['keyword_4']);
	$keyword_5 = mysql_real_escape_string($_POST['keyword_5']);
	$country = mysql_real_escape_string($_POST['country']);
	$region = mysql_real_escape_string($_POST['region']);
	$year = mysql_real_escape_string($_POST['year']);
	$month = mysql_real_escape_string($_POST['month']);
	$lenght = mysql_real_escape_string($_POST['lenght']);



	mysql_query("INSERT INTO requests (user_id) values ('$userid')");
	$request_id = mysql_query("SELECT max(id) AS request_id FROM requests WHERE requests.user_id=".$_SESSION['user']);
	$request_id = mysql_fetch_array($request_id);
	$request_id = $request_id['request_id'];
 	mysql_query("INSERT INTO request_contents (
 		request_id
 		, keyword_1
 		, keyword_2
 		, keyword_3
 		, keyword_4
 		, keyword_5
 		, country
 		, region
 		, year
 		, month
 		, length
 		) 
 		values (
 		'$request_id'
 		,'$keyword_1'
		,'$keyword_2'
		,'$keyword_3'
		,'$keyword_4'
		,'$keyword_5'
		,'$country'
		,'$region '
		,'$year'
		,'$month'
		,'$lenght'
 		)
 		");
?>