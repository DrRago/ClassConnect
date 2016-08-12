<?php
session_start();

switch (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)) {
    case "de";
        header("Location: DE");
        $_SESSION["language"] = "DE";
        break;
    default;
        header("Location: EN");
        $_SESSION["language"] = "EN";
}