<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT users.username, users.email, privileges.privilege, users.id FROM users LEFT JOIN privileges on privileges.user_id = users.id WHERE users.id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

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
         Your id: <?php echo $userRow['id']; ?>
         Your id: <?php echo $request_id; ?>

         <a href="logout.php?logout">Sign Out</a>
     </div>
     <div id="create_request">
     	<h1>Create request</h1>
     	
     		<a href="google_trends.php">Google Trends</a>
     </div>
    </div>
</div>
</body>
</html>