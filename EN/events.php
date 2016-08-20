<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";
//TODO Check edit buttons for Users and Moderators
$result = json_decode(getContent(array('d' => date("o-m-d"), 'c' => $_SESSION["classID"]), "get_events.php"));
?>
<html>
<head>
    <title>Events</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/navigation.min.css">
    <link rel="stylesheet" href="../css/style.min.css">
    <link rel="stylesheet" href="../css/table.min.css">
    <link rel="stylesheet" href="../css/formula.min.css">
    <link rel="stylesheet" href="../css/events.min.css">
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
            <th class='ico'></th>
            <th class='ico'></th>
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
                echo "<td><button type='submit' onclick='window.location.href=\"event.php?id=", $object->{'id'}, "\"' class='fa fa-pencil'></button></td>";
                if ($_SESSION["username"] == $object->creator) {
                    echo "<td><button type='submit' onclick='deleteEvent(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='fa fa-trash'></button></td>";
                }
                echo "</tr>";
            }
        } ?>
    </table>
</div>

<div class="form-inline">
    <form action="../scripts/add_event.php" method="post">
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-tag"></i>
            </span>
            <input type="text" class="form-control" name="title" id="lesson_in" placeholder="Title" autofocus required>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-comment"></i>
            </span>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description">
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-map-marker"></i>
            </span>
            <input type="text" class="form-control" name="place" id="place" placeholder="Enter a location" required>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-clock-o"></i>
            </span>
            <input type="time" class="form-control" name="eventStart" id="start" placeholder="Begin" required>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-clock-o"></i>
            </span>
            <input type="time" class="form-control" name="eventEnd" id="end" placeholder="End" required>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="date" class="form-control" name="date" id="date_in" title="date" placeholder="YYYY-MM-DD" required>
        </div>
        <button class="btn btn-default">&nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
        <?php if ($_SESSION["addEvent"] == "success") {
            echo "<div class='alert alert-success'><strong>success: </strong>Event added successfully.</div>";
            unset($_SESSION["addEvent"]);
        } elseif ($_SESSION["addEvent"] == "error") {
            echo "<div class='alert alert-danger'><strong>error: </strong>Wrong date format.</div>";
            unset($_SESSION["addEvent"]);
        } ?>
    </form>
</div>

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src='../js/jquery-3.1.0.min.js'></script>

<script src="../js/events.min.js"></script>

<script>
    function initMap() {
        var map = new google.maps.Map({
            center: {lat: -33.8688, lng: 151.2195}
        });
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('place'));

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsPCAd6yPq5ayeqlXjlraM48WAl6tM5s&signed_in=true&libraries=places&callback=initMap" async defer></script>

</body>
</html>