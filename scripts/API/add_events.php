<?php

//Connect to DataBase
require "init.php";

//Holds the title (IS required)
$title = $_POST["t"];
//Holds the creator (IS required)
$creator = $_POST["cr"];

//Holds the date (IS required)
$date = $_POST["d"];
//Holds the start time (IS required)
$event_start = $_POST["s"];
//Holds the end time (IS required)
$event_end = $_POST["e"];

//Holds the participants
$participants = 1;

//Holds the description (IS required)
$description = $_POST["desc"];
//Holds the place (IS required)
$place = $_POST["p"];

//Holds the classID (IS required)
$classID = $_POST["c"];

//SQL Query
$sql = "INSERT INTO `tbl_Events`(`title`, `creator`, `participants`, `eventStart`, `eventEnd`, `description`, `place`, `eventDate`, `classID`) VALUES ('$title', '$creator', '$participants', '$event_start', '$event_end', '$description', '$place', '$date', $classID);";

//Check if Query was succesful
if (mysql_query($sql)) {
    print "Data Inserted";
} //Echo and error
else {
    print "Failed";
}