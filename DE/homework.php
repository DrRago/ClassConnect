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


    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/homework.css">
</head>

<body>
<?php require "navigator.php" ?>
<div class="filler">
</div>
<div class="homework_tbl">
    <table>
        <tr>
            <th><strong>Fach</strong></th>
            <th><strong>Aufgaben</strong></th>
            <th><strong>Datum</strong></th>
        </tr>

        <?php
        if (!isset($result)) {
            echo "<tr><td colspan='3'>Keine Hausaufgaben</td></tr>";
        } else {
            foreach ($result as $object) {
                echo "<tr><td class='lessonName'>", $object->{'lessonName'}, "</td>";
                echo "<td class='exercise'>", $object->{'exercises'}, "</td>";
                echo "<td class='homeworkDate'>", $object->{'homeworkDate'}, "</td></tr>";
            }
        } ?>
    </table>
</div>
<?php if ($_SESSION['permissions'] != 'User') { ?>
    <div class="inputs">
        <form action="../scripts/add_homework.php" method="post">
            <input type="text" name="lessonName" id="lesson_in" placeholder="Fach" required>
            <input type="text" name="exercises" id="exercises_in" placeholder="Aufgaben" required>
            <input type="date" name="date" id="date_in" title="date" placeholder="JJJJ-MM-TT" required>
            <button class="btn">&nbsp;Submit <span class="arrow">❯</span></button>
            <?php if ($_SESSION["addHomework"] == "success") {
                echo "<div class='alert-box success'><span>success: </span>Homework added successfully.</div>";
                unset($_SESSION["addHomework"]);
            } elseif ($_SESSION["addHomework"] == "error") {
                echo "<div class='alert-box error'><span>error: </span>Wrong date format.</div>";
                unset($_SESSION["addHomework"]);
            } ?>
        </form>
    </div>
<?php } ?>

</body>
</html>