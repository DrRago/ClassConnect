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

    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>

    <script type="text/javascript" src="../js/jquery.rotate.1-1.js"></script>

    <link rel="stylesheet" href="../css/reset.css">

    <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="../css/bootrstrap.css">

    <link rel="stylesheet" href="../css/index.css">


</head>
<body>
<form class="login" action="../scripts/login.php?js=false" method="post">

    <fieldset>

        <legend class="legend">Login</legend>

        <div class="input">
            <input class="user-in" type="text" name="username" placeholder="Username" autocomplete="off" required />
            <span><i class="fa fa-envelope-o"></i></span>
        </div>

        <div class="input">
            <input class="pw-in" type="password" name="password" placeholder="Password" required />
            <span><i class="fa fa-lock"></i></span>
        </div>

        <button type="submit" class="submit"><i class="fa fa-long-arrow-right"></i></button>

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

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="../js/index.js"></script>

</body>

</html>
