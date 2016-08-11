<?php
session_start();
error_reporting(0);

include "communicate.php";

if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $result = getContent(
        array(
            "reason" => $_POST["reason"],
            "content" => $_POST["message"],
            "creatorID" => $_SESSION["id"],
            "creatorName" => $_POST["name"],
            "email" => $_POST["email"]
        ),
        "add_ticket.php"
    );

    if ($result == "Data Inserted") {
        $_SESSION["mail_status"] = "success";
        unset($_SESSION["mail_msg"]);
        unset($_SESSION["mail_name"]);
        unset($_SESSION["mail_address"]);
    }
} else {
    $_SESSION["mail_status"] = "mail_invalid";
    $_SESSION["mail_msg"] = $_POST["message"];
    $_SESSION["mail_name"] = $_POST["name"];
    $_SESSION["mail_address"] = $_POST["email"];
}

header("Location: " . $_SESSION["language"] . "/helpdesk.php");