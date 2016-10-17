<?php
session_start();
error_reporting(0);
require "check_session.php";

include "communicate.php";

$result = getContent(array(
    'id' => $_POST['id'],
    'title' => $_POST['title'],
    'description' => $_POST['description'],
    'start' => $_POST['start'],
    'end' => $_POST['end'],
    'place' => $_POST['place'],
    'd' => $_POST['date']
), "update_event");

switch ($result) {
    case 0:
        print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
        break;
    case 1:
        $_SESSION["changedEvent"] = $_POST["id"];
        header("Location: ../" . $_SESSION["language"] . "/events.php");
        break;
}