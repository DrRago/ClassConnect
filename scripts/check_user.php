<?php
include "communicate.php";

if (isset($_SESSION["username"]) & isset($_SESSION["password"])) {

    $result = getContent(
        array(
            'uid' => $_SESSION['id']
        ),
        "get_user"
    );
    $result = json_decode($result);

    if ($_SESSION['id'] == $result{0}->id &
        $_SESSION['name'] == $result{0}->name &
        $_SESSION['username'] == $result{0}->username &
        $_SESSION['password'] == $result{0}->password &
        $_SESSION['email'] == $result{0}->email &
        $_SESSION['phone'] == $result{0}->phone &
        $_SESSION['permissions'] == $result{0}->permissions &
        $_SESSION['groupID'] == $result{0}->groupID &
        $_SESSION['classID'] == $result{0}->classID
    ) {
        $_SESSION['validation'] = true;
    } else {
        $_SESSION = array();
        $_SESSION["login"] = "error";
        header("Location: ../index.php");
    }
} else {
    $_SESSION = array();
    header("Location: ../index.php");
}