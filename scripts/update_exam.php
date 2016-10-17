<?php
session_start();
error_reporting(0);
require "check_session.php";

include "communicate.php";

$result = getContent(array(
    'id' => $_POST['id'],
    'lesson' => $_POST['lesson'],
    'topics' => $_POST['topics'],
    'd' => $_POST['date']
), "update_exam");

switch ($result) {
    case 0:
        print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
        break;
    case 1:
        $_SESSION["changedExam"] = $_POST["id"];
        header("Location: ../" . $_SESSION["language"] . "/exams.php");
}