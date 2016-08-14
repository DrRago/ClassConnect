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

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/input_container.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<?php require "navigator.php"; ?>
<div class="filler">
</div>
<div class="form-inline">
    <form class="form" method="post" action="../scripts/delete_ticket.php">
        <?php
        if (!is_numeric($_GET['id'])) {
            echo "<div class='alert alert-danger'><strong>error: </strong>The ID ", $_GET['id'], " is no number</div>";
        } else {
            if ($result == null) {
                echo "<div class='alert alert-danger'><strong>error: </st>No ticket with the ID ", $_GET['id'], " found</div>";
            } else { ?>
                <table>
                    <tr>
                        <td><label for="id">Ticket ID:</label></td>
                        <td><input id="id" class="form-control" name="id" type="text" value="<?php echo $result{0}->id ?>" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="creatorID">Creator ID:</label></td>
                        <td><input id="creatorID" class="form-control" type="text" value="<?php echo $result{0}->creatorID ?>" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="creatorName">Creator Name:</label></td>
                        <td><input id="creatorName" class="form-control" name="name" type="text" value="<?php echo $result{0}->creatorName ?>" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="creatorEmail">Creator Email:</label></td>
                        <td><input id="creatorEmail" class="form-control" type="text" value="<?php echo $result{0}->creatorEmail ?>" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="reason">Topic:</label></td>
                        <td><input id="reason" class="form-control" type="text" value="<?php echo $result{0}->reason ?>" readonly></td>
                    </tr>
                    <tr>
                        <td><label for="message">Message:</label></td>
                        <td><textarea id="message" class="form-control" readonly><?php echo $result{0}->content ?></textarea></td>
                    </tr>
                </table>
                <button class="btn btn-default">&nbsp;Delete <span class="fa fa-trash"></span></button>
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
