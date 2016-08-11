<?php
session_start();
error_reporting(0);

include "communicate.php";

if (!preg_match('/\d{4}-\d{2}-\d{2}/', $_POST["date"])) {
    $_SESSION["addHomework"] = "error";
    header('Location: ' . $_SESSION["language"] . '/homework.php');
    exit;
}

$result = getContent(
    array(
        'l' => $_POST["lessonName"],
        'e' => $_POST["exercises"],
        'd' => $_POST["date"],
        'c' => $_SESSION["classID"]
    ),
    "add_homework.php"
);

if ($result == "Data Inserted") {
    $_SESSION["addHomework"] = "success";
}

header('Location: ' . $_SESSION["language"] . '/homework.php');