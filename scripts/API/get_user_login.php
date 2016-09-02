<?php

//Connect to DataBase
require "init.php";

//Holds username or id (IS required)
$user = $_POST["u"];
//Holds type of $user (NOT required)
$user_type = $_POST["u_type"];

//Holds password (IS required)
$pass = $_POST["p"];
//Holds type of $pass (IS required)
$pass_type = $_POST["p_type"];

//Holds the Query Statment
$sql = "SELECT * FROM tbl_Users WHERE ";

//Check if u_type is specified
if (!isset($user_type)) {

    //Check if $user is userID
    if (isUserID($user)) {
        //Add to SQL Query
        $sql .= "id = '$user' AND ";
    } //$user is a username
    else {
        //Add to SQL Query
        $sql .= "Username = '$user' AND ";
    }
}

//Check if p_type is encrypt
if ($pass_type == "encrypt") {
    //Add to SQL Query
    $sql .= "password = '$pass';'";
} //Check if p_type is clean
elseif ($pass_type == "clean") {
    //Add to SQL Query
    $sql .= "password = '" . md5($pass) . "';";
} //Echo an error
else {
    echo "\n p_type not set \n";
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


//FUNCTIONS

//Function to check if $user is a userID or username
function isUserID($user)
{
    //Check if $user contains numbers only
    if (ctype_digit($user)) {
        return true;
    }

    return false;
}