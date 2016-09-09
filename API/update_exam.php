<?php
require "init.php";

$id = $_POST["id"];
$lessonName = $_POST["lesson"];
$topics = $_POST["topics"];
$examDate = $_POST["date"];

$sql = "UPDATE tbl_Exams SET lessonName = '$lessonName', topics = '$topics', examDate = '$examDate' WHERE id = '$id';";

$result = mysql_query($sql);


if (!$result)
    echo "UpdateFailed";