<?php

//Connect to DataBase
require "init.php";

//Set SQL Query
$sql = "SELECT * FROM `tbl_Ticket` WHERE 1;";


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