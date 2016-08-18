<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";


$result = json_decode(getContent(array('d' => date("o-m-d"), 'c' => $_SESSION["classID"]), "get_homework.php"));
?>
<html>
<head>
    <title>Homework</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/table.min.css">
    <link rel="stylesheet" href="../css/navigation.min.css">
    <link rel="stylesheet" href="../css/formula.min.css">
    <link rel="stylesheet" href="../css/style.min.css">
    <link rel="stylesheet" href="../css/homework.min.css">
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
<div class="homework_tbl">
    <table>
        <tr>
            <th class='lessonName'><strong>Subject</strong></th>
            <th class="exercise"><strong>Exercises</strong></th>
            <th class="homeworkDate"><strong>Date</strong></th>
            <?php if ($_SESSION["permissions"] != "User") { echo "<th class='ico'></th><th class='ico'></th>";}?>
        </tr>

        <?php
        if (!isset($result)) {
            echo "<tr><td colspan='3'>No Homework</td></tr>";
        } else {
            foreach ($result as $object) {
                echo "<tr id='$object->id'><td class='lessonName'>", $object->{'lessonName'}, "</td>";
                echo "<td class='exercise'>", $object->{'exercises'}, "</td>";
                echo "<td class='homeworkDate'>", $object->{'homeworkDate'}, "</td>";
                if ($_SESSION["permissions"] != "User" || $_SESSION["permissions"] != "Moderator") {
                    echo "<td><button type='submit' onclick='window.location.href=\"edit_homework.php?id=", $object->{'id'}, "\"' class='fa fa-pencil'></button></td>";
                    echo "<td><button type='submit' onclick='deleteHomework(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='fa fa-trash'></button></td>";
                }
                echo "</tr>";
            }
        } ?>
    </table>
</div>
<?php if ($_SESSION['permissions'] != 'User') { ?>
    <div class="form-inline">
        <form action="../scripts/add_homework.php" method="post">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-book"></i>
                </span>
                <input type="text" class="form-control" name="lessonName" id="lesson_in" placeholder="subject" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-tasks"></i>
                </span>
                <input type="text" class="form-control" name="exercises" id="exercises_in" placeholder="exercises" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input type="date" class="form-control" name="date" id="date_in" title="date" placeholder="yyyy-mm-dd" required>
            </div>
            <button class="btn btn-default">&nbsp;Submit <span class="fa fa-paper-plane"></span></button>
            <?php if ($_SESSION["addHomework"] == "success") {
                echo "<div class='alert alert-success'><strong>success: </strong>Homework added successfully.</div>";
                unset($_SESSION["addHomework"]);
            } elseif ($_SESSION["addHomework"] == "error") {
                echo "<div class='alert alert-danger'><strong>error: </strong>Wrong date format.</div>";
                unset($_SESSION["addHomework"]);
            } ?>
        </form>
    </div>
<?php } ?>

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src='../js/jquery-3.1.0.min.js'></script>

<script src="../js/homework.min.js"></script>
</body>
</html>