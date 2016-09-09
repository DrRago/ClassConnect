<?php

//Connect to DataBase
require "init.php";

$id = $_POST["id"];

//Set SQL Query
$sql = "DELETE FROM `tbl_Ticket` WHERE `id` = '$id';";


//Set Query
$result = mysql_query($sql);

//Check if Query was succesful
if (!$result) {
    //Echo an error
    print "\n Quary Failed \n";
}