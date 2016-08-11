<?php
error_reporting(1);
session_start();
require_once "../scripts/communicate.php";

$result = getContent(array('id' => $_GET['id']), "get_ticket.php");

$result = json_decode($result);
?>

<html>
<head>
    <title>Ticket <?php echo $_GET['id'] ?></title>

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
    <form class="form" method="post" action="../scripts/delete_ticket.php">
        <?php
        if (!is_numeric($_GET['id'])) {
            echo "<div class='alert-box error ticketError'><span>fehler: </span>Die ID ", $_GET['id'], " ist keine Zahl</div>";
        } else {
            if ($result == null) {
                echo "<div class='alert-box error ticketError'><span>fehler: </span>Es existiert kein Ticket mit der ID ", $_GET['id'], "</div>";
            } else { ?>
                <div class="input"><label>Ticket ID:</label><input name="id" type="text"
                                                                   value="<?php echo $result{0}->id ?>" readonly><br>
                </div>
                <div class="input"><label>Ersteller ID:</label><input type="text"
                                                                    value="<?php echo $result{0}->creatorID ?>"
                                                                    readonly><br></div>
                <div class="input"><label>Ersteller Name:</label><input name="name" type="text"
                                                                      value="<?php echo $result{0}->creatorName ?>"
                                                                      readonly><br></div>
                <div class="input"><label>Ersteller Email:</label><input type="text"
                                                                       value="<?php echo $result{0}->creatorEmail ?>"
                                                                       readonly><br></div>
                <div class="input"><label>Grund:</label><input type="text" value="<?php echo $result{0}->reason ?>"
                                                               readonly><br></div>
                <div class="input"><label>Nachricht:</label><textarea id="note" oninput=""
                                                                    readonly><?php echo $result{0}->content ?></textarea><br>
                </div>
                <button class="btn">&nbsp;Löschen <span class="arrow">X</span></button>
                <?php
            }
        }
        ?>
    </form>
</div>
<script>
    var s_height = document.getElementById('note').scrollHeight + 10;
    document.getElementById('note').setAttribute('style', 'height:' + s_height + 'px');
</script>

</body>
</html>
