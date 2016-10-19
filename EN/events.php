<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";
$result = json_decode(getContent(array('d' => date("o-m-d"), 'cid' => $_SESSION["classID"]), "get_events"));
?>
<html>
<head>
    <title>Events</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">

    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="../js/responsive-nav.js"></script>

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
<div id="tbl" class="events_tbl">
    <table>
        <tr>
            <th class=""><strong>Title</strong></th>
            <th class=""><strong>Description</strong></th>
            <th class=""><strong>Place</strong></th>
            <th class=""><strong>Time</strong></th>
            <th class=""><strong>Date</strong></th>
            <th class='ico'></th>
            <th class='ico'></th>
            <th class='ico'></th>
        </tr>

        <?php
        if ($result == array()) {
            echo "<tr><td colspan='8'>No Events</td></tr>";
        } else {
            foreach ($result as $object) {
                if ($object->id == $_SESSION["changedEvent"]) {
                    echo "<tr id='$object->id' class='changed'>";
                    unset($_SESSION["changedEvent"]);
                } else {
                    echo "<tr id='$object->id'>";
                }
                echo "<td class='title'>", $object->{'title'}, "</td>";
                echo "<td class='description'>", $object->{'description'}, "</td>";
                echo "<td class='place'>", $object->{'place'}, "</td>";
                echo "<td class='time'>", $object->{'eventStart'}, ' - ', $object->{'eventEnd'}, "</td>";
                echo "<td class='date'>", $object->{'date'}, "</td>";
                echo "<td><button type='submit' onclick='window.open(\"https://maps.google.com/maps/place/", $object->place, "\", \"_blank\");' class='fa fa-map'></button></td>";
                echo "<td class='table_edit'><noscript><a class='nolink' href='event.php?id=$object->id'></noscript><button type='submit' onclick='editEvent(this, \"$_SESSION[sessionID]\")' class='fa fa-pencil'></button><noscript></a></noscript></td>";
                if ($_SESSION["username"] == $object->creator || $_SESSION["permissions"] == "ServerAdmin") {
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
            <input type="text" class="form-control" name="title" id="lesson_in" placeholder="Title" required>
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

<!-- edit begin -->
<form class="edit_form" method="post" action="../scripts/update_event.php" hidden>
    <i id="status" class="fa fa-refresh fa-spin fa-3x fa-fw"></i>

    <div class="input-div" style="display: none">
        <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-list-ol"></i>
                </span>
            <input id="id" class="form-control" name="id" placeholder="id" type="text" readonly required>
        </div>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-tag"></i>
            </span>
            <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
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
            <input type="text" class="form-control" name="place" id="place_in" placeholder="Enter a location" required>
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
        <input title="validation" name="validation" id="session" value="<?php echo $_SESSION["sessionID"] ?>"
               style="display: none" hidden>
        <button class="btn btn-default"> &nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
    </div>
</form>
<!-- edit end -->

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src="../js/fastclick.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/fixed-responsive-nav.js"></script>

<script src='../js/jquery-3.1.0.js'></script>

<script src="../js/events.js"></script>

<script src="../js/edit.js"></script>

<script src="../js/stacktable.js"></script>

<script>
    if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('#tbl').stacktable();
        
        $(".large-only").remove();

        $(".small-only tbody tr:first-child").remove();

        $(".examList").find(".table_edit noscript").contents().unwrap();
        $(".examList .table_edit").each(function(){
            var $this = $(this);
            var t = $this.html();
            console.log(t);
            $this.html(t.replace(new RegExp('&amp;lt;','g'), "<").replace(new RegExp('&amp;gt;', 'g'), '>'));
        });
        $(".examList .table_edit .nolink button").removeAttr("onclick");
    }
</script>

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