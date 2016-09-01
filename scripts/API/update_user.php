<?php
require "init.php";

$id = $_POST["id"];
$username = $_POST["username"];
$name = $_POST["name"];
$password_new = md5($_POST["password_new"]);
$password_old = $_POST["password_old"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$group = $_POST["group"];

$sql = "UPDATE tbl_Users SET name = '$name', password = '$password_new', email = '$email', phone = '$phone', groupID = '$group' WHERE id = '$id' AND username = '$username' AND password = '$password_old';";

$result = mysql_query($sql);


if (!$result)
    echo "UpdateFailed";