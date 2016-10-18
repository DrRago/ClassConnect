<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";

$result = json_decode(getContent(array('d' => date("o-m-d"), 'cid' => $_SESSION["classID"]), "get_exams"));
?>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Exams</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">

    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="../js/responsive-nav.js"></script>

    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/exams.css">

</head>

<body>

<div class="mask"></div>

<?php require "navigator.php" ?>
<div class="filler">
</div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>
<div class="examList">
    <table id="tbl">
        <tr>
            <th class='lessonName'><strong>Subject</strong></th>
            <th class="topics"><strong>Topics</strong></th>
            <th><strong>Date</strong></th>
            <th class="ico calendar"></th>
            <?php if ($_SESSION["permissions"] != "User") { echo "<th class='ico'></th><th class='ico'></th>";}?>
        </tr>

        <?php
        if ($result == array()) {
            echo "<tr class='none'><td colspan='6'>No Exams</td></tr>";
        } else {
            foreach ($result as $object) {

                if ($_SESSION["changedExam"] == $object->id) {
                    unset($_SESSION["changedExam"]);
                    echo "<tr id='$object->id' class='changed'>";
                } else {
                    echo "<tr id='$object->id'>";
                }
                echo "<td class='lessonName'>", $object->{'lessonName'}, "</td>";

                if (filter_var($object->{'topics'}, FILTER_VALIDATE_URL)) {
                    echo "<td class='topics'><a target='_blank' href='", $object->{'topics'}, "'>", $object->{'topics'}, "</a></td>";
                } else {
                    echo "<td class='topics'>", $object->{'topics'}, "</td>";
                }
                echo "<td class='examDate'>", $object->{'date'}, "</td>";
                echo "<noscript><td><a href='http://www.google.com/calendar/event?action=template&text=Exam $object->lessonName&dates=", date('Ymd', strtotime($object->date)), "/", date('Ymd', strtotime($object->date)) + 1, "&details=Topics: $object->topics&trp=false&sprop=&sprop=name:' target='_blank' class='fa fa-calendar-plus-o'></a></td></noscript>";
                ?>
                <td><button onclick='window.open("http://www.google.com/calendar/event?action=template&text=Exam <?= $object->lessonName ?>&dates=<?= date('Ymd', strtotime($object->date)) ?>/<?= date('Ymd', strtotime($object->date)) + 1 ?>&details=Topics: <?= $object->topics ?>&trp=false&sprop=&sprop=name:")' class='fa fa-calendar-plus-o'></button></td>

                <?php
                if ($_SESSION["permissions"] != "User") {
                    echo "<td><button type='submit' onclick='editExam(this, \"", $_SESSION["sessionID"], "\")' class='fa fa-pencil'></button></td>";
                    echo "<td><button type='submit' onclick='deleteExam(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='fa fa-trash'></button></td>";
                }
                echo "</tr>";
            }
        } ?>
        <script>
            var ele2 = document.getElementsByClassName('hidden');

            for (var i = 0; i < ele2.length; i++) {
                ele2[i].removeAttribute("hidden")
            }
        </script>
    </table>
</div>

<!-- edit begin -->
<form class="inyo" method="post" action="../scripts/update_exam.php" hidden>
    <div class="fa-li fa fa-spinner fa-spin fa-2x"></div>
    <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-list-ol"></i>
                </span>
        <input id="id" class="form-control" name="id" placeholder="id" type="text" readonly required>
    </div>
    <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-book"></i>
                </span>
        <input type="text" class="form-control" name="lesson" id="lesson_in" placeholder="subject" required>
    </div>
    <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-tasks"></i>
                </span>
        <input type="text" class="form-control" name="topics" id="topics_in" placeholder="topics">
    </div>
    <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
        <input type="date" class="form-control" name="date" id="date_in" placeholder="YYYY-MM-DD" required>
    </div>
    <input title="validation" name="validation" value="<?php echo $_SESSION["sessionID"] ?>"
           style="display: none" hidden>
    <button class="btn btn-default"> &nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
</form>
<!-- edit end -->

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
                <input type="text" class="form-control" name="topics" id="topics_in" placeholder="topics">
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

<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    if (ele != null) {
        window.scrollTo(ele.offsetLeft, ele.offsetTop);
    }
</script>

<script class="editJS">
    function editExam(e, sessionID) {
        $(".mask").show();
        $(".inyo").show();
        $(".form-inline input").prop( "disabled", true );
        loadContents(e.closest("tr").getAttribute("id"), sessionID)
    }

    function loadContents(id, sessionID) {
        $.ajax({
            type: 'POST',
            url: '../scripts/get_exam.php',
            data: "id=" + id + "&validation=" + sessionID,
            success: function (data) {
                data = data.slice(1).slice(0, -1);
                var obj = jQuery.parseJSON(data);
                $(".inyo #id").val(obj.id);
                $(".inyo #lesson_in").val(obj.lessonName);
                $(".inyo #topics_in").val(obj.topics);
                $(".inyo #date_in").val(obj.date);
            }
        });
    }

    $(document).on('keyup',function(evt) {
        if (evt.keyCode == 27) {
            exitEdit();
        }
    });

    $(document).mouseup(function (e)
    {
        var container = $(".inyo");

        if (!container.is(e.target) && container.has(e.target).length === 0) {
            exitEdit();
        }
    });

    function exitEdit() {
        $(".mask").hide();
        $(".inyo").hide();
        $(".form-inline input").prop("disabled", false);
    }
</script>

<script src='../js/jquery-3.1.0.js'></script>

<script src="../js/exams.js"></script>
</body>
</html>