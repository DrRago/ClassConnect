<?php
require "init.php";

$id = $_POST["id"];
$username = $_POST["username"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$permissions = $_POST["permissions"];
$email = $_POST["email"];
$group = $_POST["group"];
$class = $_POST["class"];

$sql = "UPDATE tbl_Users SET name = '$name', email = '$email', phone = '$phone', permissions = '$permissions', groupID = '$group', classID = '$class' WHERE id = '$id' AND username = '$username';";

$result = mysql_query($sql);


if (!$result)
    echo "UpdateFailed";