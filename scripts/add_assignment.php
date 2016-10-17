<?php
session_start();
error_reporting(0);

include "communicate.php";

if (!preg_match('/\d{4}-\d{2}-\d{2}/', $_POST["date"])) {
    $_SESSION["addAssignment"] = "error";
    header('Location: ../' . $_SESSION["language"] . '/assignments.php');
    exit;
}

$result = getContent(
    array(
        'lesson' => $_POST["lessonName"],
        'exercise' => $_POST["exercises"],
        'd' => $_POST["date"],
        'cid' => $_SESSION["classID"],
        'creator' => $_SESSION["username"]
    ),
    "add_assignment"
);

if ($result == 1) {
    $_SESSION["addAssignment"] = "success";
}

header('Location: ../' . $_SESSION["language"] . '/assignments.php');