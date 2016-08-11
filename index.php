<?php
session_set_cookie_params(31536000);

session_start();

substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)) {
    case "de";
        header("Location: DE");
        $_SESSION["language"] = "DE";
        break;
    default;
        header("Location: EN");
        $_SESSION["language"] = "EN";
}