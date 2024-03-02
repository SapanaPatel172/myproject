<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../partials/head.html'; ?>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <?php foreach ($_SESSION['error'] as $msg) { ?>
            <h1>
                <?= $msg; ?>
            </h1>
        <?php } ?>
        <br>
        <input type="button" value="home" class="btn btn-primary" onclick="window.location.href='login.php'">
    </div>
</body>

</html>