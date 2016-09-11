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
        'lesson' => $_POST["lessonName"],
        'topics' => $_POST["topics"],
        'd' => $_POST["date"],
        'cid' => $_SESSION["classID"],
        'creator' => $_SESSION["username"]
    ),
    "add_exam"
);

switch ($result) {
    case 0:
        $_SESSION["addExam"] = "error";
        break;
    case 1:
        $_SESSION["addExam"] = "success";
        break;
}
header('Location: ../' . $_SESSION["language"] . '/exams.php');