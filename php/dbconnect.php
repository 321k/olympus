<?php

$conn = mysql_connect("localhost","erik","johansson");
if(!mysql_connect("localhost","erik","johansson"))
{
     die('oops connection problem ! --> '.mysql_error());
}

if(!mysql_select_db("apollo"))
{
     die('oops database selection problem ! --> '.mysql_error());
}
?>



