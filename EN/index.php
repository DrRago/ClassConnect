<?php
session_start();
error_reporting(1);

include_once "../scripts/communicate.php";

$links = json_decode(getContent(array(), "get_app"));

if (isset($_SESSION['name']) | $_SESSION['login'] == 'success') {
    header('Location: timetable.php');
    exit;
}
?>
<html>
<head>
    <title>ClassConnect - Login</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/index.css">


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
        <button type="submit" class="submit" style="margin-right: 70px;"><i class="fa fa-arrow-right" style="margin-top: -2px"></i></button>
        <button type="button" class="download" onclick="download('<?php echo $links[count($links) - 1]->link?>')" style="margin-left: 60px;margin-top: -45px"><i class="fa fa-download" style="margin-top: -2px"></i></button>
    </fieldset>
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

<script src='../js/jquery-3.1.0.js'></script>
<script src="../js/jquery.download.js"></script>
<script src="../js/index.js"></script>

</body>
</html>
