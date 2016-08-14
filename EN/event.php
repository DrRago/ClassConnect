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

    <link rel="stylesheet" href="../css/bootrstrap.css">

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
<div class="inputs">
    <form class="form" method="post" action="../scripts/update_event.php">
        <table>
            <tr>
                <td><label for="id">Event ID<a class="IsRequired">*</a>:</label></td>
                <td><input id="id" name="id" type="text" value="<?php echo $result{0}->id ?>" readonly required></td>
            </tr>
            <tr>
                <td><label for="title">Title<a class="IsRequired">*</a>:</label></td>
                <td><input id="title" name="title" type="text" value="<?php echo $result{0}->title ?>" required></td>
            </tr>
            <tr>
                <td><label for="description">Description<a class="IsRequired">*</a>:</label></td>
                <td><input id="description" name="description" type="text" value="<?php echo $result{0}->description ?>" required></td>
            </tr>
            <tr>
                <td><label for="start">Start<a class="IsRequired">*</a>:</label></td>
                <td><input id="start" name="start" type="time" value="<?php echo $result{0}->eventStart ?>" required></td>
            </tr>
            <tr>
                <td><label for="end">End<a class="IsRequired">*</a>:</label></td>
                <td><input id="end" name="end" type="time" value="<?php echo $result{0}->eventEnd ?>" required></td>
            </tr>
            <tr>
                <td><label for="place">Place<a class="IsRequired">*</a>:</label></td>
                <td><input id="place" name="place" type="text" value="<?php echo $result{0}->place ?>" required></td>
            </tr>
            <tr>
                <td><label for="date">Date<a class="IsRequired">*</a>:</label></td>
                <td><input id="date" name="date" type="date" value="<?php echo $result{0}->eventDate ?>" style="width: 100% !important;" required></td>
            </tr>
        </table>
        <input title="validation" name="validation" value="<?php echo $_SESSION["sessionID"]?>" hidden>
        <button class="btn btn-default" type="submit">&nbsp;Submit <span class="glyphicon glyphicon-send"></span></button>
        <?php
        }
        }
        ?>
    </form>
</div>

</body>
</html>