<?php
session_start();
error_reporting(0);

include "communicate.php";

$result = getContent(
    array(
        'u' => $_POST["username"],
        'p' => md5($_POST["password"]),
        'p_type' => "encrypted"
    ),
    "get_user_login"
);

if ($result == "[]") {
    if ($_GET["js"] == "false") {
        header('Location: ../index.php');
    } else {
        print hash_pbkdf2("sha512", "wrong", md5("secure_hashing"), 500);
    }
    exit();
}

if ($result == null) {
    if ($_GET["js"] == "false") {
        header('Location: ../index.php');
    } else {
        print hash_pbkdf2("sha512", "error", md5("secure_hashing"), 500);
    }
    exit();
}

$result = json_decode($result);

$_SESSION['id'] = $result{0}->id;
$_SESSION['name'] = $result{0}->name;
$_SESSION['username'] = $result{0}->username;
$_SESSION['email'] = $result{0}->email;
$_SESSION['phone'] = $result{0}->phone;
$_SESSION['permissions'] = $result{0}->permissions;
$_SESSION['groupID'] = $result{0}->groupID;
$_SESSION['classID'] = $result{0}->classID;

$_SESSION["sessionID"] = hash_pbkdf2("sha256", date("Y-m-d H:i:s"), mcrypt_create_iv(16, MCRYPT_DEV_URANDOM), 1000, 20);


if ($_GET["js"] == "false") {
    header('Location: ../' . $_SESSION["language"] . '/timetable.php');
} else {
    print hash_pbkdf2("sha512", "success", md5("secure_hashing"), 500);
}