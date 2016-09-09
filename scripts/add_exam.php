<?php
session_start();
error_reporting(0);

include "communicate.php";

if (!preg_match('/\d{4}-\d{2}-\d{2}/', $_POST["date"])) {
    $_SESSION["addExam"] = "error";
    header('Location: ../' . $_SESSION["language"] . '/exams.php');
    exit;
}

$result = getContent(
    array(
        'l' => $_POST["lessonName"],
        't' => $_POST["topics"],
        'd' => $_POST["date"],
        'c' => $_SESSION["classID"]
    ),
    "add_exams"
);

if ($result == "Data Inserted") {
    $_SESSION["addExam"] = "success";
}

header('Location: ../' . $_SESSION["language"] . '/exams.php');