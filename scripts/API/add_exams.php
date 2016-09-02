<?php

//Connect to DataBase
require "init.php";

//Holds lesson name (IS required)
$lesson = $_POST["l"];
//Holds date (IS required)
$date = $_POST["d"];
//Holds topics (IS required)
$topics = $_POST["t"];
//Holds class id (IS required)
$classID = $_POST["c"];

//SQL Query
$sql = "INSERT INTO `tbl_Exams`(`lessonName`, `topics`, `examDate`, `classID`) VALUES ('$lesson', '$topics', '$date', '$classID');";

//Check if Query successful
if (mysql_query($sql)) {
    print "Data Inserted";
} //Echo an error
else {
    print "Failed";
}