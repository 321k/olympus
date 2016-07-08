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
	$content1 = mysql_real_escape_string($_POST['content1']);
	$content2 = mysql_real_escape_string($_POST['content2']);
	$content3 = mysql_real_escape_string($_POST['content3']);
 	$content = array($content1, $content2, $content3);
 	
 	mysql_query("INSERT INTO requests (user_id) values ('$userid')");
 	$request_id = mysql_query("SELECT max(id) AS request_id FROM requests WHERE requests.user_id=".$_SESSION['user']);
 	$request_id = mysql_fetch_array($request_id);
 	$request_id = $request_id['request_id'];
 foreach ($content as $x){	
 	mysql_query("INSERT INTO request_contents (request_id, content, status) values ('$request_id', '$x', 'added_by_user')");
 }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['email']; ?></title>
<link rel="stylesheet" href="../css/main.css" type="text/css" />
<link rel="stylesheet" href="../css/normalize.css" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/4.1.2/papaparse.js"></script>
<script src="../js/script.js"></script>
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
		     <div id="file-parser">
		     	<div id="file-content"></div>
		     	<h1>Upload file to create your Google Trends tracking</h1>
		        <script>
		          var data;
		         
		          function handleFileSelect(evt) {
		            var file = evt.target.files[0];
		         
		            Papa.parse(file, {
		              header: true,
		              dynamicTyping: true,
		              complete: function(results) {
		                data = results;
		              }
		            });
		          }
		         
		          $(document).ready(function(){
		            $("#csv-file").change(handleFileSelect);
		          });


		        </script>
		        <input type="file" id="csv-file" name="files"/>
		        <input type="button" id="create-gt-batch" name="files" onclick="create_gt_batch();" value = 'submit'/>
	    	</div>
    </div>
</div>
</body>
</html>