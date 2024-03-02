<?php
//no need
session_start();
include '../partials/validator.class.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';
$_SESSION['error'] = "";
$_SESSION['success'] = [];

if (isset($_REQUEST['submit'])) {
    //get id from url show_permissions.php file
    $validator = new Validator();
    //check permission id is set or not
    if ($validator->validatisset('id', 'id')) {

        //check permission id is empty or not
        if ($validator->validatempty('id', 'id')) {

            $per_id = $_REQUEST['id'];
            $per_name = htmlspecialchars($_REQUEST['permission_name'], ENT_QUOTES, 'UTF-8');
            //   echo "<script>alert('$per_name')</script>";

            //update permissions
            $obj = new database();
            $tablename1 = "module";
            $wherevalue1 = ['id' => $per_id];
            $data1 = ['module' => $per_name];
            if ($obj->updatedata($tablename1, $data1, $wherevalue1)) {
                $_SESSION['success'][] = "update successfully...";
                header("location:show_permissions.php");
                exit();
            } else {
                $_SESSION['error'] = "Error: Duplicate entry. This value already exists.";
                echo $_SESSION['error'];
            }
        }
    }
}
