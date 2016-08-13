<?php
session_start();
error_reporting(0);
require "checkSession.php";

include "communicate.php";

$result = getContent(array(
    'id' => $_POST['id'],
    'lesson' => $_POST['lesson'],
    'topics' => $_POST['topics'],
    'date' => $_POST['date']
), "update_exam.php");

if ($result == "Quary Failed") {
    print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
} else {
    $_SESSION["changedExam"] = $_POST["id"];
    header("Location: ../" . $_SESSION["language"] . "/exams.php");
}