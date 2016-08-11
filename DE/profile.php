<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php"; ?>
<html>
<head>
    <title>Profil bearbeiten</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/input_container.css">

</head>
<?php require "navigator.php" ?>
<body>
<div class="filler"></div>
<div class="inputs">
    <form class="form" method="post" action="../scripts/update_user.php">
        <div class="input"><label class="username">Benutzername:<a class="IsRequired">*</a></label><input name="username"
                                                                                                      type="text"
                                                                                                      value="<?php echo $_SESSION["username"] ?>"
                                                                                                      placeholder="Benutzername"
                                                                                                      readonly><br>
        </div>
        <div class="input"><label class="name">Name:<a class="IsRequired">*</a></label><input name="name" type="text"
                                                                                              value="<?php echo $_SESSION["name"] ?>"
                                                                                              placeholder="Name"
                                                                                              required><br></div>
        <div class="input"><label class="phone">Telefonnummer:</label><input name="phone" type="tel"
                                                                     value="<?php echo $_SESSION["phone"] ?>"
                                                                     placeholder="Telefonnummer"><br></div>
        <div class="input"><label class="email">Email adresse:</label><input name="email" type="email"
                                                                             value="<?php echo $_SESSION["email"] ?>"
                                                                             placeholder="Email adresse"><br></div>
        <div class="input"><label class="group">Gruppe:<a class="IsRequired">*</a></label><input name="groupID"
                                                                                                type="text"
                                                                                                value="<?php echo $_SESSION["groupID"] ?>"
                                                                                                placeholder="Gruppen ID"
                                                                                                required><br></div>
        <div class="input"><label class="new_password_1">Neues Passwort:</label><input name="new_password_1"
                                                                                     type="password"
                                                                                     placeholder="Neues Passwort"><br>
        </div>
        <div class="input"><label class="new_password_2">Passwort wiederholen:</label><input name="new_password_2"
                                                                                        type="password"
                                                                                        placeholder="Passwort wiederholen"><br>
        </div>
        <div class="input"><label class="old_password">Aktuelles Passwort:<a class="IsRequired">*</a></label><input
                name="old_password" type="password" placeholder="Aktuelles Passwort" required><br></div>
        <button class="btn">&nbsp;Ändern <span class="arrow">❯</span></button>
        <?php if ($_SESSION["editUser"] == "success") {
            echo "<div class='alert-box success'><span>erfolg: </span>Änderungen erfolgreich gespeichert.</div>";
            unset($_SESSION["editUser"]);
        } elseif ($_SESSION["editUser"] == "wrong") {
            echo "<div class='alert-box error'><span>fehler: </span>Falsches Passwort.</div>";
            unset($_SESSION["editUser"]);
        } elseif ($_SESSION["editUser"] == "matchError") {
            echo "<div class='alert-box error'><span>fehler: </span>Passwwörter stimmen nicht überein.</div>";
            unset($_SESSION["editUser"]);
        }

        ?>
    </form>
</div>
</body>
</html>