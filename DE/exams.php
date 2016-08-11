<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";

$result = json_decode(getContent(array('d' => date("o-m-d"), 'c' => $_SESSION["classID"]), "get_exams.php"));
?>
<html>
<head>
    <title>Klausuren</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

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
<div class="examList">
    <table>
        <tr>
            <th><strong>Fach</strong></th>
            <th><strong>Themen</strong></th>
            <th><strong>Datum</strong></th>
        </tr>

        <?php
        if (!isset($result)) {
            echo "<tr><td colspan='3'>Keine Klausuren</td></tr>";
        } else {
            foreach ($result as $object) {

                echo "<tr><td class='lessonName'>", $object->{'lessonName'}, "</td>";
                echo "<td class='topics'>", $object->{'topics'}, "</td>";
                echo "<td class='examDate'>", $object->{'examDate'}, "</td></tr>";
            }
        } ?>
    </table>
</div>
<?php if ($_SESSION['permissions'] != 'User') { ?>
    <div class="inputs">
        <form action="../scripts/add_exam.php" method="post" id="formular">
            <input type="text" name="lessonName" id="lesson_in" placeholder="Fach" required>
            <input type="text" name="topics" id="topics_in" placeholder="Themen" required>
            <input type="date" name="date" id="date_in" placeholder="JJJJ-MM-TT" required>
            <button class="btn"> &nbsp;Submit <span class="arrow">❯</span></button>
            <?php if ($_SESSION["addExam"] == "success") {
                echo "<div class='alert-box success'><span>erfolg: </span>Klausur erfolgreich hinzugefügt.</div>";
                unset($_SESSION["addExam"]);
            } elseif ($_SESSION["addExam"] == "error") {
                echo "<div class='alert-box error'><span>fehler: </span>Falsches Datumsformat (JJJJ-MM-TT).</div>";
                unset($_SESSION["addExam"]);
            } ?>
        </form>
    </div>
<?php } ?>

</body>
</html>