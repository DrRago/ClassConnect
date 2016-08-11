<?php
session_start();
error_reporting(0);

include "communicate.php";

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["addTicket"] = "error";
    $_SESSION["ticketName"] = $_POST["name"];
    $_SESSION["ticketEmail"] = $_POST["email"];
    $_SESSION["ticketMessage"] = $_POST["message"];
    header('Location: ../helpdesk.php');
    exit;
}

$result = getContent(
    array(
        'reason' => $_POST["topic"],
        'content' => $_POST["message"],
        'creatorID' => $_SESSION["id"],
        'creatorName' => $_POST["name"],
        'email' => $_POST["email"]
    ),
    "add_ticket.php"
);

if ($result == 'Data Inserted') {
    $_SESSION['addTicket'] = 'success';
}
header('Location: ../helpdesk.php');