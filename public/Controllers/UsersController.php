<?php

include 'views/partials/validator.class.php';
include 'views/partials/generalfunctions.php';
include 'views/partials/send_mail.php';
include 'models/database.php';
class UsersController
{
    //user create logic
    public function create()
    {
        $_SESSION['msg_error'] = [];
        $_SESSION['msg_success'] = [];
        if (isset($_REQUEST['submit'])) {

            //check isset or not 
            $validator = new Validator();
            $isset_name = $validator->validatisset('name', 'name');
            $isset_email = $validator->validatisset('email', 'email');
            $isset_role = $validator->validatisset('role', 'role');

            if ($isset_name && $isset_email && $isset_role) {

                //check empty or not
                $ept_name = $validator->validatempty('name', 'name');
                $ept_email = $validator->validatempty('email', 'email');
                $ept_permission = $validator->validatempty('role', 'role');

                if ($ept_name && $ept_email && $ept_permission) {

                    $name = htmlspecialchars($_REQUEST['name'], ENT_QUOTES, 'UTF-8');
                    $email = $_REQUEST['email'];
                    $get_role = $_REQUEST['role'];
                    $generatedPassword = generatePassword();


                    //check email format validation 
                    if ($validator->validateemail($email)) {

                        //check password validation
                        if ($validator->validatpassword($generatedPassword)) {

                            $tablename = "users";
                            $wherevalue = ['email' => $email];

                            //check email is found or not
                            $obj = new database();
                            $users_result = $obj->selectdata($tablename, $wherevalue);
                            if ($users_result->num_rows > 0) {
                                $_SESSION['error'][] = "Email already exists.!";
                            } else {
                                //insert data into users table
                                $hashedPassword = password_hash($generatedPassword, PASSWORD_DEFAULT);
                                $data = ['name' => $name, 'email' => $email, 'password' => $hashedPassword];
                                $user_id = $obj->insertdata($tablename, $data);

                                if ($user_id) {
                                    //insert user_id and role_id into user_roles table
                                    $roles_id = ['user_id' => $user_id, 'role_id' => $get_role];
                                    $role_data = $obj->insertdata("user_roles", $roles_id);
                                }

                                // Generate token for verification 
                                $tokenTimestamp = time();
                                $data = ['varify' => date('Y-m-d H:i:s', $tokenTimestamp)]; // Save the timestamp and token in the database 
                                $wherecondition = ['email' => $email];

                                //update token,timestamp,varify field
                                $stmt_update = $obj->updatedata($tablename, $data, $wherecondition);
                                if ($stmt_update) {
                                    $basePath = dirname($_SERVER['PHP_SELF']);
                                    $pagePath = "/views/auth/login.php"; //when user click link then redirect login page

                                    // Create the complete URL
                                    $path = "http://$_SERVER[HTTP_HOST]$basePath$pagePath";

                                    //send verification link with email and password
                                    $msg = send_mail($name, $email, $path, $generatedPassword);
                                    if (!$msg->send()) {
                                        $_SESSION['msg_error'][] = 'sorry Message not send, and user not create';
                                    } else {
                                        $_SESSION['msg_success'][] = 'Message send, create user successfully!';
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        header("location:users.php");
        exit();
    }

    //update user logic
    public function update($id)
    {
        $_SESSION['update_success'] = [];
        $_SESSION['update_error'] = [];
        if (isset($_REQUEST['submit'])) {

            if (isset($_REQUEST['id'])) {
                //check isset or not 
                $validator = new Validator();
                $isset_name = $validator->validatisset('name', 'name');
                $isset_role = $validator->validatisset('role1', 'role');

                if ($isset_name && $isset_role) {

                    //check empty or not
                    $ept_name = $validator->validatempty('name', 'name');
                    $ept_permission = $validator->validatempty('role1', 'role');

                    if ($ept_name  && $ept_permission) {

                        $name = htmlspecialchars($_REQUEST['name'], ENT_QUOTES, 'UTF-8');
                        $get_role = $_REQUEST['role1'];
                        $id = $_REQUEST['id'];

                        $data = ['name' => $name];
                        $wherevalue = ['id' => $id];

                        //update user from table users using id and also update data into table user_roles both field(role_id,user_id) 
                        $obj = new database();
                        $users_result = $obj->updatedata("users", $data, $wherevalue);
                        if ($users_result) {
                            $roledata = ['role_id' => $get_role];
                            $rolewherevalue = ['user_id' => $id];
                            $role_result = $obj->updatedata("user_roles", $roledata, $rolewherevalue);
                            if ($role_result) {
                                $_SESSION['update_success'][] = "record updated successfully.....";
                            } else {
                                $_SESSION['update_error'][] = "sorry record not update... ";
                            }
                        }
                    }
                }
            }
        }
        header("location:users.php");
        exit();
    }

    //delete user logic
    public function delete($id)
    {
        $_SESSION['delete_success'] = [];
        $_SESSION['delete_error'] = [];
        if (isset($_REQUEST['submit'])) {

            if (isset($_REQUEST['id'])) {
                //get id from url users.php file
                $validator = new Validator();
                //check user id is set or not
                if ($validator->validatisset('id', 'id')) {

                    //check user id is empty or not
                    if ($validator->validatempty('id', 'id')) {
                        $id = $_REQUEST['id'];
                        $obj = new database();

                        //select profile image for delete image folder
                        $user_data = $obj->selectdata("users", ['id' => $id]);

                        if ($user_data->num_rows > 0) {
                            $row = $user_data->fetch_assoc();
                            // Get the profile image file name
                            $profileImage = $row['avatarimg'];

                            // Check if the file exists before trying to delete it
                            if (file_exists($profileImage)) {
                                // Delete the profile image file
                                unlink($profileImage);
                            }
                        }
                        // delete recored from table users and also delete user_roles automatically
                        $tablename = "users";
                        $wherevalue = ['id' => $id];
                        if ($obj->deletedata($tablename, $wherevalue)) {
                            $_SESSION['delete_success'][] = "delete successfully.....";
                        } else {
                            $_SESSION['delete_error'][] = "error in delete user...";
                        }
                    }
                }
            }
        }
        header("location:users.php");
        exit();
    }
}
