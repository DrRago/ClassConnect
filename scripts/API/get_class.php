<?php
require "init.php";

//Holds username or id (IS required)
$class = $_POST["cid"];

//SQL
$sql = "SELECT * FROM tbl_Users WHERE classID = '$class';";

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