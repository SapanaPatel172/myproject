<?php
include 'views/partials/validator.class.php';
include 'views/partials/generalfunctions.php';
include 'models/database.php';
class RolesController
{
    //create role logic
    public function create()
    {
        if (isset($_REQUEST['submit'])) {
            $validator = new Validator();

            //check is set or not
            $isset_rolename = $validator->validatisset('rolename', 'Rolename');
            $isset_permission = $validator->validatisset('crud_per', 'permission');

            if ($isset_rolename && $isset_permission) {

                //check is empty or not
                $ept_rolename = $validator->validatempty('rolename', 'Rolename');
                $ept_permission = $validator->validatempty('crud_per', 'permission');

                if ($ept_rolename && $ept_permission) {
                    $rname = htmlspecialchars($_REQUEST['rolename'], ENT_QUOTES, 'UTF-8');
                    $per_id = $_REQUEST['crud_per'];


                    $tablename = "roles";
                    $wherevalue = ['role_name' => $rname];
                    $obj = new database();
                    //check if role is already in the table then error otherwise create new role  
                    $roles_result = $obj->selectdata($tablename, $wherevalue);
                    if ($roles_result->num_rows > 0) {
                        $_SESSION['error'][] = "rolename already exists.!";
                    } else {

                        //insert role into the roles table
                        $sql = $obj->insertdata($tablename, $wherevalue);
                        //echo "<script>alert($sql)</script>";exit;
                        //and also insert permissions into the role_permissions table
                        $role_tablename = "role_permissions";
                        foreach ($per_id as $value) {
                            $role_per_data = ['role_id' => $sql, 'permission_id' => $value];
                            $role_per = $obj->insertdata($role_tablename, $role_per_data);
                        }
                        if ($sql !== null) {
                            $_SESSION['create_success'][] = "create new role successfully";
                        } else {
                            $_SESSION['create_error'][] = "error in create new role..";
                        }
                    }
                }
            }
        }
        header("location:role_management.php");
        exit();
    }

    //update role logic
    public function update()
    {
        if (isset($_REQUEST['submit'])) {
            //get id from url role_management.php file
            $validator = new Validator();
            if (isset($_REQUEST['id'])) {
                //check role id is set or not
                if ($validator->validatisset('id', 'id')) {

                    //check role id is empty or not
                    if ($validator->validatempty('id', 'id')) {

                        $roleId = $_REQUEST['id'];
                        $rolename =  htmlspecialchars($_REQUEST['rolename'], ENT_QUOTES, 'UTF-8');
                        $role = $_REQUEST['crud_per1'];
                        $obj = new database();

                        //frist update rolename into table roles 
                        $tablename1 = "roles";
                        $wherevalue1 = ['role_id' => $roleId];
                        $data = ['role_name' => $rolename];
                        $obj->updatedata($tablename1, $data, $wherevalue1);

                        // delete old record selected role_id from table role_permissions
                        $role_id = ['role_id' => $roleId];
                        $tablename = "role_permissions";
                        if ($obj->deletedata($tablename, $role_id));

                        // old record is deleted then after insert new record into table role_permissions
                        if ($obj) {
                            foreach ($role as $role1 => $value) {
                                $data = ['role_id' => $roleId, 'permission_id' => $value];
                                $role_edit = $obj->insertdata($tablename, $data);
                            }
                            $_SESSION['update_success'][] = "update successfully...";
                        } else {
                            $_SESSION['update_error'][] = "sorry not updated...";
                        }
                    }
                }
            }
        }
        header("location:role_management.php");
        exit();
    }

    //delete role logic
    public function delete()
    {
        if (isset($_REQUEST['submit'])) {

            if (isset($_REQUEST['id'])) {
                //get id from url role_management.php file
                $validator = new Validator();
                //check role id is set or not
                if ($validator->validatisset('id', 'id')) {

                    //check role id is empty or not
                    if ($validator->validatempty('id', 'id')) {
                        $roleId = $_REQUEST['id'];
                        $obj = new database();
                        // delete recored from table roles and also delete role_permissions automatically
                        $tablename = "roles";
                        $wherevalue = ['role_id' => $roleId];
                        if ($obj->deletedata($tablename, $wherevalue)) {
                            $_SESSION['delete_success'][] = "delete successfully...";
                        } else {
                            $_SESSION['delete_error'][] = "sorry record not deleted....";
                        }
                    }
                }
            }
        }
        header("location:role_management.php");
        exit();
    }
}
