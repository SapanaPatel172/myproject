<?php
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];
    $wherevalue = ['email' => $email];
    $tablename = "users";
    $obj = new database();
    $stmt_result = $obj->selectdata($tablename, $wherevalue);
    if ($stmt_result->num_rows > 0) {
        $row = $stmt_result->fetch_assoc();
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $img = $row['avatarimg'];
        $password = $row['password'];
    }
} else {
    //when user not login then all page redirect to index.php 
    header("Location:../auth/login.php");
    exit();
}
