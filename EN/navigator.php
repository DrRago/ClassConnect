<?php
include_once "../scripts/communicate.php";

$links = getContent(array(), "get_app");
$links = json_decode($links);

$items = array(
    "Timetable" => "timetable.php",
    "Exams" => "exams.php",
    "Homework" => "homework.php",
    "Events" => "events.php",
    "Users" => "users.php",
    "Helpdesk" => "helpdesk.php",
    "Logout" => "../scripts/logout.php",
    "App " . $links[count($links) - 1]->content => $links[count($links) - 1]->link,
    $_SESSION["name"] => "profile.php",
);
echo "<header><a href='timetable.php' class='logo'>ClassConnect</a>";
echo "<nav id='nav-main' class='nav-collapse'><ul>";
foreach ($items as $title => $url) {
    if ($url == end(explode("/", $_SERVER["REQUEST_URI"])) & $url == "profile.php") {
        echo "<li class='menu-item right active'><a href='" . $url . "'>" . $title . "</a></li>\n";
        echo "<li class='menu-item mobile active'><a href='" . $url . "'>" . $title . "</a></li>";
    } elseif ($url == end(explode("/", $_SERVER["REQUEST_URI"]))) {
        echo "<li class='active " . explode(".", end(explode("/", $_SERVER["REQUEST_URI"])))[0] . "'><a href='" . $url . "'>" . $title . "</a></li>\n";
    } elseif ($title == "Logout") {
        echo "<li class='menu-item right'><a class='logout' href='" . $url . "'>" . $title . "</a></li>\n";
    } elseif ($url == "profile.php") {
        echo "<li class='menu-item right'><a href='" . $url . "'>" . $title . "</a></li>";
    } elseif ($title[0] == "A") {
        echo "<li class='menu-item right'><a href='" . $url . "'>" . $title . "</a></li>";
    } else {
        echo "<li class='menu-item'><a href='" . $url . "'>" . $title . "</a></li>\n";
    }
}
if (end(explode("/", $_SERVER["REQUEST_URI"])) != "profile.php") {
    echo "<li class='menu-item mobile'><a href='profile.php'>Leonhard Gahr</a></li>";
}
echo "<li class='menu-item mobile'><a href='", $links[count($links) - 1]->link, "'>App</a></li>";
echo "<li class='menu-item mobile'><a href='../scripts/logout.php' class='logout'>Logout</a></li>";
echo "</ul>\n</nav>\n</header>\n";
