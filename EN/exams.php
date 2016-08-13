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

    <link rel="stylesheet" href="../css/bootrstrap.css">

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
                    echo "<td><button type='submit' onclick='window.location.href=\"exam.php?id=", $object->{'id'}, "\"' class='glyphicon glyphicon-pencil'></button></td>";
                    echo "<td><button type='submit' onclick='deleteExam(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='glyphicon glyphicon-trash'></button></td>";
                }
                echo "</tr>";
            }
        } ?>
    </table>
</div>
<?php if ($_SESSION['permissions'] != 'User') { ?>
    <div class="inputs">
        <form action="../scripts/add_exam.php" method="post" id="formular">
            <input type="text" name="lessonName" id="lesson_in" placeholder="subject" required>
            <input type="text" name="topics" id="topics_in" placeholder="topics" required>
            <input type="date" name="date" id="date_in" placeholder="YYYY-MM-DD" required>
            <button class="btn"> &nbsp;Submit <span class="arrow">❯</span></button>
            <?php if ($_SESSION["addExam"] == "success") {
                echo "<div class='alert-box success'><span>success: </span>Exam added successfully.</div>";
                unset($_SESSION["addExam"]);
            } elseif ($_SESSION["addExam"] == "error") {
                echo "<div class='alert-box error'><span>error: </span>Wrong date format.</div>";
                unset($_SESSION["addExam"]);
            } ?>
        </form>
    </div>
<?php } ?>

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="../js/exams.js"></script>

</body>
</html>