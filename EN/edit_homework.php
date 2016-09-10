<?php
error_reporting(1);
session_start();
require "../scripts/check_user.php";

if ($_SESSION["permissions"] == "User") {

    echo "<meta http-equiv='refresh' content='3; URL=../scripts/logout.php'>";
    echo "Sorry Brudah, du kommst hier net rein";
} else {

    $result = json_decode(getContent(array('id' => $_GET['id']), "get_assignment")); ?>
    <html>
    <head>
        <title>Homework <?php echo $_GET["id"] ?></title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">

        <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

        <link rel="stylesheet" href="../css/navigation.min.css">
        <link rel="stylesheet" href="../css/formula.min.css">
        <link rel="stylesheet" href="../css/input_container.min.css">
        <link rel="stylesheet" href="../css/style.min.css">
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
        echo "<div class='alert alert-danger container'><strong>error: </strong>The ID ", $_GET['id'], " is no number</div>";
    } else {
    if ($result == null || ($result{0}->classID != $_SESSION["classID"] && $_SESSION["permissions"] != "ServerAdmin")) {
        echo "<div class='alert alert-danger container'><strong>error: </strong>No homework with the ID ", $_GET['id'], " found</div>";
    } else { ?>
    <div class="form-inline">
        <form class="form" method="post" action="../scripts/update_homework.php">
            <table>
                <tr>
                    <td><label for="id">Homework ID<a class="IsRequired">*</a>:</label></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-list-ol"></i>
                            </span>
                            <input id="id" class="form-control" name="id" type="text" value="<?php echo $result{0}->id ?>"
                                   readonly required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="lesson">Lesson<a class="IsRequired">*</a>:</label></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-book"></i>
                            </span>
                            <input id="lesson" class="form-control" name="lesson" type="text"
                                   value="<?php echo $result{0}->lessonName ?>" required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="exercises">Exercises<a class="IsRequired">*</a>:</label></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-tasks"></i>
                            </span>
                            <input id="exercises" class="form-control" name="exercises" type="text"
                                   value="<?php echo $result{0}->exercises ?>" required>
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
                            <input id="date" class="form-control" name="date" type="date"
                                   value="<?php echo $result{0}->date ?>" required>
                        </div>
                    </td>
                </tr>
            </table>
            <input title="validation" name="validation" value="<?php echo $_SESSION["sessionID"] ?>" hidden>
            <button class="btn btn-default" type="submit">&nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
            <?php
            }
            }
            ?>
        </form>
    </div>

    </body>
    </html>
    <?php
} ?>