<?php
session_start();

if(!isset($_SESSION['user']))
{
 header("Location: index.php");
}

exec("Rscript /var/www/html/olympus/r/fetch_gt_data.R");

$res=mysql_query("select * from gt_urls join search_volume on search_volume.gt_urls_id = gt_urls.id where gt_urls.user_id =".$_SESSION['user']);
echo $res
?>