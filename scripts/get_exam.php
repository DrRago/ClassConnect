<?php
session_start();
error_reporting(0);
require "check_session.php";

include "communicate.php";

$result = getContent(array('id' => $_POST['id']), "get_exam");

print $result;