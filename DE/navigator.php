<?php
session_start();
include_once "../scripts/communicate.php";

$links = getContent(array(), "get_patchnotes.php");
$links = json_decode($links);

$items = array(
    "Stundenplan" => "timetable.php",
    "Klausuren" => "exams.php",
    "Hausaufgaben" => "homework.php",
    "Events" => "events.php",
    "Benutzer" => "users.php",
    "Hilfe" => "helpdesk.php",
    "Ausloggen" => "../scripts/logout.php",
    "App " . $links[count($links) - 1]->content => $links[count($links) - 1]->link,
    $_SESSION["name"] => "profile.php",
);

echo "<div id='navigator'><ul>";
foreach ($items as $title => $url) {
    if ($url == end(explode("/", $_SERVER["REQUEST_URI"])) & $url == "profile.php") {
        echo "<li class='right user active'><a href='" . $url . "'>" . $title . "</a></li>\n";
    } elseif ($url == end(explode("/", $_SERVER["REQUEST_URI"]))) {
        echo "<li class='active " . explode(".", end(explode("/", $_SERVER["REQUEST_URI"])))[0] . "'><a href='" . $url . "'>" . $title . "</a></li>\n";
    } elseif ($url == "../scripts/logout.php") {
        echo "<li class='logout right'><a href='" . $url . "'>" . $title . "</a></li>\n";
    } elseif ($url == "profile.php") {
        echo "<li class='right'><a href='" . $url . "'>" . $title . "</a></li>";
    } elseif ($title[0] == "A") {
        echo "<li class='right'><a href='" . $url . "'>" . $title . "</a></li>";
    } else {
        echo "<li><a href='" . $url . "'>" . $title . "</a></li>\n";
    }
}
echo "</ul>\n</div>\n";