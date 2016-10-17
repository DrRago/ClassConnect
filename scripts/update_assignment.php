<?php
session_start();
error_reporting(0);
require "check_session.php";

include "communicate.php";

$result = getContent(array(
    'id' => $_POST['id'],
    'lesson' => $_POST['lesson'],
    'exercise' => $_POST['exercises'],
    'd' => $_POST['date']
), "update_assignment");

switch ($result) {
    case 0:
        print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
        break;
    case 1:
        $_SESSION["changedAssignment"] = $_POST["id"];
        header("Location: ../" . $_SESSION["language"] . "/assignments.php");
        break;
}