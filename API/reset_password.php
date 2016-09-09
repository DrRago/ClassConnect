<?php
require "init.php";

//Holds user id
$user = $_POST["uid"];
//Creates random password
$password_new = substr(md5(rand()), 0, 7);

//SQL
$sql = "UPDATE tbl_Users SET password = '$password_new' WHERE id = '$user';";

//Set Query
$result = mysql_query($sql);

//Check if Query was successful
if ($result) {
    //print password
    print($password_new);
}