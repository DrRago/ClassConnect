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
    <title>ClassConnect - Anmelden</title>

    <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

    <link rel="stylesheet" href="../css/index.css">

</head>
<body>

<div class='login'>
    <img class='title_pic' src='../img/class_connect_title.png'>
    <?php if ($_SESSION['login'] == 'wrong') { ?>
        <h4 class='error'>Falsche Eingabe, versuchen Sie es erneut</h4>
    <?php }
    if ($_SESSION['login'] == 'error') { ?>
        <h4 class='error'>Ein Fehler ist aufgetreten, bitte loggen Sie sich neu ein</h4>
    <?php } ?>
    <form method='post' action='../scripts/login.php'>
        <input type='text' class='user_in' name='username' placeholder='Benutzername' required='required' autofocus
               autocomplete='off'/>
        <input type='password' class='password_in' name='password' placeholder='Passwort' required='required'/>
        <button type='submit' class='btn login_btn'>Anmelden</button>
        <a href="<?php echo $links[count($links) - 1]->link ?>">
            <button type="button" class='btn app_btn'><?php echo "App " . $links[count($links) - 1]->content ?></button>
        </a>
    </form>
</div>
<?php
$_SESSION['login'] = '';
?>
</body>

</html>
