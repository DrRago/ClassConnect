<?php
session_start();
error_reporting(0);

include "communicate.php";

$result = getContent(array('id' => $_POST['id']), "delete_ticket");

if ($result == "Quary Failed") {
    print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
} else {
    print hash_pbkdf2("sha512", "Ticket Deleted", md5("secure_hashing"), 500);
}