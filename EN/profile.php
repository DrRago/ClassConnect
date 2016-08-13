<?php
session_start();
error_reporting(1);
require "../scripts/check_user.php"; ?>
<html>
<head>
    <title>User</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootrstrap.css">

    <link rel="stylesheet" href="../css/navigation.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/formula.css">
    <link rel="stylesheet" href="../css/input_container.css">

</head>
<?php require "navigator.php" ?>
<body>
<div class="filler"></div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>
<div class="inputs">
    <form class="form" method="post" action="../scripts/update_user.php">
        <div class="input"><label class="username">Username:<a class="IsRequired">*</a></label><input name="username"
                                                                                                      type="text"
                                                                                                      value="<?php echo $_SESSION["username"] ?>"
                                                                                                      placeholder="Username"
                                                                                                      <?php if ($_SESSION["permissions"] == "User" || $_SESSION["permissions"] == "Moderator") { echo "readonly";}?>><br>
        </div>
        <div class="input"><label class="name">Name:<a class="IsRequired">*</a></label><input name="name" type="text"
                                                                                              value="<?php echo $_SESSION["name"] ?>"
                                                                                              placeholder="Name"
                                                                                              required><br></div>
        <div class="input"><label class="phone">Phone:</label><input name="phone" type="tel"
                                                                     value="<?php echo $_SESSION["phone"] ?>"
                                                                     placeholder="Phone"><br></div>
        <div class="input"><label class="email">Email address:</label><input name="email" type="email"
                                                                             value="<?php echo $_SESSION["email"] ?>"
                                                                             placeholder="Email"><br></div>
        <div class="input"><label class="group">Group:<a class="IsRequired">*</a></label><input name="groupID"
                                                                                                type="text"
                                                                                                value="<?php echo $_SESSION["groupID"] ?>"
                                                                                                placeholder="GroupID"
                                                                                                required><br></div>
        <div class="input"><label class="new_password_1">New Password:</label><input name="new_password_1"
                                                                                     type="password"
                                                                                     placeholder="New Password"><br>
        </div>
        <div class="input"><label class="new_password_2">Repeat Password:</label><input name="new_password_2"
                                                                                        type="password"
                                                                                        placeholder="Repeat Password"><br>
        </div>
        <div class="input"><label class="old_password">Old Password:<a class="IsRequired">*</a></label><input
                name="old_password" type="password" placeholder="Current Password" required><br></div>
        <button class="btn">&nbsp;Submit <span class="arrow">❯</span></button>
        <?php if ($_SESSION["editUser"] == "success") {
            echo "<div class='alert-box success'><span>success: </span>Change was successful.</div>";
            unset($_SESSION["editUser"]);
        } elseif ($_SESSION["editUser"] == "wrong") {
            echo "<div class='alert-box error'><span>error: </span>Wrong password.</div>";
            unset($_SESSION["editUser"]);
        } elseif ($_SESSION["editUser"] == "matchError") {
            echo "<div class='alert-box error'><span>error: </span>Passwords don't match.</div>";
            unset($_SESSION["editUser"]);
        }

        ?>
    </form>
</div>
</body>
</html>