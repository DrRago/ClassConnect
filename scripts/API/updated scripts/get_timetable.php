<?php

//Connect to DataBase
require "init.php";

//Holds day (IS required)
$day = $_POST["d"];
//Holds week (IS required)
$week = $_POST["w"];
//Holds groupID (IS required)
$groupID = $_POST["g"];
//Holds classID (IS required)
$classID = $_POST["c"];
//Hold if complete timetable should be pulled
$all = $_POST["a"];

if (isset($all)) {
//Set SQL Query
    $sql = "SELECT * FROM `tbl_Timetable` WHERE `classID` = '$all';";
} else {
//Set SQL Query
    $sql = "SELECT * FROM `tbl_Timetable` WHERE `day` = '$day' AND `week` = '$week' AND `classID` = '$classID' AND groupID LIKE '%$groupID%';";
}


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
