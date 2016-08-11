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
    <title>Benutzer</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

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
<div class='userList'>
    <table>
        <tr>
            <th class="free_space"></th>
            <?php if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th class='id'><strong>ID</strong></th>";
            } ?>
            <th><strong>Name</strong></th>
            <?php if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th><strong>Benutzername</strong></th>";
            } ?>
            <th><strong>Email adresse</strong></th>
            <th><strong>Telefonnummer</strong></th>
            <th><strong>Rechte</strong></th>
            <th><strong>GruppenID</strong></th>
            <?php if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th><strong>KlassenID</strong></th>";
            } ?>
            <?php if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                echo "<th></th>";
            }
            echo "</tr>";
            $user_amount = count($output);
            for ($count = 0; $count < $user_amount; $count++) {
                if ($_SESSION["username"] == $output[$count]->username) {
                    echo "<tr class='me'>";
                } elseif ($_SESSION["changedUser"] == $output[$count]->id) {
                    unset($_SESSION["changedUser"]);
                    echo "<tr id='changed' class='changed'>";
                } else {
                    echo "<tr>";
                }
                echo "<td class='", $output[$count]->permissions, "'></td>";
                if ($permissions == "ServerAdmin" || $permissions == "ClassAdmin") {
                    echo "<td><input name='id' type='text' readonly style='width:", strlen($output[$count]->id) * 8, "px;' value='", $output[$count]->id, "'>";
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
                    echo "<td><button type='submit' onclick='window.location.href=\"edit.php?id=", $output[$count]->id, "\"' class='edit'></button></td>";
                } elseif ($permissions == "ClassAdmin") {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            ?>
    </table>
</div>

<?php if ($_SESSION["permissions"] == "ClassAdmin" | $_SESSION["permissions"] == "ServerAdmin") { ?>
    <div class="inputs">
        <form action="../scripts/add_user.php" method="post">
            <input type="text" name="username" placeholder="Benutzername" required>
            <input type="text" name="name" placeholder="Name" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <select name="permissions" title="permissionSelection" required>
                <option value="User" selected>User</option>
                <option value="Moderator">Moderator</option>
                <option value="ClassAdmin">ClassAdmin</option>
                <?php if ($_SESSION["permissions"] == "ServerAdmin") { ?>
                    <option value="ServerAdmin">ServerAdmin</option> <?php } ?>
            </select>
            <input type="text" name="groupID" placeholder="Gruppen ID" required>
            <?php if ($_SESSION["permissions"] == "ServerAdmin") { ?><input type="number" name="classID"
                                                                            placeholder="Klassen ID" required><?php } ?>
            <button class="btn">&nbsp;Submit <span class="arrow">❯</span></button>
            <?php if ($_SESSION["addUser"] == "success") {
                echo "<div class='alert-box success'><span>erfolg: </span>Benutzer erfolgreich hinzugefügt.</div>";
                unset($_SESSION["addUser"]);
            } elseif ($_SESSION["addUser"] == "error") {
                echo "<div class='alert-box error'><span>fehler: </span>Gleichen Benutzernamen gefunden.</div>";
                unset($_SESSION["addUser"]);
            } ?>
        </form>
    </div>
<?php } ?>
<script type="text/javascript">
    var ele = document.getElementById("changed");
    window.scrollTo(ele.offsetLeft, ele.offsetTop);
</script>

</body>
</html>