<?php

//Connect to DataBase
require "init.php";

$id = $_POST['id'];

//Set SQL Query
$sql = "SELECT * FROM `tbl_Ticket` WHERE `id` = '$id';";


//Set Query
$result = mysql_query($sql);

//Check if Query was successful
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