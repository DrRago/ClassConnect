<?php
session_start();
error_reporting(0);
require "checkSession.php";

include "communicate.php";

$result = getContent(array(
    'id' => $_POST['id'],
    'title' => $_POST['title'],
    'desc' => $_POST['description'],
    'start' => $_POST['start'],
    'end' => $_POST['end'],
    'place' => $_POST['place'],
    'date' => $_POST['date']
), "update_event");

if ($result == "Quary Failed") {
    print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
} else {
    $_SESSION["changedExam"] = $_POST["id"];
    header("Location: ../" . $_SESSION["language"] . "/events.php");
}