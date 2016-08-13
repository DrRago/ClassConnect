<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";

$result = json_decode(getContent(array('d' => date("o-m-d"), 'c' => $_SESSION["classID"]), "get_events.php"));
?>
<html>
<head>
    <title>Events</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootrstrap.css">

    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/events.css">
</head>
<body>
<?php require "navigator.php" ?>
<div class="filler">
</div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>
<div class="events_tbl">
    <table>
        <tr>
            <th class="title"><strong>Title</strong></th>
            <th class="description"><strong>Description</strong></th>
            <th class="place"><strong>Place</strong></th>
            <th class="time"><strong>Time</strong></th>
            <th class="date"><strong>Date</strong></th>
            <?php if ($_SESSION["permissions"] != "User") { echo "<th class='ico'></th><th class='ico'></th>";}?>
        </tr>

        <?php
        if (!isset($result)) {
            echo "<tr><td colspan='5'>No Events</td></tr>";
        } else {
            foreach ($result as $object) {
                echo "<tr id='$object->id'><td class='title'>", $object->{'title'}, "</td>";
                echo "<td class='description'>", $object->{'description'}, "</td>";
                echo "<td class='place'>", $object->{'place'}, "</td>";
                echo "<td class='time'>", $object->{'eventStart'}, ' - ', $object->{'eventEnd'}, "</td>";
                echo "<td class='date'>", $object->{'eventDate'}, "</td>";
                if ($_SESSION["permissions"] != "User" || $_SESSION["permissions"] != "Moderator") {
                    echo "<td><button type='submit' onclick='window.location.href=\"event.php?id=", $object->{'id'}, "\"' class='glyphicon glyphicon-pencil'></button></td>";
                    echo "<td><button type='submit' onclick='deleteEvent(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='glyphicon glyphicon-trash'></button></td>";
                }
                echo "</tr>";
            }
        } ?>
    </table>
</div>

<div class="form-inline">
    <form action="../scripts/add_event.php" method="post">

        <input type="text" class="form-control" name="title" id="lesson_in" placeholder="Title" autofocus required>
        <input type="text" class="form-control" name="description" id="exercises_in" placeholder="Description">
        <input type="text" class="form-control" name="place" id="exercises_in" placeholder="Place" required>
        <input type="text" class="form-control" name="eventStart" id="exercises_in" placeholder="Begin" required>
        <input type="text" class="form-control" name="eventEnd" id="exercises_in" placeholder="End" required>
        <input type="date" class="form-control" name="date" id="date_in" title="date" placeholder="YYYY-MM-DD" required>
        <button class="btn btn-default">&nbsp;Submit <span class="arrow">❯</span></button>
        <?php if ($_SESSION["addEvent"] == "success") {
            echo "<div class='alert-box success'><span>success: </span>Event added successfully.</div>";
            unset($_SESSION["addEvent"]);
        } elseif ($_SESSION["addEvent"] == "error") {
            echo "<div class='alert-box error'><span>error: </span>Wrong date format.</div>";
            unset($_SESSION["addEvent"]);
        } ?>
    </form>
</div>

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="../js/events.js"></script>

</body>
</html>