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
        <title>User</title>

        <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

        <link rel="stylesheet" href="../css/navigation.css">
        <link rel="stylesheet" href="../css/style.css">
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
    <div class="form-inline">
        <form class="form" method="post" action="../scripts/edit_user.php">
            <?php
            if (!is_numeric($_GET['id'])) {
                echo "<div class='alert alert-danger'><strong>error: </strong>The ID ", $_GET['id'], " is no number</div>";
            } else {
                if ($result == null) {
                    echo "<div class='alert alert-danger'><strong>error: </strong>No user with the ID ", $_GET['id'], " found</div>";
                } else { ?>
                    <table>
                        <tr>
                            <td><label class="id">User ID:<a class="IsRequired">*</a></label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-list-ol"></i>
                                    </span>
                                    <input class="form-control" name="id" type="number" value="<?php echo $result{0}->id ?>" placeholder="Username" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="username">Username:<a class="IsRequired">*</a></label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                    </span>
                                    <input class="form-control" name="username" type="text" value="<?php echo $result{0}->username ?>" placeholder="Username" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="name">Name:<a class="IsRequired">*</a></label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-male"></i>
                                    </span>
                                    <input class="form-control" name="name" type="text" value="<?php echo $result{0}->name ?>" placeholder="Name" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="phone">Phone:</label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                    <input class="form-control" name="phone" type="tel" value="<?php echo $result{0}->phone ?>" placeholder="Phone">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="email">Email address:</label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa  fa-at"></i>
                                    </span>
                                    <input class="form-control" name="email" type="email" value="<?php echo $result{0}->email ?>" placeholder="Email">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="group">Group:<a class="IsRequired">*</a></label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-group"></i>
                                    </span>
                                    <input class="form-control" name="groupID" type="text" value="<?php echo $result{0}->groupID ?>" placeholder="GroupID" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="classID">Class ID:<a class="IsRequired">*</a></label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-graduation-cap"></i>
                                    </span>
                                    <input class="form-control" name="classID" type="number" value="<?php echo $result{0}->classID ?>" placeholder="ClassID" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label class="permissions">Permissions:<a class="IsRequired">*</a></label></td>
                            <td><div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <select class="form-control" name="permissions" title="permissionSelection" style="width: 165px" required>
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
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="btn-group">
                        <button type="button"
                                onclick="window.location.href='../scripts/reset_password.php<?php $_SESSION["resetPassword"] = $_GET["id"] ?>'"
                                class="right btn btn-default">&nbsp;Reset Password <span class="fa fa-lock"></span></button>
                        <button type="submit" class="left btn btn-default">&nbsp;Submit <span class="fa fa-paper-plane"> </span></button>
                    </div>
                    <?php
                    if ($_SESSION["resetStatus"] == "success") {
                        echo "<div style='margin-top: 50px;margin-bottom: -30px' class='alert alert-success'><strong>success: </strong>Password reset successful! New password is ", $_SESSION["newPassword"], ".</div>";
                        unset($_SESSION["resetStatus"]);
                        unset($_SESSION["newPassword"]);
                    } elseif ($_SESSION["resetStatus"] == "error") {
                        echo "<div style='margin-top: 50px;margin-bottom: -30px' class='alert alert-danger'><strong>error: </st>Password not reset!</div>";
                        unset($_SESSION["resetStatus"]);
                    }
                }
            } ?>
        </form>
    </div>
    </body>
    </html>

<?php } ?>