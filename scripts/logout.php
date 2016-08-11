<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: ' . $_SESSION["language"] . '/index.php');