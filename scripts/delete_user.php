<?php
session_start();
error_reporting(0);
require "checkSession.php";

include "communicate.php";

$result = getContent(array('id' => $_POST['id']), "delete_user");

switch ($result) {
    case 0:
        print hash_pbkdf2("sha512", "Fail", md5("secure_hashing"), 500);
        break;
    case 1:
        print hash_pbkdf2("sha512", "User Deleted", md5("secure_hashing"), 500);
        break;
}