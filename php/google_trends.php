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
	<script src="../js/create_gt_url.js"></script>
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
		        <input type="button" id="create-gt-batch" name="files" onclick="create_links(data);" value = 'submit'/>
		        <input type="button" id="get-gt-data" name="files" value="update data"/>
	    	</div>
	    	<div id="ajax-return">
	    	</div>
	    	<div>
	    		<form action="">
		    		<h1>Define parameters</h1>
		    		Start year<input type="" id="year" value="2004"/><br>
		    		Start Month<input type="" id ="month" value="1"/><br>
		    		Length<input type="" id="length" value="0"/><br>
		    		Country <input type="" id="country" value="World"/><br>
		    		Region <input type="" id="region" value="World"/><br>
		    		<input type="checkbox" id="comparable_keywords"/> Make my data comparable <br>
		    		Refresh frequency<br>
		    		<input type="radio" id="refresh_frequency" name="refresh_frequency" value="Daily"/> Daily <br>
		    		<input type="radio" id="refresh_frequency" name="refresh_frequency" value="Weekly"/> Weekly<br>
		    		<input type="radio" id="refresh_frequency" name="refresh_frequency" value="Monthly"/> Monthly<br>
		    		Data frequency<br>
		    	
		    		<input type="radio" id="data_frequency" name="data_frequency"  value="Daily"/> Daily <br>
		    		<input type="radio" id="data_frequency" name="data_frequency"  value="Weekly"/> Weekly<br>
		    		<input type="radio" id="data_frequency" name="data_frequency" value="Monthly"/> Monthly<br>
		    		<input type="button" id="create-gt-batch-v2" id="files-v2" onclick="create_order();" value = 'submit'/>
	    		</form>
	    	</div>
    	</div>
	</div>
</body>
</html>