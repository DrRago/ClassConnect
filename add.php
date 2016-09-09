<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

<form method="post" action="#">
    <input name="classID" value="2" readonly>
    Name <input name="name" autofocus>
    <input name="password" value="12345" readonly>
    Group <input name="groupID" value="A">
    <input name="permissions" value="User">
    <button type="submit">Hi</button>
</form>

<?php
session_start();
error_reporting(1);

include "scripts/communicate.php";

if (isset($_POST["classID"])) {
    $classID = $_POST["classID"];
} else {
    $classID = $_SESSION["classID"];
}

$user = strtolower(substr($_POST["name"], 0, 1)) . "." . strtolower(explode(" ", $_POST["name"])[1]);

$result = getContent(
        array(
                "n" => $_POST["name"],
                "u" => $user,
                "pass" => $_POST["password"],
                "perm" => $_POST["permissions"],
                "g" => $_POST["groupID"],
                "c" => $classID
        ),
        "add_user.php"
);

if ($result == "Data Inserted") {
    echo "success";
} elseif ($result == "Failed") {
    echo "error";
}
?>

</body>
</html>