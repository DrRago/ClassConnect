<?php
error_reporting(1);
session_start();

include "communicate.php";

$id = $_SESSION['resetPassword'];

$password = substr(md5(rand()), 0, 7);

$result = getContent(
    array(
        'id' => $id,
        'p' => md5($password),
        'p_type' => "encrypted"
    ),
    "reset_password"
);

switch ($result) {
    case 0:
        $_SESSION["resetStatus"] = "error";
        break;
    case 1:
        $_SESSION["resetStatus"] = "success";
        $_SESSION["newPassword"] = $password;
        break;
}
unset($_SESSION['resetPassword']);

header("Location: ../" . $_SESSION["language"] . "/edit.php?id=" . $id);