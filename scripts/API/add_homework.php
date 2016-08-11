<?php

//Connect to DataBase
require "init.php";

//Holds lesson name (IS required)
$lesson = $_POST["l"];
//Holds exercises (IS required)
$exercise = $_POST["e"];
//Holds date (IS required)
$date = $_POST["d"];
//Holds class id (IS required)
$classID = $_POST["c"];

//SQL Query
$sql = "INSERT INTO `tbl_Homework`(`lessonName`, `exercises`, `homeworkDate`, `classID`) VALUES ('$lesson', '$exercise', '$date', '$classID');";

//Check if Query was successful
if (mysql_query($sql)) {
    print "Data Inserted";
} //Echo an error
else {
    print "Failed";
}