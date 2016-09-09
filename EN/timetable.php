<?php
session_start();
error_reporting(1);

// require "../scripts/check_user.php";

function getLessonAmount ($timetable) {
    $lessons = array();
    foreach ($timetable as $object) {
        $lessons{$object->day} += 1;
    }
    return $lessons;
}

function getTimes($timetable, $start) {
    $times = array();
    foreach ($timetable as $object) {
        if ($start) {
            array_push($times, $object->lessonStart);
        } else {
            array_push($times, $object->lessonEnd);
        }
    }
    return array_values(array_unique($times));
}

function sortTimetable($timetable) {
    $days = array(
        "Monday" => 0,
        "Tuesday" => 1,
        "Wednesday" => 2,
        "Thursday" => 3,
        "Friday" => 4
    );

    $temp = array(
        0 => array(),
        1 => array(),
        2 => array(),
        3 => array(),
        4 => array()
    );
    foreach ($timetable as $value) {
        array_push($temp{$days{$value->day}}, $value);
    }
    return $temp;
}?>
<html>
<head>
    <title>Timetable</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <script src='../js/jquery-3.1.0.min.js'></script>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/table.min.css">
    <link rel="stylesheet" href="../css/timetable.css">
    <link rel="stylesheet" href="../css/navigation.min.css">
    <link rel="stylesheet" href="../css/style.min.css">
</head>

<body>

<?php require "navigator.php" ?>
<div class="filler"></div>

<div class='timetable1'>
    <?php
    $result = json_decode(getContent(array(
        "week" => date('W') % 2,
        "cid" => $_SESSION["classID"],
        "g" => $_SESSION["groupID"]
    ), "get_ordered_timetable.php"));

    $startTimes = getTimes($result, true);
    $endTimes = getTimes($result, false);
    $result = sortTimetable($result); ?>

    <table border='0' cellpadding='0' cellspacing='0'>
        <tr class='days'>
            <th class="time"></th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
        </tr>
        <?php
        $count = array();
        for ($i = 0; count($startTimes) > $i; $i++) {
            echo "<tr>";
            echo "<td class='time'>", $startTimes[$i], " - ", $endTimes[$i], "</td>";
            for ($e = 0; $e <= 4; $e++) {
                if ($startTimes[$i] == $result{$e}{$i - $count[$e]}->lessonStart && ($startTimes[$i] <= date("H:i") and $endTimes[$i] >= date("H:i") and $e == date("N") - 1)) { // checks if the actual time is between the time of the lesson and sets the class cell to 'now'
                    echo "<td class='now' data-tooltip='", $result{$e}{$i - $count[$e]}->lessonName, "'>", $result{$e}{$i - $count[$e]}->lessonShort, " <br>", $result{$e}{$i - $count[$e]}->room, "</td>";
                } elseif ($startTimes[$i] == $result{$e}{$i - $count[$e]}->lessonStart) {
                    echo "<td data-tooltip='", $result{$e}{$i - $count[$e]}->lessonName, "'>", $result{$e}{$i - $count[$e]}->lessonShort, "<br>", $result{$e}{$i - $count[$e]}->room, "</td>";
                } else {
                    $count[$e]++;
                    echo "<td class='nohover'></td>";
                }
            }
            echo "</tr>";
        } ?>
    </table>
    <div class="filler"></div>

    <?php
    $result = json_decode(getContent(array(
        "week" => (date('W') + 1) % 2,
        "cid" => $_SESSION["classID"],
        "g" => $_SESSION["groupID"]
    ), "get_ordered_timetable.php"));

    $startTimes = getTimes($result, true);
    $endTimes = getTimes($result, false);
    $result = sortTimetable($result); ?>

    <table border='0' cellpadding='0' cellspacing='0'>
        <tr class='days'>
            <th class="time"></th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
        </tr>
        <?php
        $count = array();
        for ($i = 0; count($startTimes) > $i; $i++) {
            echo "<tr>";
            echo "<td class='time'>", $startTimes[$i], " - ", $endTimes[$i], "</td>";
            for ($e = 0; $e <= 4; $e++) {
                if ($startTimes[$i] == $result{$e}{$i - $count[$e]}->lessonStart) {
                    echo "<td data-tooltip='", $result{$e}{$i - $count[$e]}->lessonName, "'>", $result{$e}{$i - $count[$e]}->lessonShort, " [", $result{$e}{$i - $count[$e]}->room, "]</td>";
                } else {
                    $count[$e]++;
                    echo "<td class='nohover'></td>";
                }
            }
            echo "</tr>";
        } ?>
    </table>
</div>

<script>
    $(".time").hover(
        function() {
            window.globalVar =  $(this).closest("tr").css("backgroundColor");
            $(this).closest("tr").css({"backgroundColor": "rgba(0, 0, 0, 0.2)"});
            $(this).css({"backgroundColor": "#26697F"})
        }, function() {
            $(this).closest("tr").css({"backgroundColor": window.globalVar})
        })
</script>
</body>
</html>