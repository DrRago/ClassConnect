<?php
session_start();
error_reporting(0);

include "communicate.php";

if (!preg_match('/\d{4}-\d{2}-\d{2}/', $_POST["date"])) {
    $_SESSION["addEvent"] = "error";
    header('Location: ../' . $_SESSION["language"] . '/events.php');
    exit;
}

$result = getContent(
    array(
        'title' => $_POST["title"],
        'creator' => $_SESSION["username"],
        'd' => $_POST["date"],
        'start' => $_POST["eventStart"],
        'end' => $_POST["eventEnd"],
        'description' => $_POST["description"],
        'place' => $_POST["place"],
        'cid' => $_SESSION["classID"]
    ),
    "add_event"
);

switch ($result) {
    case 0:
        $_SESSION['addEvent'] = 'error';
        break;
    case 1:
        $_SESSION['addEvent'] = 'success';
        break;
}
header('Location: ../' . $_SESSION["language"] . '/events.php');