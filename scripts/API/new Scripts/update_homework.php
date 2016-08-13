<?php
require "init.php";

$id = $_POST["id"];
$lessonName = $_POST["lesson"];
$exercises = $_POST["exercises"];
$homeworkDate = $_POST["date"];

$sql = "UPDATE tbl_Homework SET lessonName = '$lessonName', exercises = '$exercises', homeworkDate = '$homeworkDate' WHERE id = '$id';";

$result = mysql_query($sql);


if (!$result)
    echo "UpdateFailed";