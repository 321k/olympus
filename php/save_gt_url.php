<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}

$url = $_POST["url"];
$user_id = $_SESSION['user'];
$res=mysql_query("INSERT INTO gt_urls (user_id, url) values (".$_SESSION['user'].", $url)");


if($res){
    echo "Success";
}
else{
    echo "Error";
}
?>