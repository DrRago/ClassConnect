<?php

//Connect to DataBase
require "init.php";

//Holds lesson name (IS required)
$name = $_POST["n"];
//Holds exercises (IS required)
$username = $_POST["u"];
//Holds date (IS required)
$password = md5($_POST["pass"]);
//Holds lesson name (IS required)
$email = $_POST["e"];
//Holds exercises (IS required)
$phone = $_POST["p"];
//Holds date (IS required)
$permission = $_POST["perm"];
//Holds lesson name (IS required)
$groupID = $_POST["g"];
//Holds class id (IS required)
$classID = $_POST["c"];

//SQL Query
$sql = "INSERT INTO `tbl_Users`(`name`, `username`, `password`, `email`, `phone`, `permissions`, `groupID`, `classID`) VALUES ('$name', '$username', '$password', '$email', '$phone', '$permission', '$groupID', '$classID');";

//Check if Query was successful
if (mysql_query($sql)) {
    print "Data Inserted";
} //Echo an error
else {
    print "Failed";
}