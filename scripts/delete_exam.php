<?php
session_start();
error_reporting(0);
require "checkSession.php";

include "communicate.php";

$result = getContent(array('id' => $_POST['id']), "delete_exam.php");

if ($result == "Quary Failed") {
    print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
} else {
    print hash_pbkdf2("sha512", "Exam Deleted", md5("secure_hashing"), 500);
}