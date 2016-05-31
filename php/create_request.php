<?php
session_start();
if(isset($_SESSION['user'])!="")
{
 header("Location: home.php");
}
include_once 'dbconnect.php';

if(isset($_POST['btn-signup']))
{
 $userid = $row['id'];
 
 if(mysql_query("INSERT INTO requests(user_id) VALUES('$userid')"))
 {
  ?>
        <script>alert('successfully registered ');</script>
        <?php
 }
 else
 {
  ?>
        <script>alert('error while registering you...');</script>
        <?php
 }
}
?>