<?php
session_start();
error_reporting(1);

include_once "../scripts/communicate.php";

$links = json_decode(getContent(array(), "get_patchnotes.php"));

if (isset($_SESSION['name']) | $_SESSION['login'] == 'success') {
    header('Location: timetable.php');
    exit;
}
?>
<html>
<head>
    <title>ClassConnect - Login</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/reset.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/index.min.css">


</head>
<body>
<form class="login" action="../scripts/login.php?js=false" method="post">
    <fieldset>
        <legend class="legend">Login</legend>
        <div class="input">
            <input class="user-in" type="text" name="username" placeholder="Username" autocomplete="off" required />
            <span><i class="fa fa-user"></i></span>
        </div>
        <div class="input">
            <input class="pw-in" type="password" name="password" placeholder="Password" required />
            <span><i class="fa fa-lock"></i></span>
        </div>
        <button type="submit" class="submit"><i class="fa fa-arrow-right" style="margin-top: -2px"></i></button>
    </fieldset>

    <div class="feedback">
        login successful <br />
        redirecting...
    </div>
    <div class="error">
        wrong username or password <br />
        try again
    </div>
</form>

<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>

<script src='../js/jquery-3.1.0.min.js'></script>
<script src="../js/index.min.js"></script>

</body>
</html>
