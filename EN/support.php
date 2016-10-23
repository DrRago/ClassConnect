<?php session_start();
error_reporting(1);
require "../scripts/check_user.php";
?>
<html>
<head>
    <title>Support</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">

    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="../js/responsive-nav.js"></script>

    <script src="../js/autosize.js"></script>
    <script src="../js/support.js"></script>
    <script src="../js/jquery-3.1.1.js"></script>

    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/style.css">
    <?php if ($_SESSION["permissions"] == "ServerAdmin") { echo "<link rel='stylesheet' href='../css/table.css'>";}?>
    <link rel="stylesheet" href="../css/support.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/input_container.css">

</head>

<body>
<?php require "navigator.php" ?>
<div class="filler"></div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>
<?php if ($_SESSION["permissions"] != "ServerAdmin") { ?>
    <div class="form-inline">
        <form class="form" method="post" action="../scripts/add_ticket.php">
            <table class="supportInput">
                <tr>
                    <td><label class="username">Username:<a class="IsRequired">*</a></label></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>
                            <input class="name form-control" name="username" type="text" value="<?php echo $_SESSION['username'] ?>" placeholder="Username" readonly>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="name">Name:<a class="IsRequired">*</a></label></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-male"></i>
                            </span>
                            <input class="form-control" name="name" type="text" value="<?php if (isset($_SESSION["ticketName"])) { echo $_SESSION["ticketName"]; } else { echo $_SESSION['name']; } ?>" placeholder="Name" required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="email">Email Address:<a class="IsRequired">*</a></label></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-at"></i>
                            </span>
                            <input class="form-control" name="email" type="email" value="<?php if (isset($_SESSION["ticketEmail"])) { echo $_SESSION["ticketEmail"]; } else { echo $_SESSION['email']; } ?>" placeholder="Email" required>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="topic">Topic:<a class="IsRequired">*</a></label></td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-tag"></i>
                            </span>
                            <select class="form-control" name="topic" title="topicSelection" required>
                                <option value="Bug">Bug</option>
                                <option value="Add Class">Add Class</option>
                                <option value="Delete User">Delete User</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="message">Message:<a class="IsRequired">*</a></label></td>
                    <td>
                        <div class="input-group textarea">
                            <span class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </span>
                            <textarea class="form-control" maxlength="500" id="message" name="message" placeholder="message"><?php echo $_SESSION["ticketMessage"] ?></textarea>
                        </div>
                    </td>
                </tr>
            </table>
            <button type="submit" class="btn btn-default">&nbsp;Submit <span class="fa fa-paper-plane"> </span></button>

            <?php if ($_SESSION["addTicket"] == "success") {
                echo "<div class='alert alert-success' style='margin-top: 40px;margin-bottom: -40px'><strong>success: </strong>Ticket raised successfully.</div>";
                unset($_SESSION["addTicket"]);
            } elseif ($_SESSION["addTicket"] == "error") {
                echo "<div class='alert alert-danger' style='margin-top: 40px;margin-bottom: -40px'><strong>error: </strong>Wrong email format.</div>";
                unset($_SESSION["addTicket"]);
            }
            unset($_SESSION["ticketEmail"]);
            unset($_SESSION["ticketName"]);
            unset($_SESSION["ticketMessage"]);
            ?>
        </form>
    </div>
<?php } else {
    include_once "../scripts/communicate.php";
    $result = getContent(array(), "get_tickets");
    $result = json_decode($result);
    ?>
    <div class="supportList">
        <table>
            <tr>
                <th class="id"><strong>ID</strong></th>
                <th class="creator"><strong>Creator</strong></th>
                <th class="mail"><strong>Email</strong></th>
                <th class="reason"><strong>Reason</strong></th>
                <th class="crID"><strong>Creator ID</strong></th>
                <?php if ($_SESSION["permissions"] != "User") { echo "<th class='ico'></th><th class='ico'></th>";}?>
            </tr>
            <?php
            if ($result == array()) {
                echo "<tr><td colspan='7'>No Tickets</td></tr>";
            } else {
                foreach ($result as $object) {
                    echo "<tr id='$object->id'><td><input class='ticketID' name='id' type='text' readonly style='width:", strlen($object->{'id'}) * 10, "px;' value='$object->id'>";
                    echo "<td class='name'>$object->creatorName</td>";
                    echo "<td class='email'>$object->creatorEmail</td>";
                    echo "<td class='reason'>$object->reason</td>";
                    echo "<td class='creatorID'>$object->creatorID</td>";
                    echo "<td><button type='submit' onclick='window.location.href=\"ticket.php?id=$object->id\"' class='fa fa-eye'></button></td>";
                    echo "<td><button type='submit' onclick='deleteTicket(this,\"$_SESSION[sessionID]\")' content='$object->id' class='fa fa-trash'></button></td>";
                    echo "</tr>";
                }
            } ?>
        </table>
    </div>
<?php } ?>

<script src="../js/fastclick.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/fixed-responsive-nav.js"></script>

<script>
    autosize(document.getElementById('message'));
</script>
</body>
</html>