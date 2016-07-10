<?php
session_start();

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}

exec("Rscript /var/www/html/olympics/r/fetch_gt_data.R");
?>