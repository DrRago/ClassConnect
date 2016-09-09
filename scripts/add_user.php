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
        "n" => $_POST["name"],
        "u" => $_POST["username"],
        "pass" => $_POST["password"],
        "perm" => $_POST["permissions"],
        "g" => $_POST["groupID"],
        "c" => $classID
    ),
    "add_user"
);

if ($result == "Data Inserted") {
    $_SESSION["addUser"] = "success";
} elseif ($result == "Failed") {
    $_SESSION["addUser"] = "error";
}

header("Location: ../" . $_SESSION["language"] . "/users.php");