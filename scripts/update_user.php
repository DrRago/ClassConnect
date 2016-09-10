<?php
session_start();
error_reporting(1);

include "communicate.php";
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
            'p_new' => md5($new_pw),
            'p_type_new' => 'encrypted',
            'p_old' => md5($_POST["old_password"]),
            'p_type_old' => 'encrypted',
            'phone' => $_POST["phone"],
            'email' => $_POST['email'],
            'gid' => $_POST['groupID']
        ),
        "update_user"
    );

    switch ($result) {
        case 0:
            $_SESSION["editUser"] = "wrong";
            break;
        case 1:
            $_SESSION["editUser"] = "success";

            $_SESSION["name"] = $_POST["name"];
            $_SESSION["email"] = $_POST['email'];
            $_SESSION["phone"] = $_POST["phone"];
            $_SESSION["groupID"] = $_POST["groupID"];
            break;
    }
} else {
    $_SESSION["editUser"] = "matchError";
}

header("Location: ../" . $_SESSION["language"] . "/profile.php");