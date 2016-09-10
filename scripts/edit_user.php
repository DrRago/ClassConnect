<?php
session_start();
error_reporting(1);

include "communicate.php";

$result = getContent(
    array(
        'id' => $_POST["id"],
        'username' => $_POST["username"],
        'name' => $_POST["name"],
        'permissions' => $_POST["permissions"],
        'phone' => $_POST["phone"],
        'email' => $_POST['email'],
        'gid' => $_POST['groupID'],
        'cid' => $_POST["classID"]
    ),
    "update_user_general"
);

$_SESSION["changedUser"] = $_POST["id"];
header("Location: ../" . $_SESSION["language"] . "/users.php");
