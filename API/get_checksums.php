<?php

//Connect to DataBase
require "init.php";

//Holds the groupID (IS required)
$groupID = $_POST["g"];
//Holds the classID (IS required)
$classID = $_POST["c"];
//Holds the date (IS required)
$date = $_POST["d"];

getCheckSum("SELECT * FROM tbl_Timetable WHERE classID = '$classID' AND groupID LIKE '%$groupID%'");
getCheckSum("SELECT * FROM tbl_Homework WHERE homeworkDate >= '$date' AND classID = '$classID'");
getCheckSum("SELECT * FROM tbl_Exams WHERE examDate >= '$date' AND classID = '$classID'");
getCheckSum("SELECT * FROM tbl_Events WHERE eventDate >= '$date' AND classID = '$classID'");

function getCheckSum($sql)
{
    //Set Query
    $result = mysql_query($sql);

    //Check if Query was succesful
    if ($result) {

        //Fetch information
        while ($row = mysql_fetch_assoc($result)) {
            $output[] = $row;
        }

        //Print information as json
        echo(md5(json_encode($output)) . "\xA");
    } //Echo an error
    else {
        print "\n Quary Failed \n";
    }
}