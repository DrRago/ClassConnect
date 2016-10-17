<?php
session_start();
error_reporting(0);

include "communicate.php";

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["addTicket"] = "error";
    $_SESSION["ticketName"] = $_POST["name"];
    $_SESSION["ticketEmail"] = $_POST["email"];
    $_SESSION["ticketMessage"] = $_POST["message"];
    header('Location: ../' . $_SESSION["language"] . '/support.php');
    exit;
}

$result = getContent(
    array(
        'reason' => $_POST["topic"],
        'content' => $_POST["message"],
        'creator_id' => $_SESSION["id"],
        'creator_name' => $_POST["name"],
        'creator_email' => $_POST["email"]
    ),
    "add_ticket"
);

if ($result == 1) {
    $_SESSION['addTicket'] = 'success';
}
header('Location: ../' . $_SESSION["language"] . '/support.php');