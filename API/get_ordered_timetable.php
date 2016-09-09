<?php

//Connect to DataBase
require "init.php";

//Holds week (IS required)
$week = $_POST["week"];
//Holds classID (IS required)
$classID = $_POST["cid"];
//Holds groupID (IS required)
$groupID = $_POST["g"];

//SQL Query
$sql = "SELECT * FROM `tbl_Timetable` WHERE `week` = '$week' AND `classID` = '$classID' AND groupID LIKE '%$groupID%' ORDER BY `lessonStart` ASC;";

//Set Query
$result = mysql_query($sql);

//Check if Query was succesful
if ($result) {

    //Fetch information
    while ($row = mysql_fetch_assoc($result)) {
        $output[] = $row;
    }

    //Print information as json
    print(json_encode($output));
} //Echo an error
else {
    print "\n Quary Failed \n";
}