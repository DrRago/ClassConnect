<?php

//Connect to DataBase
require "init.php";

//Holds id (IS required)
$id = $_POST["id"];

//SQL Query
$sql = "SELECT * FROM `tbl_Homework` WHERE `id` = '$id';";

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