<?php
session_start();
error_reporting(1);

include "communicate.php";

if (isset($_POST["classID"])) {
    $classID = $_POST["classID"];
} else {
    $classID = $_SESSION["classID"];
}

$result = getContent(
    array(
        "name" => $_POST["name"],
        "username" => $_POST["username"],
        "p" => md5($_POST["password"]),
        "p_type" => "encrypted",
        "permissions" => $_POST["permissions"],
        "gid" => $_POST["groupID"],
        "cid" => $classID,
        "phone" => "",
        "email" => ""
    ),
    "add_user"
);

switch ($result) {
    case 0:
        $_SESSION["addUser"] = "error";
        break;
    case 1:
        $_SESSION["addUser"] = "success";
        break;
}

header("Location: ../" . $_SESSION["language"] . "/users.php");