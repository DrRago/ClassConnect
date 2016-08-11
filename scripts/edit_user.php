<?php
session_start();
error_reporting(1);

include "communicate.php";

$result = getContent(
    array(
        'id' => $_POST["id"],
        'username' => $_POST["username"],
        'name' => $_POST["name"],
        'phone' => $_POST["phone"],
        'permissions' => $_POST["permissions"],
        'email' => $_POST['email'],
        'group' => $_POST['groupID'],
        'class' => $_POST["classID"]
    ),
    "update_user_nopw.php"
);

$_SESSION["changedUser"] = $_POST["id"];
header("Location: ../" . $_SESSION["language"] . "/users.php");
