<?php

//TODO 16.10.2016 add ticket view for non-ServerAdmins

error_reporting(1);
session_start();
require_once "../scripts/communicate.php";

if ($_SESSION["permissions"] != "ServerAdmin") {

    echo "<meta http-equiv='refresh' content='3; URL=../scripts/logout.php'>";
    echo "Sorry Brudah, du kommst hier net rein";
} else {
    $result = json_decode(getContent(array('id' => $_GET['id']), "get_ticket")); ?>
    <html>
    <head>
        <title>Ticket <?php echo $_GET['id'] ?></title>

        <link rel='shortcut icon' type='image/x-icon' href='../img/favicon.ico'>

        <link rel="stylesheet" href="../css/bootstrap.css">
        <link rel="stylesheet" href="../css/font-awesome.css">

        <meta name="viewport" content="width=device-width,initial-scale=1">
        <script src="../js/responsive-nav.js"></script>

        <script src="../js/autosize.js"></script>

        <link rel="stylesheet" href="../css/navigation.css">
        <link rel="stylesheet" href="../css/formula.css">
        <link rel="stylesheet" href="../css/input_container.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
    <?php require "navigator.php"; ?>
    <div class="filler">
    </div>
    <div class="form-inline">
        <?php
        if (!is_numeric($_GET['id'])) {
            echo "<div class='alert alert-danger'><strong>error: </strong>The ID $_GET[id] is no number</div>";
        } else {
            if ($result == null) {
                echo "<div class='alert alert-danger'><strong>error: </strong>No ticket with the ID $_GET[id] found</div>";
            } else { ?>
                <form>
                    <table>
                        <tr>
                            <td><label for="id">Ticket ID:</label></td>
                            <td>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-list-ol"></i>
                                </span>
                                    <input id="id" class="form-control" name="id" type="text"
                                           value="<?= $result{0}->id ?>" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="creatorID">Creator ID:</label></td>
                            <td>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-list-ol"></i>
                                </span>
                                    <input id="creatorID" class="form-control" type="text"
                                           value="<?= $result{0}->creatorID ?>" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="creatorName">Creator Name:</label></td>
                            <td>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-male"></i>
                                </span>
                                    <input id="creatorName" class="form-control" name="name" type="text"
                                           value="<?= $result{0}->creatorName ?>" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="creatorEmail">Creator Email:</label></td>
                            <td>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-at"></i>
                                </span>
                                    <input id="creatorEmail" class="form-control" type="text"
                                           value="<?= $result{0}->creatorEmail ?>" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="reason">Topic:</label></td>
                            <td>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-tag"></i>
                                </span>
                                    <input id="reason" class="form-control" type="text"
                                           value="<?= $result{0}->reason ?>" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="message">Message:</label></td>
                            <td>
                                <div class="input-group textarea">
                                <span class="input-group-addon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                    <textarea id="message" class="form-control"
                                              readonly><?= $result{0}->content ?></textarea>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
                <?php
            }
        }
        ?>
    </div>

    <script src="../js/fastclick.js"></script>
    <script src="../js/scroll.js"></script>
    <script src="../js/fixed-responsive-nav.js"></script>

    <script>
        autosize(document.getElementById('message'));
    </script>

    </body>
    </html>
    <?php
} ?>