<?php
error_reporting(1);
require "../scripts/check_user.php";?>
<html>
<head>
    <title>User</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/navigation.min.css">
    <link rel="stylesheet" href="../css/style.min.css">
    <link rel="stylesheet" href="../css/formula.min.css">
    <link rel="stylesheet" href="../css/input_container.min.css">

</head>
<?php require "navigator.php" ?>
<body>
<div class="filler"></div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>
<div class="form-inline">
    <form class="form" method="post" action="../scripts/update_user.php">
        <table>
            <tr>
                <td><label class="username">Username:<a class="IsRequired">*</a></label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input class="form-control" name="username" type="text" value="<?php echo $_SESSION["username"] ?>" placeholder="Username" readonly>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label class="name">Name:<a class="IsRequired">*</a></label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-male"></i>
                        </span>
                        <input class="form-control" name="name" type="text" value="<?php echo $_SESSION["name"] ?>" placeholder="Name" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label class="phone">Phone:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </span>
                        <input class="form-control" name="phone" type="tel" value="<?php echo $_SESSION["phone"] ?>" placeholder="Phone">
                    </div>
                </td>
            </tr>
            <tr>
                <td><label class="email">Email address:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-at"></i>
                        </span>
                        <input class="form-control" name="email" type="email" value="<?php echo $_SESSION["email"] ?>" placeholder="Email">
                    </div>
                </td>
            </tr>
            <tr>
                <td><label class="group">Group:<a class="IsRequired">*</a></label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-users"></i>
                        </span>
                        <input class="form-control" name="groupID" type="text" value="<?php echo $_SESSION["groupID"] ?>" placeholder="GroupID" required>
                    </div>
                </td>
            </tr>
            <tr>
                <td><label class="new_password_1">New Password:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input class="form-control" name="new_password_1" type="password" placeholder="New Password">
                    </div>
                </td>
            </tr>
            <tr>
                <td><label class="new_password_2">New Password:</label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <input class="form-control" name="new_password_2" type="password" placeholder="Repeat Password">
                    </div>
                </td>
            </tr>
            <tr>
                <td><label class="old_password">Old Password:<a class="IsRequired">*</a></label></td>
                <td><div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock"></i>
                        </span>
                        <input class="form-control" name="old_password" type="password" placeholder="Current Password" required>
                    </div>
                </td>
            </tr>
            <?php if ($_SESSION["editUser"] == "success") {
                echo "<div class='alert alert-success'><strong>success: </strong>Change was successful.</div>";
                unset($_SESSION["editUser"]);
            } elseif ($_SESSION["editUser"] == "wrong") {
                echo "<div class='alert alert-danger'><strong>error: </strong>Wrong password.</div>";
                unset($_SESSION["editUser"]);
            } elseif ($_SESSION["editUser"] == "matchError") {
                echo "<div class='alert alert-danger'><strong>error: </strong>Passwords don't match.</div>";
                unset($_SESSION["editUser"]);
            }

            ?>
        </table>
        <button class="btn btn-default">&nbsp;Submit <span class="fa fa-paper-plane"></span></button>
    </form>
</div>
</body>
</html>