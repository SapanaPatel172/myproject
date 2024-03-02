<?php
session_start();
include '../../models/database.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';
include '../partials/validator.class.php';
$_SESSION['path'] = "dashbord";
$_SESSION['error'] = [];
date_default_timezone_set("Asia/Calcutta");
if (isset($_REQUEST['token'])) {
  $token = $_REQUEST['token'];
  $validator = new Validator();
  //check token format validation(length 32,a to f small character and 0 to 9 digits)
  if ($validator->validattoken($token)) {
    $tablename = "users";
    $wherevalue = ['token' => $token];

    //select data where token is match and get token_timestamp
    $obj = new database();
    $users_result = $obj->selectdata($tablename, $wherevalue);
    if ($users_result->num_rows > 0) {
      $row = $users_result->fetch_assoc();
      $time = $row['token_timestamp'];
      $id = $row['id'];

      //check token time using istokenexpired 
      $get_token_time = $validator->isTokenExpired($time);

      //when time is not expire then redirect to dashbord
      if ($get_token_time) {
        $date = time();
        $wherevalue1 = ['id' => $id];
        $data = ['varify' => date('Y-m-d H:i:s', $date)];

        // user varification time set
        $varify = $obj->updatedata($tablename, $data, $wherevalue1);
        header("Location:dashbord.php");
      } else {
        $_SESSION['error'][] = "token time is expaire";
        //when token time is expire then show error page 
        header('location:error_page.php');
        exit();
      }
    } else {
      //when token is not match then back to verification.php and generate new token
      echo "<script>window.location.href = 'verification.php';</script>";
      exit();
    }
  } else {
    //when token format is wrong then redirect to error_page.php 
    $_SESSION['error'][] = "Sorry, token format is wrong";
    header('location:error_page.php');
    exit();
  }
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include '../partials/head.html'; ?>
</head>

<body class="wel">
  <?php include '../partials/general.php'; ?>
</body>

</html>