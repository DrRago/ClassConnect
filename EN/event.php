<?php
error_reporting(1);
session_start();
require "../scripts/check_user.php";

$result = getContent(array('id' => $_GET['id']), "get_event.php");

$result = json_decode($result);
?>
<html>
<head>
    <title>Event <?php echo $_GET["id"]?></title>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">

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
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>
<?php
if (!is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger container'><strong>error: </strong>The ID ", $_GET['id'], " is no number</div>";
} else {
if ($result == null || ($result{0}->classID != $_SESSION["classID"] && $_SESSION["permissions"] != "ServerAdmin")) {
    echo "<div class='alert alert-danger container'><strong>error: </strong>No event with the ID ", $_GET['id'], " found</div>";
} else { ?>
<div class="form-inline">
    <form class="form" method="post" action="../scripts/update_event.php">
        <table>
            <tr>
                <td><label for="id">Event ID<a class="IsRequired">*</a>:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ol"></i>
                        </span>
                        <input id="id" class="form-control" name="id" type="text" value="<?php echo $result{0}->id ?>" readonly required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="title">Title<a class="IsRequired">*</a>:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-tag"></i>
                        </span>
                        <input id="title" class="form-control" name="title" type="text" value="<?php echo $result{0}->title ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="description">Description<a class="IsRequired">*</a>:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-comment"></i>
                        </span>
                        <input id="description" class="form-control" name="description" type="text" value="<?php echo $result{0}->description ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="start">Start<a class="IsRequired">*</a>:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </span>
                        <input id="start" class="form-control" name="start" type="time" value="<?php echo $result{0}->eventStart ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="end">End<a class="IsRequired">*</a>:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </span>
                        <input id="end" class="form-control" name="end" type="time" value="<?php echo $result{0}->eventEnd ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="place">Place<a class="IsRequired">*</a>:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </span>
                        <input id="place" class="form-control" name="place" type="text" value="<?php echo $result{0}->place ?>" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label for="date">Date<a class="IsRequired">*</a>:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input id="date" class="form-control" name="date" type="date" value="<?php echo $result{0}->eventDate ?>" required>
                    </div>
                </td>
            </tr>
        </table>
        <input title="validation" name="validation" value="<?php echo $_SESSION["sessionID"]?>" hidden>
        <button class="btn btn-default" type="submit">&nbsp;Submit <span class="fa fa-paper-plane"></span></button>
        <?php
        }
        }
        ?>
    </form>
</div>

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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATsPCAd6yPq5ayeqlXjlraM48WAl6tM5s&signed_in=true&libraries=places&callback=initMap"
        async defer></script>

</body>
</html>