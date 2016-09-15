<?php

$username = "classconnect";
$password = "WOLBczk413ABxbhf";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
 or die("Unable to connect to MySQL");

mysql_set_charset('utf8',$dbhandle);

//select a database to work with
$selected = mysql_select_db("ClassApplication",$dbhandle) 
  or die("Could not select database");
?>