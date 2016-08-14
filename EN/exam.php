<?php
error_reporting(1);
session_start();
require "../scripts/check_user.php";

$result = getContent(array('id' => $_GET['id']), "get_exam.php");

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
<?php
if (!is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger container'><strong>error: </strong>The ID ", $_GET['id'], " is no number</div>";
} else {
if ($result == null || ($result{0}->classID != $_SESSION["classID"] && $_SESSION["permissions"] != "ServerAdmin")) {
    echo "<div class='alert alert-danger container'><strong>error: </strong>No exam with the ID ", $_GET['id'], " found</div>";
} else { ?>
<div class="form-inline">
    <form class="form" method="post" action="../scripts/update_exam.php">
        <table>
            <tr>
                <td><label for="id">Exam ID<a class="IsRequired">*</a>:</label></td>
                <td><input id="id" class="form-control" name="id" type="text" value="<?php echo $result{0}->id ?>" readonly required></td>
            </tr>
            <tr>
                <td><label for="lesson">Lesson<a class="IsRequired">*</a>:</label></td>
                <td><input id="lesson" class="form-control" name="lesson" type="text" value="<?php echo $result{0}->lessonName ?>" required></td>
            </tr>
            <tr>
                <td><label for="topics">Topics<a class="IsRequired">*</a>:</label></td>
                <td><input id="topics" class="form-control" name="topics" type="text" value="<?php echo $result{0}->topics ?>" required></td>
            </tr>
            <tr>
                <td><label for="date">Date<a class="IsRequired">*</a>:</label></td>
                <td><input id="date" class="form-control" name="date" type="date" value="<?php echo $result{0}->examDate ?>" style="width: 100% !important;" required></td>
            </tr>
        </table>
        <input title="validation" name="validation" value="<?php echo $_SESSION["sessionID"]?>" hidden>
        <button class="btn btn-default" type="submit">&nbsp;Submit <span class="glyphicon glyphicon-send"> </span></button>
        <?php
        }
        }
        ?>
    </form>
</div>

</body>
</html>