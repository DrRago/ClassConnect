<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";

$result = json_decode(getContent(array('d' => date("o-m-d"), 'c' => $_SESSION["classID"]), "get_exams.php"));
?>
<html>
<head>
    <title>Exams</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/exams.css">

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
<div class="examList">
    <table>
        <tr>
            <th class='lessonName'><strong>Subject</strong></th>
            <th class="topics"><strong>Topics</strong></th>
            <th><strong>Date</strong></th>
            <?php if ($_SESSION["permissions"] != "User") { echo "<th class='ico'></th><th class='ico'></th>";}?>
        </tr>

        <?php
        if (!isset($result)) {
            echo "<tr><td colspan='3'>No Exams</td></tr>";
        } else {
            foreach ($result as $object) {

                if ($_SESSION["changedExam"] == $object->id) {
                    unset($_SESSION["changedExam"]);
                    echo "<tr id='$object->id' class='changed'>";
                } else {
                    echo "<tr id='$object->id'>";
                }
                echo "<td class='lessonName'>", $object->{'lessonName'}, "</td>";
                echo "<td class='topics'>", $object->{'topics'}, "</td>";
                echo "<td class='examDate'>", $object->{'examDate'}, "</td>";
                if ($_SESSION["permissions"] != "User" || $_SESSION["permissions"] != "Moderator") {
                    echo "<td><button type='submit' onclick='window.location.href=\"exam.php?id=", $object->{'id'}, "\"' class='fa fa-pencil'></button></td>";
                    echo "<td><button type='submit' onclick='deleteExam(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='fa fa-trash'></button></td>";
                }
                echo "</tr>";
            }
        } ?>
    </table>
</div>
<?php if ($_SESSION['permissions'] != 'User') { ?>
    <div class="form-inline">
        <form action="../scripts/add_exam.php" method="post" id="formular">
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
                <input type="text" class="form-control" name="topics" id="topics_in" placeholder="topics" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input type="date" class="form-control" name="date" id="date_in" placeholder="YYYY-MM-DD" required>
            </div>
            <button class="btn btn-default"> &nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
            <?php if ($_SESSION["addExam"] == "success") {
                echo "<div class='alert alert-success'><strong>success: </strong>Exam added successfully.</div>";
                unset($_SESSION["addExam"]);
            } elseif ($_SESSION["addExam"] == "error") {
                echo "<div class='alert alert-danger'><strong>error: </str>Wrong date format.</div>";
                unset($_SESSION["addExam"]);
            } ?>
        </form>
    </div>
<?php } ?>

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src='../js/jquery-3.1.0.min.js'></script>

<script src="../js/exams.js"></script>

</body>
</html>