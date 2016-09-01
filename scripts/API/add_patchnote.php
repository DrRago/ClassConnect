<?php

//Connect to DataBase
require "init.php";

//Holds post date (IS required)
$date = date("o-m-d");
//Holds content (IS required)
$content = $_POST["c"];

//SQL Query
$sql = "INSERT INTO `tbl_App`(`postDate`, `content`) VALUES ('$date', '$content');";

//Check if Query was successful
if (mysql_query($sql)) {
    print "Data Inserted";
} //Echo an error
else {
    print "Failed";
}