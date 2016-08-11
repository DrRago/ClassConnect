<?php

//Connect to DataBase
require "init.php";

//Holds post reason (IS required)
$reason = $_POST["reason"];
//Holds post content (IS required)
$content = $_POST["content"];
//Holds post creators ID (IS required)
$creatorID = $_POST["creatorID"];
//Holds post creators Name (IS required)
$creatorName = $_POST["creatorName"];
//Holds email of creator (IS required)
$creatorEmail = $_POST["email"];

//SQL Query
$sql = "INSERT INTO `tbl_Ticket`(`reason`, `content`, `creatorID`, `creatorName`, `creatorEmail`) VALUES ('$reason', '$content', '$creatorID', '$creatorName', '$creatorEmail');";

//Check if Query was successful
if (mysql_query($sql)) {
    print "Data Inserted";
} //Echo an error
else {
    print "Failed";
}