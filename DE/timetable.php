<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";

function getLessonAmount($timetable)
{
    $length = count($timetable);
    $count = 0;
    $amount = 0;;
    while ($length > $count) {
        $length_2 = count($timetable{$count});
        if ($length_2 > $amount) {
            $amount = $length_2;
        }
        $count++;
    }
    return $amount;
}

function getLargestDay($timetable)
{
    $length = count($timetable);
    $count = 0;
    $amount = 0;
    $largest_day = 0;
    while ($length > $count) {
        $length_2 = count($timetable{$count});
        if ($length_2 > $amount) {
            $amount = $length_2;
            $largest_day = $count;
        }
        $count++;
    }
    return $largest_day;
}

function addDay($timetable, $index, $day, $week)
{
    $result = json_decode(getContent(array('d' => $day, 'w' => $week, 'g' => $_SESSION["groupID"], 'c' => $_SESSION["classID"]), "get_timetable.php"));
    $length = count($result);
    $count = 0;

    while ($length > $count) {
        $timetable[$index][$count]['id'] = $result{$count}->id;
        $timetable[$index][$count]['lessonName'] = $result{$count}->lessonName;
        $timetable[$index][$count]['lessonStart'] = $result{$count}->lessonStart;
        $timetable[$index][$count]['lessonEnd'] = $result{$count}->lessonEnd;
        $timetable[$index][$count]['room'] = $result{$count}->room;
        $timetable[$index][$count]['week'] = $result{$count}->week;
        $timetable[$index][$count]['groupID'] = $result{$count}->groupID;
        $timetable[$index][$count]['classID'] = $result{$count}->classID;
        $count++;
    }
    return $timetable;
}

$timetable = array();
$timetable = addDay($timetable, 0, 'monday', date('W') % 2);
$timetable = addDay($timetable, 1, 'tuesday', date('W') % 2);
$timetable = addDay($timetable, 2, 'wednesday', date('W') % 2);
$timetable = addDay($timetable, 3, 'thursday', date('W') % 2);
$timetable = addDay($timetable, 4, 'friday', date('W') % 2);
$lessonAmount = getLessonAmount($timetable);
$startTimes = array();
$endTimes = array();
$largest_day = getLargestDay($timetable);
$count = array();
for ($i = 0; $lessonAmount > $i; $i++) {
    $startTimes[$i] = $timetable{$largest_day}{$i}['lessonStart'];
    $endTimes[$i] = $timetable{$largest_day}{$i}['lessonEnd'];
}
?>
<html>
<head>
    <title>Stundenplan</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/timetable.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<?php require "navigator.php" ?>
<div class="filler">
</div>
<table class="timetable">
    <tr>
        <th class="Week" colspan="2"><strong><?php if ((date('W') % 2) == 0) {
                    echo "gerade Woche";
                } else {
                    echo "ungerade Woche";
                } ?> (aktuelle Woche)</strong></th>
    </tr>
    <tr>
        <th><strong>Zeiten</strong></th>
        <th><strong>Montag</strong></th>
        <th><strong>Dienstag</strong></th>
        <th><strong>Mittwoch</strong></th>
        <th><strong>Donnerstag</strong></th>
        <th><strong>Freitag</strong></th>
    </tr>
    <?php
    for ($i = 0; $lessonAmount > $i; $i++) {
        echo "<tr>";
        echo "<td class='nohover'>", $startTimes[$i], " - ", $endTimes[$i], "<br>Raum</td>";
        for ($e = 0; $e <= 4; $e++) {
            if ($startTimes[$i] == $timetable{$e}{$i - $count[$e]}['lessonStart']) {
                if ($startTimes[$i] <= date("H:i") and $endTimes[$i] >= date("H:i") and $e == date("N") - 1) { // checks if the actual time is between the time of the lesson and sets the class cell to 'now'
                    echo "<td class='now'>", $timetable{$e}{$i - $count[$e]}['lessonName'], "<br>", $timetable{$e}{$i - $count[$e]}['room'], "</td>";
                } else {
                    echo "<td>", $timetable{$e}{$i - $count[$e]}['lessonName'], "<br>", $timetable{$e}{$i - $count[$e]}['room'], "</td>";
                }
            } else {
                $count[$e]++;
                echo "<td class='nohover'></td>";
            }
        }
        echo "</tr>";
    }
    ?>
</table>
<div class="filler"></div>
<?php
$timetable = array();
$timetable = addDay($timetable, 0, 'monday', ((date('W') % 2) + 1) % 2);
$timetable = addDay($timetable, 1, 'tuesday', ((date('W') % 2) + 1) % 2);
$timetable = addDay($timetable, 2, 'wednesday', ((date('W') % 2) + 1) % 2);
$timetable = addDay($timetable, 3, 'thursday', ((date('W') % 2) + 1) % 2);
$timetable = addDay($timetable, 4, 'friday', ((date('W') % 2) + 1) % 2);
$lessonAmount = getLessonAmount($timetable);
$startTimes = array();
$endTimes = array();
$largest_day = getLargestDay($timetable);
$count = array();
for ($i = 0; $lessonAmount > $i; $i++) {
    $startTimes[$i] = $timetable{$largest_day}{$i}['lessonStart'];
    $endTimes[$i] = $timetable{$largest_day}{$i}['lessonEnd'];
}
?>
<table class="timetable">
    <tr>
        <th colspan="2"><strong><?php if (((date('W') + 1) % 2) == 0) {
                    echo "gerade Woche";
                } else {
                    echo "ungerade Woche";
                } ?></strong></th>
    </tr>
    <tr>
        <th><strong>Zeiten</strong></th>
        <th><strong>Montag</strong></th>
        <th><strong>Dienstag</strong></th>
        <th><strong>Mittwoch</strong></th>
        <th><strong>Donnerstag</strong></th>
        <th><strong>Freitag</strong></th>
    </tr>
    <?php
    for ($i = 0; $lessonAmount > $i; $i++) {
        echo "<tr>";
        echo "<td class='nohover'>", $startTimes[$i], " - ", $endTimes[$i], "<br>Raum</td>";
        for ($e = 0; $e <= 4; $e++) {
            if ($startTimes[$i] == $timetable{$e}{$i - $count[$e]}['lessonStart']) {
                echo "<td>", $timetable{$e}{$i - $count[$e]}['lessonName'], "<br>", $timetable{$e}{$i - $count[$e]}['room'], "</td>";
            } else {
                $count[$e]++;
                if ($startTimes[$i] <= date("H:i") and $endTimes[$i] >= date("H:i") and $e == date("N") - 1) {
                    echo "<td></td>";
                } else {
                    echo "<td class='nohover'></td>";
                }
            }
        }
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>