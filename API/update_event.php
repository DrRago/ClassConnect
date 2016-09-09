<?php
require "init.php";

$id = $_POST["id"];
$title = $_POST["title"];
$description = $_POST["desc"];
$eventStart = $_POST["start"];
$eventEnd = $_POST["end"];
$place = $_POST["place"];
$date = $_POST["date"];

$sql = "UPDATE tbl_Events SET title = '$title', description = '$description', eventStart = '$eventStart', eventEnd = '$eventEnd', place = '$place', eventDate = '$date' WHERE id = '$id';";

$result = mysql_query($sql);


if (!$result)
    echo "UpdateFailed";