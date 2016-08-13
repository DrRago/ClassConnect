<?php //TODO Finish
error_reporting(1);
session_start();
require "../scripts/check_user.php";

$result = getContent(array('id' => $_GET['id']), "get_event.php");

$result = json_decode($result);
?>
<html>
<head>
    <title>Exam <?php echo $_GET["id"]?></title>

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
<div class="inputs">
    <form class="form" method="post" action="../scripts/update_event.php">
        <?php
        if (!is_numeric($_GET['id'])) {
            echo "<div class='alert-box error ticketError'><span>error: </span>The ID ", $_GET['id'], " is no number</div>";
        } else {
            if ($result == null || ($result{0}->classID != $_SESSION["classID"] && $_SESSION["permissions"] != "ServerAdmin")) {
                echo "<div class='alert-box error ticketError'><span>error: </span>No event with the ID ", $_GET['id'], " found</div>";
            } else { ?>
                <div class="input"><label for="id">Event ID<a class="IsRequired">*</a>:</label><input id="id" name="id" type="text"
                                                                                                     value="<?php echo $result{0}->id ?>" readonly required><br></div>
                <div class="input"><label for="title">Title<a class="IsRequired">*</a>:</label><input id="title" name="title" type="text"
                                                                                                        value="<?php echo $result{0}->title ?>" required><br></div>
                <div class="input"><label for="description">Description<a class="IsRequired">*</a>:</label><input id="description" name="description" type="text"
                                                                                                        value="<?php echo $result{0}->description ?>" required><br></div>
                <div class="input"><label for="start">Start<a class="IsRequired">*</a>:</label><input id="start" name="start" type="time"
                                                                                                             value="<?php echo $result{0}->eventStart ?>" required><br></div>
                <div class="input"><label for="end">End<a class="IsRequired">*</a>:</label><input id="end" name="end" type="time"
                                                                                                             value="<?php echo $result{0}->eventEnd ?>" required><br></div>
                <div class="input"><label for="place">Place<a class="IsRequired">*</a>:</label><input id="place" name="place" type="text"
                                                                                                             value="<?php echo $result{0}->place ?>" required><br></div>
                <div class="input"><label for="date">Date<a class="IsRequired">*</a>:</label><input id="date" name="date" type="date"
                                                                                                    value="<?php echo $result{0}->eventDate ?>" required><br></div>
                <input title="validation" name="validation" value="<?php echo $_SESSION["sessionID"]?>" hidden>
                <button class="btn" type="submit">&nbsp;Submit <span class="arrow">❯</span></button>
                <?php
            }
        }
        ?>
    </form>
</div>

</body>
</html>