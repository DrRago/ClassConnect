<?php
error_reporting(1);
session_start();
require "../scripts/check_user.php";
require_once "../scripts/communicate.php";

$result = getContent(array('id' => $_GET['id']), "get_exam.php");

$result = json_decode($result);
$result = 1;
?>
<html>
<head>
    <title>Exam <?php echo $_GET["id"]?></title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/input_container.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/ticket.css">
</head>
<body>
<?php require "navigator.php"; ?>
<div class="filler">
</div>

<div class="inputs">
    <form class="form" method="post" action="../scripts/update_exam.php">
        <?php
        if (!is_numeric($_GET['id'])) {
            echo "<div class='alert-box error ticketError'><span>error: </span>The ID ", $_GET['id'], " is no number</div>";
        } else {
            if ($result == null) {
                echo "<div class='alert-box error ticketError'><span>error: </span>No exam with the ID ", $_GET['id'], " found</div>";
            } else { ?>
                <div class="input"><label>Exam ID:</label><input name="id" type="text"
                                                                 value="<?php echo $result{0}->id ?>" readonly><br></div>
                <div class="input"><label>Lesson</label><input type="text"
                                                               value="<?php echo $result{0}->lessonName ?>"><br></div>
                <div class="input"><label>Topics:</label><input name="name" type="text"
                                                                value="<?php echo $result{0}->topics ?>"><br></div>
                <div class="input"><label>Date:</label><input type="text"
                                                              value="<?php echo $result{0}->examDate ?>"><br></div>
                <button class="btn" type="submit">&nbsp;Submit <span class="arrow">❯</span></button>
                <?php
            }
        }
        ?>
    </form>
</div>

</body>
</html>