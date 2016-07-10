<?php
session_start();

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}

exec("Rscript /var/www/html/olympus/r/fetch_gt_data.R");

?>