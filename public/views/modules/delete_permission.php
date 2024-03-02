<?php
//no need
session_start();
include '../partials/validator.class.php';
include '../partials/select.php';
include '../partials/generalfunctions.php';
$_SESSION['error'] = [];
$_SESSION['success'] = [];

if (isset($_REQUEST['submit'])) {
    //get id from url show_permissions.php file
    $validator = new Validator();
    //check permission id is set or not
    if ($validator->validatisset('id', 'id')) {

        //check permission id is empty or not
        if ($validator->validatempty('id', 'id')) {

            $roleId = $_REQUEST['id'];
            // echo "<script>alert($roleId)</script>";
            $obj = new database();
            //frist delete record from table role_and_permissions because Foreignkey 
            $role_tablename = "role_permissions";
            $wherevalue1 = ['role_id' => $roleId];
            $obj->deletedata($role_tablename, $wherevalue1);

            //delete recored from table permissions
            $mod_tablename = "module";
            $wherevalue = ['id' => $roleId];
            if ($obj->deletedata($mod_tablename, $wherevalue)) {
                $_SESSION['success'][] = "delete successfully...";
                header("location:show_permissions.php");
            }
        }
    }
}
