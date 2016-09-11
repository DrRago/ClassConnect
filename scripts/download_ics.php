<?php
$summary = "Exam: ";
$datestart = strtotime("2016-09-05");
$dateend = strtotime("2016-09-05");
$description = "Topics: " . "Things";
$filename = "name" . ".ics";
$time = date('Ymd\THis\Z', time());

$dateend = date("Y-m-d", strtotime(date("d-m-Y", ($dateend)) . " + 1 day"));

header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

function dateToCal($timestamp) {
    return date('Ymd', $timestamp);
}

function escapeString($string) {
    return preg_replace('/([\,;])/','\\\$1', $string);
}
?>
BEGIN:VCALENDAR
PRODID:dqi.tandashi.de
VERSION:2.0
METHOD:PUBLISH
X-MS-OLK-FORCEINSPECTOROPEN:TRUE
BEGIN:VEVENT
CLASS:PUBLIC
CREATED:<?= $time . "\n" ?>
DESCRIPTION:<?= escapeString($description) . "\n" ?>
DTEND;VALUE=DATE:<?= dateToCal($dateend) . "\n" ?>
DTSTAMP:<?= $time . "\n" ?>
DTSTART;VALUE=DATE:<?= dateToCal($datestart) . "\n" ?>
LAST-MODIFIED:<?= $time . "\n" ?>
PRIORITY:5
SEQUENCE:0
SUMMARY;LANGUAGE=de:<?= escapeString($summary) . "\n"?>
TRANSP:TRANSPARENT
END:VEVENT
END:VCALENDAR