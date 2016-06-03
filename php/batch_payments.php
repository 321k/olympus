<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}
$res=mysql_query("SELECT users.username, users.email, privileges.privilege, users.id FROM users LEFT JOIN privileges on privileges.user_id = users.id WHERE users.id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);

$userid = $userRow['id'];

if(isset($_POST['btn-request']))
{
	$X_Authorization_key = mysql_real_escape_string($_POST['X_Authorization_key']);
	$X_Authorization_token = mysql_real_escape_string($_POST['X_Authorization_token']);
	$Postman_Token = mysql_real_escape_string($_POST['Postman_Token']);
	$amount = mysql_real_escape_string($_POST['amount']);
	$amountCurrency = mysql_real_escape_string($_POST['amountCurrency']);
	$profile = mysql_real_escape_string($_POST['profile']);
	$recipientId = mysql_real_escape_string($_POST['recipientId']);
	$sourceCurrency = mysql_real_escape_string($_POST['sourceCurrency']);
	$targetCurrency = mysql_real_escape_string($_POST['targetCurrency']);

 	$content = array($X_Authorization_key, $X_Authorization_token, $Postman_Token, $amount, 
 		$amountCurrency, $profile, $recipientId, $sourceCurrency, $targetCurrency);
 	
 	mysql_query("INSERT INTO batches (user_id) values ('$userid')");
 	$batch_id = mysql_query("SELECT max(id) AS batch_id FROM batches WHERE batches.user_id=".$_SESSION['user']);
 	$batch_id = mysql_fetch_array($batch_id);
 	$batch_id = $batch_id['batch_id'];
 	mysql_query("INSERT INTO batch_contents (batch_id, 
 							X_Authorization_key	,
							X_Authorization_token,
							Postman_Token,
							amount,
							amountCurrency,
							profile,
							recipientId,
							sourceCurrency,
							targetCurrency) 
 				values ('$batch_id', 
 					'$X_Authorization_key',
					'$X_Authorization_token',
					'$Postman_Token',
					'$amount',
					'$amountCurrency',
					'$profile',
					'$recipientId',
					'$sourceCurrency',
					'$targetCurrency')");
# foreach ($content as $x){	
# 	mysql_query("INSERT INTO batch_contents (batch_id, content, status) values ('$batch_id', '$x', 'added_by_user')");
# 	}
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
         Your id: <?php echo $userRow['id']; ?>
         Your id: <?php echo $request_id; ?>

         <a href="logout.php?logout">Sign Out</a>
     </div>
     <div id="create_request">
     	<h1>Create request</h1>
     	<form method="post">
			<table align="center" width="30%" border="0">
			<tr>
			<td><input type="text" name="X_Authorization_key" placeholder="X_Authorization_key" required /></td>
			</tr>
			<tr>
			<td><input type="text" name="X_Authorization_token" placeholder="X_Authorization_token" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="Postman_Token" placeholder="Postman_Token" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="amount" placeholder="amount" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="amountCurrency" placeholder="amountCurrency" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="profile" placeholder="profile" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="recipientId" placeholder="recipientId" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="sourceCurrency" placeholder="sourceCurrency" required/></td>
			</tr>
			<tr>
			<td><input type="text" name="targetCurrency" placeholder="targetCurrency" required/></td>
			</tr>
			<tr>
			<td><button type="submit" name="btn-request">Create payment</button></td>
			</tr>
			</table>
		</form>
     </div>
    </div>
</div>
</body>
</html>