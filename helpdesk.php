<?php session_start();
error_reporting(1);
require "scripts/check_user.php";
?>
<html>
<head>
    <title>Helpdesk</title>

    <link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico'>

    <link rel="stylesheet" href="css/formula.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/helpdesk.css">
    <link rel="stylesheet" href="css/input_container.css">

</head>

<body>
<?php require "navigator.php" ?>
<div class="filler"></div>
<?php if ($_SESSION["permissions"] != "ServerAdmin") { ?>
    <div class="inputs">
        <form class="form" method="post" action="scripts/add_ticket.php">
            <div class="input"><label class="username">Username:<a class="IsRequired">*</a></label><input class="name"
                                                                                                          name="username"
                                                                                                          type="text"
                                                                                                          value="<?php echo $_SESSION['username'] ?>"
                                                                                                          placeholder="Username"
                                                                                                          readonly><br>
            </div>
            <div class="input"><label class="name">Name:<a class="IsRequired">*</a></label><input name="name"
                                                                                                  type="text"
                                                                                                  value="<?php if (isset($_SESSION["ticketName"])) {
                                                                                                      echo $_SESSION["ticketName"];
                                                                                                  } else {
                                                                                                      echo $_SESSION['name'];
                                                                                                  } ?>"
                                                                                                  placeholder="Name"
                                                                                                  required><br></div>
            <div class="input"><label class="email">Email Address:<a class="IsRequired">*</a></label><input name="email"
                                                                                                            type="email"
                                                                                                            value="<?php if (isset($_SESSION["ticketEmail"])) {
                                                                                                                echo $_SESSION["ticketEmail"];
                                                                                                            } else {
                                                                                                                echo $_SESSION['email'];
                                                                                                            } ?>"
                                                                                                            placeholder="Email"
                                                                                                            required><br>
            </div>
            <div class="input"><label class="topic">Topic:<a class="IsRequired">*</a></label>
                <select name="topic" title="topicSelection" required>
                    <option value="Bug">Bug</option>
                    <option value="Add Class">Add Class</option>
                    <option value="Delete User">Delete User</option>
                    <option value="Other">Other</option>
                </select><br>
            </div>
            <div class="input"><label class="message">Message:<a class="IsRequired">*</a></label><textarea
                    maxlength="500" oninput="resize()" id="message" name="message"
                    placeholder="message"><?php echo $_SESSION["ticketMessage"] ?></textarea><br></div>
            <button type="submit" class="btn">&nbsp;Submit <span class="arrow">❯</span></button>
            <?php if ($_SESSION["addTicket"] == "success") {
                echo "<div class='alert-box success'><span>success: </span>Ticket raised successfully.</div>";
                unset($_SESSION["addTicket"]);
            } elseif ($_SESSION["addTicket"] == "error") {
                echo "<div class='alert-box error'><span>error: </span>Wrong email format.</div>";
                unset($_SESSION["addTicket"]);
            }
            unset($_SESSION["ticketEmail"]);
            unset($_SESSION["ticketName"]);
            unset($_SESSION["ticketMessage"]);
            ?>
        </form>
    </div>
<?php } else {
    include_once "scripts/communicate.php";
    $result = getContent(array(), "get_every_ticket.php");
    $result = json_decode($result);
    ?>
    <div class="helpdeskList">
        <table>
            <tr>
                <th class="id"><strong>ID</strong></th>
                <th class="creator"><strong>Creator</strong></th>
                <th class="mail"><strong>Email</strong></th>
                <th class="reason"><strong>Reason</strong></th>
                <th class="crID"><strong>Creator ID</strong></th>
            </tr>
            <?php
            if (!isset($result)) {
                echo "<tr><td colspan='5'>No Tickets</td></tr>";
            } else {
                foreach ($result as $object) {
                    echo "<tr onclick='window.location.href=\"ticket.php?id=", $object->{'id'}, "\"'><td><input class='ticketID' name='id' type='text' readonly style='width:", strlen($object->{'id'}) * 10, "px;' value='", $object->{'id'}, "'>";
                    echo "<td class='name'>", $object->{'creatorName'}, "</td>";
                    echo "<td class='email'>", $object->{'creatorEmail'}, "</td>";
                    echo "<td class='reason'>", $object->{'reason'}, "</td>";
                    echo "<td class='creatorID'>", $object->{'creatorID'}, "</td></tr>";
                }
            } ?>
        </table>
        <?php
        if (isset($_SESSION["deleteTicket"])) {
            echo "<div class='alert-box ticketSuccess'><span>success: </span>Ticket ", $_SESSION['deleteTicket'], " deleted successfully.</div>";
            unset($_SESSION["deleteTicket"]);
        }
        ?>
    </div>
<?php } ?>

<script>
    function resize() {
        var s_height = document.getElementById('message').scrollHeight;
        document.getElementById('message').setAttribute('style', 'height:' + s_height + 'px')
    }
</script>
</body>
</html>