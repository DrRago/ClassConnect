<?php
require "init.php";

//SQL
$sql = "SELECT * FROM tbl_Users WHERE 1";

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
}