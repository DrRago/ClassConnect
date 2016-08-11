<?php
error_reporting(1);
session_start();

include "communicate.php";

$id = $_SESSION['resetPassword'];

$result = getContent(
    array(
        'uid' => $id
    ),
    "reset_password.php"
);
if ($result == null) {
    $_SESSION["resetStatus"] = "error";
} else {
    $_SESSION["resetStatus"] = "success";
    $_SESSION["newPassword"] = $result;
}

unset($_SESSION['resetPassword']);

header("Location: ../" . $_SESSION["language"] . "/edit.php?id=" . $id);