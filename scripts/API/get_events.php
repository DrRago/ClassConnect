<?php

//Connect to DataBase
require "init.php";

//Holds date (IS required)
$date = $_POST["d"];
//Holds classID (IS required)
$classID = $_POST["c"];

//SQL Query
$sql = "SELECT * FROM `tbl_Events` WHERE `classID` = '$classID' AND eventDate >= '$date' ORDER BY `tbl_Events`.`eventDate` ASC;";

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