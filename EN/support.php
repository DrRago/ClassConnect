<?php session_start();
error_reporting(1);
require "../scripts/check_user.php";
?>
<html>
<head>
    <title>Support</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/bootstrap.css">

    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/navigation.css">

</head>

<body>
<?php require "navigator.php" ?>
<div class="filler"></div>
<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>

<div class="container alert alert-info" role="alert">
    <strong>Information</strong>
    This site is currently disabled. Please write an E-Mail to one of the ServerAdmins
</div>

</body>
</html>