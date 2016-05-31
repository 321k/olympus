<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users LEFT JOIN privileges on privileges.user_id = users.id WHERE users.id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

if(isset($_POST['btn-request']))
{
 $content1 = mysql_real_escape_string($_POST['content1']);
 $content2 = mysql_real_escape_string($_POST['content2']);
 $content3 = mysql_real_escape_string($_POST['content3']);
 $userid = $userRow['id'];
 mysql_query("INSERT INTO requests (user_id) values ('$userid')");
 mysql_query("INSERT INTO request_contents (request_id, content, status) values (LAST_INSERT_ID(), $content1, 'added_by_user')");

 header("Location: create_request.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>
<link rel="stylesheet" href="../css/main.css" type="text/css" />
<link rel="stylesheet" href="../css/normalize.css" type="text/css" />
</head>
<body>
<div id="header">
 <div id="left">
    <label>Google Trends Watch</label>
    </div>
    <div id="right">
     <div id="content">
         User name: <?php echo $userRow['username']; ?>
         Email: <?php echo $userRow['email']; ?>
         Your status is: <?php echo $userRow['privilege']; ?>
         <a href="logout.php?logout">Sign Out</a>
     </div>
     <div id="create_request">
     	<h1>Create request</h1>
     	<form method="post">
			<table align="center" width="30%" border="0">
			<tr>
			<td><input type="text" name="content1" placeholder="Content 1" required /></td>
			</tr>
			<tr>
			<td><input type="text" name="content2" placeholder="Content 2" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="content3" placeholder="Content 3" required/></td>
			</tr>
			<tr>
			<td><button type="submit" name="btn-request">Get data</button></td>
			</tr>
			</table>
		</form>
     </div>
    </div>
</div>
</body>
</html>