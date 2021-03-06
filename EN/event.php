<?php
error_reporting(1);
session_start();
require "../scripts/check_user.php";
$result = json_decode(getContent(array('id' => $_GET['id']), "get_event")); ?>
<html>
<head>
    <title>Event <?= $_GET["id"] ?></title>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">

    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="../js/responsive-nav.js"></script>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/input_container.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php require "navigator.php"; ?>
<div class="filler">
</div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link"
                                                                                                  href="http://www.enable-javascript.com/"
                                                                                                  target="_blank">
            instructions how to enable JavaScript in your web browser</a>.
    </div>
</noscript>
<?php
if (!is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger container'><strong>error: </strong>The ID $_GET[id] is no number</div>";
} else {
if ($result == null || ($result{0}->classID != $_SESSION["classID"] && $_SESSION["permissions"] != "ServerAdmin")) {
    echo "<div class='alert alert-danger container'><strong>error: </strong>No event with the ID $_GET[id] found</div>";
} else { ?>
<div class="form-inline">
    <form class="form" method="post" action="../scripts/update_event.php">
        <table>
            <tr>
                <td><label for="id">Event ID<a class="IsRequired">*</a>:</label></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ol"></i>
                        </span>
                        <input id="id" class="form-control" name="id" type="text" value="<?= $result{0}->id ?>"
                               readonly required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="title">Title<a class="IsRequired">*</a>:</label></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-tag"></i>
                        </span>
                        <input id="title" class="form-control" name="title" type="text"
                               value="<?= $result{0}->title ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="description">Description<a class="IsRequired">*</a>:</label></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-comment"></i>
                        </span>
                        <input id="description" class="form-control" name="description" type="text"
                               value="<?= $result{0}->description ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="start">Start<a class="IsRequired">*</a>:</label></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </span>
                        <input id="start" class="form-control" name="start" type="time"
                               value="<?= $result{0}->eventStart ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="end">End<a class="IsRequired">*</a>:</label></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </span>
                        <input id="end" class="form-control" name="end" type="time"
                               value="<?= $result{0}->eventEnd ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="place">Place<a class="IsRequired">*</a>:</label></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </span>
                        <input id="place" class="form-control" name="place" type="text"
                               value="<?= $result{0}->place ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="date">Date<a class="IsRequired">*</a>:</label></td>
                <td>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input id="date" pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" class="form-control" name="date" type="date"
                               value="<?= $result{0}->date ?>" required>
                    </div>
                </td>
            </tr>
        </table>
        <input title="validation" name="validation" value="<?= $_SESSION["sessionID"] ?>" hidden>
        <button class="btn btn-default" type="submit">&nbsp;Submit <span class="fa fa-paper-plane"></span></button>
        <?php
        }
        }
        ?>
    </form>
</div>

<script src="../js/fastclick.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/fixed-responsive-nav.js"></script>

<script>
    function initMap() {
        var map = new google.maps.Map({
            center: {lat: -33.8688, lng: 151.2195}
        });
        var input = /** @type {!HTMLInputElement} */(
            document.getElementById('place'));

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function () {
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