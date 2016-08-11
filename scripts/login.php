<?php
session_start();
error_reporting(0);

include "communicate.php";

if ($_POST["username"] == "Felsmann" && $_POST["password"] == "Hut") {
    header('Location: ../felsmann.php');
    exit;
}

$result = getContent(
    array(
        'u' => $_POST["username"],
        'p' => $_POST["password"],
        'p_type' => "clean"
    ),
    "get_user_login.php"
);

if ($result == 'null') {
    $_SESSION['login'] = 'wrong';
    header('Location: ../index.php');
    exit();
}

$result = json_decode($result);

$_SESSION['login'] = 'successful';
$_SESSION['id'] = $result{0}->id;
$_SESSION['name'] = $result{0}->name;
$_SESSION['username'] = $result{0}->username;
$_SESSION['password'] = $result{0}->password;
$_SESSION['email'] = $result{0}->email;
$_SESSION['phone'] = $result{0}->phone;
$_SESSION['permissions'] = $result{0}->permissions;
$_SESSION['groupID'] = $result{0}->groupID;
$_SESSION['classID'] = $result{0}->classID;


header('Location: ../' . $_SESSION["language"] . '/timetable.php');