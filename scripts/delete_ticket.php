<?php
session_start();
error_reporting(0);

include "communicate.php";

$result = getContent(array('id' => $_POST['id']), "delete_ticket.php");

$_SESSION["deleteTicket"] = $_POST['id'];

header("Location: ../" . $_SESSION["language"] . "/helpdesk.php");