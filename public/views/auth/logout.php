<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location:login.php");
    exit();
}
session_unset();
session_destroy();
header('Location:login.php');
exit();
