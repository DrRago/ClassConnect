<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";
$permissions = $_SESSION['permissions'];

if ($permissions == 'ServerAdmin') {
    $output = json_decode(getContent(array(), "get_every_user.php"));
} else {
    $output = json_decode(getContent(array('cid' => $_SESSION["classID"]), "get_class.php"));
}
?>
<html>
<head>
    <title>Users</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootrstrap.css">

    <link rel="stylesheet" href="../css/users.css">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php require "navigator.php" ?>
<div class='filler'>
</div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>
<div class='userList'>
    <table>
        <tr>
            <th class="free_space"></th>
            <?php if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th class='id'><strong>ID</strong></th>";
            } ?>
            <th><strong>Name</strong></th>
            <?php if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th><strong>Username</strong></th>";
            } ?>
            <th><strong>Email</strong></th>
            <th><strong>Phone</strong></th>
            <th><strong>Permissions</strong></th>
            <th><strong>GroupID</strong></th>
            <?php if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th><strong>ClassID</strong></th>";
            }
            if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th></th>";
            }
            if ($permissions == "ServerAdmin")  {
                echo "<th></th>";
            }
            echo "</tr>";
            $user_amount = count($output);
            for ($count = 0; $count < $user_amount; $count++) {
                if ($_SESSION["username"] == $output[$count]->username) {
                    echo "<tr class='me' id='", $output[$count]->id, "'>";
                } elseif ($_SESSION["changedUser"] == $output[$count]->id) {
                    unset($_SESSION["changedUser"]);
                    echo "<tr id='", $output[$count]->id, "' class='changed'>";
                } else {
                    echo "<tr id='", $output[$count]->id, "'>";
                }
                echo "<td class='", $output[$count]->permissions, "'></td>";
                if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                    echo "<td><input name='id' type='text' readonly style='width:", strlen($output[$count]->id) * 9, "px;' value='", $output[$count]->id, "'>";
                }
                echo "<td>", $output[$count]->name, "</td>";
                if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                    echo "<td>", $output[$count]->username, "</td>";
                }
                echo "<td>", $output[$count]->email, "</td>";
                echo "<td>", $output[$count]->phone, "</td>";
                echo "<td>", $output[$count]->permissions, "</td>";
                echo "<td>", $output[$count]->groupID, "</td>";
                if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                    echo "<td>", $output[$count]->classID, "</td>";
                }
                if ($permissions == "ServerAdmin" || ($permissions == "ClassAdmin" & $output[$count]->permissions != "ServerAdmin")) {
                    echo "<td><button onclick='window.location.href=\"edit.php?id=", $output[$count]->id, "\"' class='glyphicon glyphicon-pencil'></button></td>";
                } elseif ($permissions == "ClassAdmin") {
                    echo "<td></td>";
                }
                if ($permissions == "ServerAdmin") {
                    echo "<td><button content='", $output[$count]->id, "' onclick='deleteUser(this,\"", $_SESSION["sessionID"], "\")' class='glyphicon glyphicon-trash'></button></td>";
                }
                echo "</tr>";
            }
            ?>
    </table>
</div>

<?php if ($_SESSION["permissions"] == "ClassAdmin" | $_SESSION["permissions"] == "ServerAdmin") { ?>
    <div class="inputs">
        <form action="../scripts/add_user.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="name" placeholder="Name" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="permissions" title="permissionSelection" required>
                <option value="User" selected>User</option>
                <option value="Moderator">Moderator</option>
                <option value="ClassAdmin">ClassAdmin</option>
                <?php if ($_SESSION["permissions"] == "ServerAdmin") { ?>
                    <option value="ServerAdmin">ServerAdmin</option> <?php } ?>
            </select>
            <input type="text" name="groupID" placeholder="Group ID" required>
            <?php if ($_SESSION["permissions"] == "ServerAdmin") { ?><input type="number" name="classID"
                                                                            placeholder="Class ID" required><?php } ?>
            <button class="btn">&nbsp;Submit <span class="arrow">❯</span></button>
            <?php if ($_SESSION["addUser"] == "success") {
                echo "<div class='alert-box success'><span>success: </span>User added successfully.</div>";
                unset($_SESSION["addUser"]);
            } elseif ($_SESSION["addUser"] == "error") {
                echo "<div class='alert-box error'><span>error: </span>Equal username found.</div>";
                unset($_SESSION["addUser"]);
            } ?>
        </form>
    </div>
<?php } ?>
<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="../js/users.js"></script>

</body>
</html>