<?php
session_start();
error_reporting(1);

$data["k"] = "QVBJV0Vic2l0ZSBza2lhZG5zZ";
$url = 'http://api.tandashi.de/api/get_app';
// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
        'timeout' => 1
    ),
);
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if (isset($http_response_header)) {
    include_once "../scripts/communicate.php";
    $links = json_decode(getContent(array(), "get_app"));
}
?>
<html>
<head>
    <title>ClassConnect - Login</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../css/index.css">


</head>
<body>

<?php
if (!isset($http_response_header)) {?>
    <form class="login" action="../scripts/login.php?js=false" method="post">
        <fieldset>
            <legend class="legend disabled">Login</legend>
            <div class="input">
                <input class="user-in" type="text" name="username" placeholder="Username" autocomplete="off" required disabled/>
                <span><i class="fa fa-user"></i></span>
            </div>
            <div class="input">
                <input class="pw-in" type="password" name="password" placeholder="Password" required disabled/>
                <span><i class="fa fa-lock"></i></span>
            </div>
            <button type="submit" class="submit" style="margin-right: 70px;" disabled><i class="fa fa-arrow-right" style="margin-top: -2px"></i></button>
            <button type="button" class="download" onclick="download('<?= $links[count($links) - 1]->link?>')" style="margin-left: 60px;margin-top: -45px"><i class="fa fa-download" style="margin-top: -2px"></i></button>
        </fieldset>
        <div class="error">
            wrong username or password <br />
            try again
        </div>

        <div class="interror">
            internal server error <br />
            please try again later
        </div>
    </form>

    <div class="container alert alert-danger api_error" role="alert">
        <strong>Attention!</strong>
        The login has been disabled during an issue on our server. This has been reported. Please try again later.
    </div>
    <?php
} else {
    ?>
    <form class="login" action="../scripts/login.php?js=false" method="post">
        <fieldset>
            <legend class="legend">Login</legend>
            <div class="input">
                <input class="user-in" type="text" name="username" placeholder="Username" autocomplete="off" required/>
                <span><i class="fa fa-user"></i></span>
            </div>
            <div class="input">
                <input class="pw-in" type="password" name="password" placeholder="Password" required/>
                <span><i class="fa fa-lock"></i></span>
            </div>
            <button type="submit" class="submit" style="margin-right: 70px;"><i class="fa fa-arrow-right"
                                                                                style="margin-top: -2px"></i>
            </button>
            <button type="button" class="download" onclick="download('<?= $links[count($links) - 1]->link ?>')"
                    style="margin-left: 60px;margin-top: -45px"><i class="fa fa-download" style="margin-top: -2px"></i>
            </button>
        </fieldset>
        <div class="error">
            wrong username or password <br/>
            try again
        </div>

        <div class="interror">
            internal server error <br/>
            please try again later
        </div>
    </form>

    <?php
}
?>

<noscript>
    <div class="container alert alert-danger" role="alert">
        <strong>Warning!</strong>
        For full functionality of this site it is necessary to enable JavaScript. Here are the <a class="alert-link" href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>.</div>
</noscript>

<script src='../js/jquery-3.1.1.js'></script>
<script src="../js/jquery.download.js"></script>
<script src="../js/index.js"></script>

<script>
    window.onload = function() {
        $(".user-in").focus();
    };
</script>

</body>
</html>
