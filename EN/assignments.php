<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";


$result = json_decode(getContent(array('d' => date("o-m-d"), 'cid' => $_SESSION["classID"]), "get_assignments"));
?>
<html>
<head>
    <title>Assignment</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">

    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="../js/responsive-nav.js"></script>

    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/assignment.css">
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
<div class="assignment_tbl">
    <table id="tbl">
        <tr>
            <th class='lessonName'><strong>Subject</strong></th>
            <th class="exercise"><strong>Exercises</strong></th>
            <th class="assignmentDate"><strong>Date</strong></th>
            <?php if ($_SESSION["permissions"] != "User") { echo "<th class='ico'></th><th class='ico'></th>";}?>
        </tr>

        <?php
        if ($result == array()) {
            echo "<tr><td colspan='5'>No Assignments</td></tr>";
        } else {
            foreach ($result as $object) {
                if ($object->id == $_SESSION["changedAssignment"]) {
                    echo "<tr id='$object->id' class='changed'>";
                    unset($_SESSION["changedAssignment"]);
                } else {
                    echo "<tr id='$object->id'>";
                }
                echo "<td class='lessonName'>", $object->{'lessonName'}, "</td>";
                echo "<td class='exercise'>", $object->{'exercises'}, "</td>";
                echo "<td class='assignmentDate'>", $object->{'date'}, "</td>";
                if ($_SESSION["permissions"] != "User") {
                    echo "<td><button type='submit' onclick='window.location.href=\"assignment.php?id=", $object->{'id'}, "\"' class='fa fa-pencil'></button></td>";
                    echo "<td><button type='submit' onclick='deleteAssignment(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='fa fa-trash'></button></td>";
                }
                echo "</tr>";
            }
        } ?>
    </table>
</div>
<?php if ($_SESSION['permissions'] != 'User') { ?>
    <div class="form-inline">
        <form action="../scripts/add_assignment.php" method="post">
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
            <?php if ($_SESSION["addAssignment"] == "success") {
                echo "<div class='alert alert-success'><strong>success: </strong>Assignment added successfully.</div>";
                unset($_SESSION["addAssignment"]);
            } elseif ($_SESSION["addAssignment"] == "error") {
                echo "<div class='alert alert-danger'><strong>error: </strong>Wrong date format.</div>";
                unset($_SESSION["addAssignment"]);
            } ?>
        </form>
    </div>
<?php } ?>

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src="../js/fastclick.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/fixed-responsive-nav.js"></script>

<script src='../js/jquery-3.1.0.js'></script>
<script src="../js/stacktable.js"></script>

<script>
    if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
        $('#tbl').stacktable();

        $(".large-only").remove();


        $(".small-only tbody tr:first-child").remove();
    }
</script>

<script src="../js/assignment.js"></script>
</body>
</html>