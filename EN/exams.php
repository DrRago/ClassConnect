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
    <div class="alert alert-danger" role="alert">
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
            <?php if ($_SESSION["permissions"] != "User") { echo "<th class='ico'></th><th class='ico delete' style='display: none'></th>";}?>
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
                echo "<td class='lessonName'>$object->lessonName</td>";

                if (filter_var($object->{'topics'}, FILTER_VALIDATE_URL)) {
                    echo "<td class='topics'><a target='_blank' href='$object->topics'>Click Here</a></td>";
                } else {
                    echo "<td class='topics'>$object->topics</td>";
                }
                echo "<td class='examDate'>$object->date</td>";

                $timecode = date('Ymd', strtotime($object->date));
                $timecode2 = $timecode + 1;
                echo "<td><a class='nolink' href='http://www.google.com/calendar/event?action=template&text=Exam $object->lessonName&dates=$timecode/$timecode2&details=Topics: $object->topics&trp=false&sprop=&sprop=name:' target='_blank'><button class='fa fa-calendar-plus-o'></button></a></td>";

                if ($_SESSION["permissions"] != "User") {
                    echo "<td><noscript><a class='nolink' href='exam.php?id=$object->id'></noscript><button type='submit' onclick='editExam(this, \"", $_SESSION["sessionID"], "\")' class='fa fa-pencil'></button><noscript></a></noscript></td>";
                    echo "<td class='delete' style='display: none'><button type='submit' onclick='deleteExam(this,\"", $_SESSION["sessionID"], "\")' content='$object->id' class='fa fa-trash'></button></td>";
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
    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>

    <div class="input-div" style="display: none">
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
        <input title="validation" name="validation" id="session" value="<?php echo $_SESSION["sessionID"] ?>"
               style="display: none" hidden>
        <button class="btn btn-default"> &nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
    </div>
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

    $(".delete").show();
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
                $(".inyo .input-div").show();
                $(".inyo .fa-spin").hide();
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
        $(".inyo .input-div").hide();
        $(".inyo .fa-spin").show();
    }

    $(".inyo").submit(function () {
        $(".inyo .input-div").hide();
        $(".inyo .fa-spin").show();

        var inputs = $(this).find(".input-div");

        var id = inputs.find("#id").val();
        var lesson = inputs.find("#lesson_in").val();
        var topics = inputs.find("#topics_in").val();
        var date = inputs.find("#date_in").val();

        $.ajax({
            type: 'POST',
            url: '../scripts/update_exam.php',
            data: "id=" + id + "&lesson=" + lesson + "&topics=" + topics + "&date=" + date + "&validation=" + inputs.find("#session").val(),
            success: function (data) {
                if (data == "bdec0ac5c069dd4899e2bf43dc43f4639218a05bbf43f165fd0e80dfe729d118b820551c81bf0308e225a9125ab44823fe89406f56c1a680dad7ecccf631e63c") {
                    alert("Error, please check your dateformat");
                } else {
                    var changedRow = $(".examList #" + id);
                    changedRow.find(".lessonName").html(lesson);
                    changedRow.find(".topics").html(topics);
                    changedRow.find(".examDate").html(date);

                    changedRow.addClass("changed");

                    exitEdit();
                    setTimeout(function () {
                        changedRow.removeClass("changed");
                    }, 4000);
                }
            }
        });
        return false;
    })
</script>

<script src='../js/jquery-3.1.0.js'></script>

<script src="../js/exams.js"></script>
</body>
</html>