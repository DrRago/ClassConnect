<?php
if ($_SESSION["sessionID"] != $_POST["validation"]) {
    exit();
}