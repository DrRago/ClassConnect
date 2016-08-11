<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php";
include_once "../scripts/communicate.php";

if ($_SESSION["permissions"] == "Moderator" || $_SESSION["permissions"] == "User") {

    echo "<meta http-equiv='refresh' content='3; URL=../scripts/logout.php'>";
    echo "Sorry Brudah, du kommst hier net rein";
} else {
    if ($_GET["id"] == $_SESSION["id"]) {
        header("Location: profile.php");
    }

    $result = getContent(
        array(
            'uid' => $_GET["id"]
        ),
        "get_user.php"
    );

    $result = json_decode($result);
    ?>
    <html>
    <head>
        <title>Benutzer bearbeiten</title>

        <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>


        <link rel="stylesheet" href="../css/navigation.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/edit.css">
        <link rel="stylesheet" href="../css/formula.css">
        <link rel="stylesheet" href="../css/input_container.css">

    </head>
    <body>
    <?php require "navigator.php" ?>
    <div class="filler"></div>
    <div class="inputs">
        <form class="form" method="post" action="../scripts/edit_user.php">
            <?php
            if (!is_numeric($_GET['id'])) {
                echo "<div class='alert-box error userError'><span>Fehler: </span>Die ID ", $_GET['id'], " ist keine Zahl</div>";
            } else {
                if ($result == null) {
                    echo "<div class='alert-box error userError'><span>Fehler: </span>Es existiert kein Benutzer mit der ID ", $_GET['id'], "</div>";
                } else { ?>
                    <div class="input"><label class="id">Benutzer ID:<a class="IsRequired">*</a></label><input class="id"
                                                                                                           name="id"
                                                                                                           type="number"
                                                                                                           value="<?php echo $result{0}->id ?>"
                                                                                                           placeholder="Benutzer ID"
                                                                                                           readonly><br>
                    </div>
                    <div class="input"><label class="username">Benutzername:<a class="IsRequired">*</a></label><input
                            class="username" name="username" type="text" value="<?php echo $result{0}->username ?>"
                            placeholder="Benutzername" readonly><br></div>
                    <div class="input"><label class="name">Name:<a class="IsRequired">*</a></label><input name="name"
                                                                                                          type="text"
                                                                                                          value="<?php echo $result{0}->name ?>"
                                                                                                          placeholder="Name"
                                                                                                          required><br>
                    </div>
                    <div class="input"><label class="phone">Telefonnummer:</label><input name="phone" type="tel"
                                                                                 value="<?php echo $result{0}->phone ?>"
                                                                                 placeholder="Telefonnummer"><br></div>
                    <div class="input"><label class="email">Email adresse:</label><input name="email" type="email"
                                                                                         value="<?php echo $result{0}->email ?>"
                                                                                         placeholder="Email adresse"><br></div>
                    <div class="input"><label class="group">Gruppe:<a class="IsRequired">*</a></label><input
                            name="groupID" type="text" value="<?php echo $result{0}->groupID ?>" placeholder="Gruppen ID"
                            required><br></div>
                    <div class="input"><label class="classID">Klassen ID:<a class="IsRequired">*</a></label><input
                            name="classID" type="number" value="<?php echo $result{0}->classID ?>" placeholder="Klassen ID"
                            required><br></div>
                    <div class="input"><label class="permissions">Rechte:<a class="IsRequired">*</a></label>
                        <select name="permissions" title="permissionSelection" required>
                            <option value="User" <?php if ($result{0}->permissions == "User") {
                                echo "selected='selected'";
                            } ?>>User
                            </option>
                            <option value="Moderator" <?php if ($result{0}->permissions == "Moderator") {
                                echo "selected='selected'";
                            } ?>>Moderator
                            </option>
                            <option value="ClassAdmin" <?php if ($result{0}->permissions == "ClassAdmin") {
                                echo "selected='selected'";
                            } ?>>ClassAdmin
                            </option>
                            <?php if ($_SESSION["permissions"] == "ServerAdmin" | $result{0}->permissions == "ServerAdmin") { ?>
                                <option value="ServerAdmin" <?php if ($result{0}->permissions == "ServerAdmin") {
                                    echo "selected='selected'";
                                } ?>>ServerAdmin</option> <?php } ?>
                        </select><br></div>
                    <button type="submit" class="btn">&nbsp;Übernehmen <span class="arrow">❯</span></button>
                    <div class="pw">
                        <button type="button"
                                onclick="window.location.href='../scripts/reset_password.php<?php $_SESSION["resetPassword"] = $_GET["id"] ?>'"
                                class="btn btn_pw">&nbsp;Neues Passwort<span class="arrow">❯</span></button>
                    </div>
                    <?php
                    if ($_SESSION["resetStatus"] == "success") {
                        echo "<div style='margin-top: 50px;margin-bottom: -30px' class='alert-box success'><span>Erfolg: </span>Passwort erfolgreich zurückgesetzt! Das neue Passwort ist ", $_SESSION["newPassword"], ".</div>";
                        unset($_SESSION["resetStatus"]);
                        unset($_SESSION["newPassword"]);
                    } elseif ($_SESSION["resetStatus"] == "error") {
                        echo "<div style='margin-top: 50px;margin-bottom: -30px' class='alert-box error'><span>Fehler: </span>Passwort nicht zurückgesetzt!</div>";
                        unset($_SESSION["resetStatus"]);
                    }
                }
            } ?>
        </form>
    </div>
    </body>
    </html>

<?php } ?>