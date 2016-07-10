<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}


$year = $_POST["year"];
$month = $_POST["month"];
$length = $_POST["length"];
$country  = $_POST["country"];
$region = $_POST["region"];
$refresh_frequency  = $_POST["refresh_frequency"];
$data_frequency = $_POST["data_frequency"];
$comparable_keywords = $_POST["comparable_keywords"];
$user_id = $_SESSION['user'];

$query = sprintf("INSERT INTO orders (user_id, year, month, length, country, region, refresh_frequency, data_frequency, comparable_keywords) values ($user_id,$year,$month,$length,'$country','$region','$refresh_frequency','$data_frequency','$comparable_keywords');");
echo $query;

$res=mysql_query($query);

echo $res;
if($res){
    echo $res;
}
else{
    echo "Error";
}
?>