<?php


//Connect to DataBase
require "init.php";

//Holds the date (IS required)
$date = $_POST["d"];
//Holds classID (IS required)
$classID = $_POST["c"];

//Set SQL Query
$sql = "SELECT * FROM `tbl_Homework` WHERE `classID` = '$classID' AND homeworkDate >= '$date' ORDER BY `tbl_Homework`.`homeworkDate` ASC;";

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