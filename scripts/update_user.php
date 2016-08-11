<?php
session_start();
error_reporting(1);

include "communicate.php";
if (md5($_POST["old_password"]) == $_SESSION["password"]) {

    if ($_POST["new_password_1"] == $_POST["new_password_2"]) {
        if ($_POST["new_password_1"] == "") {
            $new_pw = $_POST["old_password"];
        } else {
            $new_pw = $_POST["new_password_1"];
        }

        $result = getContent(
            array(
                'id' => $_SESSION["id"],
                'username' => $_SESSION["username"],
                'name' => $_POST["name"],
                'password_new' => $new_pw,
                'password_old' => md5($_POST["old_password"]),
                'phone' => $_POST["phone"],
                'email' => $_POST['email'],
                'group' => $_POST['groupID']
            ),
            "update_user.php"
        );

        $_SESSION["editUser"] = "success";

        $_SESSION["name"] = $_POST["name"];
        $_SESSION["password"] = md5($new_pw);
        $_SESSION["email"] = $_POST['email'];
        $_SESSION["phone"] = $_POST["phone"];
        $_SESSION["groupID"] = $_POST["groupID"];
    } else {
        $_SESSION["editUser"] = "matchError";
    }
} else {
    $_SESSION["editUser"] = "wrong";
}

header("Location: ../" . $_SESSION["language"] . "/profile.php");