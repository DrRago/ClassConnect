<?php
session_start();
error_reporting(1);
require "scripts/check_user.php";

$result = json_decode(getContent(array('d' => date("o-m-d"), 'c' => $_SESSION["classID"]), "get_events.php"));
?>
<html>
<head>
    <title>Events</title>

    <link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico'>

    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/formula.css">
    <link rel="stylesheet" href="css/events.css">
</head>
<body>
<?php require "navigator.php" ?>
<div class="filler">
</div>
<div class="events_tbl">
    <table>
        <tr>
            <th><strong>Title</strong></th>
            <th><strong>Description</strong></th>
            <th><strong>Place</strong></th>
            <th><strong>Time</strong></th>
            <th><strong>Date</strong></th>
        </tr>

        <?php
        if (!isset($result)) {
            echo "<tr><td colspan='5'>No Events</td></tr>";
        } else {
            foreach ($result as $object) {
                echo "<tr><td class='title'>", $object->{'title'}, "</td>";
                echo "<td class='description'>", $object->{'description'}, "</td>";
                echo "<td class='place'>", $object->{'place'}, "</td>";
                echo "<td class='time'>", $object->{'eventStart'}, ' - ', $object->{'eventEnd'}, "</td>";
                echo "<td class='date'>", $object->{'eventDate'}, "</td></tr>";
            }
        } ?>
    </table>
</div>

<div class="inputs">
    <form action="scripts/add_event.php" method="post">

        <input type="text" name="title" id="lesson_in" placeholder="Title" autofocus required>
        <input type="text" name="description" id="exercises_in" placeholder="Description">
        <input type="text" name="place" id="exercises_in" placeholder="Place" required>
        <input type="text" name="eventStart" id="exercises_in" placeholder="Begin" required>
        <input type="text" name="eventEnd" id="exercises_in" placeholder="End" required>
        <input type="date" name="date" id="date_in" title="date" placeholder="JJJJ-MM-DD" required>
        <button class="btn">&nbsp;Submit <span class="arrow">❯</span></button>
        <?php if ($_SESSION["addEvent"] == "success") {
            echo "<div class='alert-box success'><span>success: </span>Event added successfully.</div>";
            unset($_SESSION["addEvent"]);
        } elseif ($_SESSION["addEvent"] == "error") {
            echo "<div class='alert-box error'><span>error: </span>Wrong date format.</div>";
            unset($_SESSION["addEvent"]);
        } ?>
    </form>
</div>
</body>
</html>