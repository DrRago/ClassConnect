<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";
$permissions = $_SESSION['permissions'];

$output = json_decode(getContent(array(), "get_every_user"));
if ($permissions != 'ServerAdmin') {
    $temp = array();
    foreach ($output as  $object) {
        if ($object->classID == $_SESSION["classID"] || $object->permissions == "ServerAdmin") {
            array_push($temp, $object);
        }
    }
    $output = $temp;
}
?>
<html>
<head>
    <title>Users</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">

    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="../js/responsive-nav.js"></script>

    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/users.css">
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
    <table id="tbl">
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
                    echo "<td><button onclick='window.location.href=\"edit.php?id=", $output[$count]->id, "\"' class='fa fa-pencil'></button></td>";
                } elseif ($permissions == "ClassAdmin") {
                    echo "<td></td>";
                }
                if ($permissions == "ServerAdmin") {
                    echo "<td><button content='", $output[$count]->id, "' onclick='deleteUser(this,\"", $_SESSION["sessionID"], "\")' class='fa fa-trash'></button></td>";
                }
                echo "</tr>";
            }
            ?>
    </table>
</div>

<?php if ($_SESSION["permissions"] == "ClassAdmin" | $_SESSION["permissions"] == "ServerAdmin") { ?>
    <div class="form-inline">
        <form action="../scripts/add_user.php" method="post">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-male"></i>
                </span>
                <input type="text" class="form-control" name="name" placeholder="Name" required>
            </div>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </span>
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-key"></i>
                </span>
                <select name="permissions" class="form-control select" title="permissionSelection" required>
                    <option value="User" selected>User</option>
                    <option value="Moderator">Moderator</option>
                    <option value="ClassAdmin">ClassAdmin</option>
                    <?php if ($_SESSION["permissions"] == "ServerAdmin") { ?>
                        <option value="ServerAdmin">ServerAdmin</option> <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-users"></i>
                </span>
                <input type="text" class="form-control" name="groupID" placeholder="Group ID" required>
            </div>
            <?php if ($_SESSION["permissions"] == "ServerAdmin") { ?>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-graduation-cap"></i>
                    </span>
                    <input type="number" class="form-control" name="classID" placeholder="Class ID" required>
                </div>
            <?php } ?>

            <button class="btn btn-default">&nbsp;Submit <span class="fa fa-paper-plane"></span></button>
            <?php if ($_SESSION["addUser"] == "success") {
                echo "<div class='alert alert-success'><strong>success: </strong>User added successfully.</div>";
                unset($_SESSION["addUser"]);
            } elseif ($_SESSION["addUser"] == "error") {
                echo "<div class='alert alert-danger'><strong>error: </strong>Equal username found.</div>";
                unset($_SESSION["addUser"]);
            } ?>
        </form>
    </div>
<?php } ?>
<script type="text/javascript">
    var ele = document.getElementsByClassName("changed")[0];
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

<script src="../js/fastclick.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/fixed-responsive-nav.js"></script>

<script src='../js/jquery-3.1.0.js'></script>
<script src="../js/stacktable.js"></script>

<script src="../js/users.js"></script>

</body>
</html>