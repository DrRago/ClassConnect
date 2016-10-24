<?php
error_reporting(1);
session_start();
require "../scripts/check_user.php";

if ($_SESSION["permissions"] == "User") {

    echo "<meta http-equiv='refresh' content='3; URL=../scripts/logout.php'>";
    echo "Sorry Brudah, du kommst hier net rein";
} else {

    $result = json_decode(getContent(array('id' => $_GET['id']), "get_exam")); ?>
    <html>
    <head>
        <title>Exam <?= $_GET["id"] ?></title>

        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/font-awesome.css">

        <meta name="viewport" content="width=device-width,initial-scale=1">
        <script src="../js/responsive-nav.js"></script>

        <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

        <link rel="stylesheet" href="../css/navigation.css">
        <link rel="stylesheet" href="../css/formula.css">
        <link rel="stylesheet" href="../css/input_container.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
    <?php require "navigator.php"; ?>
    <div class="filler">
    </div>
    <noscript>
        <div class="container alert alert-danger" role="alert">
            <strong>Warning!</strong>
            For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link"
                                                                                                      href="http://www.enable-javascript.com/"
                                                                                                      target="_blank">
                instructions how to enable JavaScript in your web browser</a>.
        </div>
    </noscript>
    <?php
    if (!is_numeric($_GET['id'])) {
        echo "<div class='alert alert-danger container'><strong>error: </strong>The ID $_GET[id] is no number</div>";
    } else {
    if ($result == null || ($result{0}->classID != $_SESSION["classID"] && $_SESSION["permissions"] != "ServerAdmin")) {
        echo "<div class='alert alert-danger container'><strong>error: </strong>No exam with the ID $_GET[id] found</div>";
    } else { ?>
    <div class="form-inline">
        <form class="form" method="post" action="../scripts/update_exam.php">
            <table>
                <tr>
                    <td><label for="id">Exam ID<a class="IsRequired">*</a>:</label></td>
                    <td>
                        <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-list-ol"></i>
                        </span>
                            <input id="id" class="form-control" name="id" type="text"
                                   value="<?= $result{0}->id ?>" readonly required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="lesson">Subject<a class="IsRequired">*</a>:</label></td>
                    <td>
                        <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-book"></i>
                        </span>
                            <input id="lesson" class="form-control" name="lesson" type="text"
                                   value="<?= $result{0}->lesson ?>" required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="topics">Topics:</label></td>
                    <td>
                        <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-tasks"></i>
                        </span>
                            <input id="topics" class="form-control" name="topics" type="text"
                                   value="<?= $result{0}->topics ?>" placeholder="Tasks">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="date">Date<a class="IsRequired">*</a>:</label></td>
                    <td>
                        <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                            <input id="date" pattern="^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$" class="form-control" name="date" type="date"
                                   value="<?= $result{0}->date ?>" required>
                        </div>
                    </td>
                </tr>
            </table>
            <input title="validation" name="validation" value="<?= $_SESSION["sessionID"] ?>"
                   style="display: none" hidden>
            <button class="btn btn-default" type="submit">&nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
            <?php
            }
            }
            ?>
        </form>
    </div>

    <script src="../js/fastclick.js"></script>
    <script src="../js/scroll.js"></script>
    <script src="../js/fixed-responsive-nav.js"></script>

    <script src="../js/jquery-3.1.1.js"></script>

    </body>
    </html>
    <?php
} ?>