<?php
session_start();
error_reporting(0);

include "communicate.php";

if (!preg_match('/\d{4}-\d{2}-\d{2}/', $_POST["date"])) {
    $_SESSION["addEvent"] = "error";
    header('Location: ' . $_SESSION["language"] . '/events.php');
    exit;
}

$result = getContent(
    array(
        't' => $_POST["title"],
        'cr' => $_SESSION["username"],
        'd' => $_POST["date"],
        's' => $_POST["eventStart"],
        'e' => $_POST["eventEnd"],
        'desc' => $_POST["description"],
        'p' => $_POST["place"],
        'c' => $_SESSION["classID"]
    ),
    "add_events.php"
);

if ($result == 'Data Inserted') {
    $_SESSION['addEvent'] = 'success';
}

header('Location: ' . $_SESSION["language"] . '/events.php');