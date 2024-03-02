<?php

include 'views/partials/validator.class.php';
include 'views/partials/generalfunctions.php';
include 'models/database.php';

class AuthController
{
    //change password logic
    public function cdpassword($token)
    {
        if (isset($_REQUEST['token'])) {

            $_SESSION['error'] = [];
            $validator = new Validator();
            $token = $_REQUEST['token'];
            //check token format validation(length 32,a to f small character and 0 to 9 digits)
            if ($validator->validattoken($token)) {

                $wherevalue = ['token' => $token];

                //select data where token is match and get token_timestamp
                $obj = new database();
                $_SESSION['path'] = "changepwd";
                $tablename = "users";
                $users_result = $obj->selectdata($tablename, $wherevalue);
                if ($users_result->num_rows > 0) {
                    $row = $users_result->fetch_assoc();
                    $time = $row['token_timestamp'];
                    $get_token_time = $validator->isTokenExpired($time);

                    //when time is not expire then changepassword
                    if ($get_token_time) {

                        if (isset($_REQUEST['submit'])) {

                            //check isset or not 
                            $isset_newpassword = $validator->validatisset('newpwd', 'newpassword');
                            $isset_confirmpassword = $validator->validatisset('conpwd', 'confirm password');

                            if ($isset_newpassword && $isset_confirmpassword) {

                                //check empty or not 
                                $ept_newpassword = $validator->validatempty('newpwd', 'newpassword');
                                $ept_confirmpassword = $validator->validatempty('conpwd', 'confirm password');

                                if ($ept_newpassword && $ept_confirmpassword) {

                                    $conpwd = $_REQUEST['conpwd'];
                                    $newpwd = $_REQUEST['newpwd'];

                                    //check password validation
                                    if ($validator->validatpassword($newpwd)) {
                                        //check both password
                                        if ($newpwd == $conpwd) {
                                            $hashpwd = password_hash($newpwd, PASSWORD_DEFAULT);
                                            $data = ['password' => $hashpwd];

                                            //update password where token is match
                                            $obj = new database();
                                            $updated_user = $obj->updatedata($tablename, $data, $wherevalue);
                                            if ($updated_user) {
                                                header("location:login.php");
                                                exit();
                                            } else {
                                                $_SESSION['error'][] = "Error updating password: ";
                                            }
                                        } else {
                                            $_SESSION['error'][] = "Passwords do not match";
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $_SESSION['error'][] = "token time is expaire";
                        header("location:error_page.php");
                        exit();
                    }
                } else {
                    echo "<script>window.location.href = 'verification.php';</script>";
                    exit();
                }
            } else {
                $_SESSION['error'][] = "Sorry, token format is wrong";
                header("location:error_page.php");
                exit();
            }
        }
        header("location:change_password.php");
        exit();
    }

    //reset password logic
    public function resetpassword()
    {
        include 'views/partials/select.php';
        $_SESSION['success'] = [];
        $_SESSION['error'] = [];

        if (isset($_REQUEST['submit'])) {
            //check isset or not 
            $validator = new Validator();
            $isset_password = $validator->validatisset('oldpwd', 'oldPassword');
            $isset_newPassword = $validator->validatisset('newpwd', 'newpassword');
            $isset_ConfirmPassword = $validator->validatisset('conpwd', 'confirm password');

            if ($isset_password && $isset_newPassword && $isset_ConfirmPassword) {

                //check empty or not 
                $ept_password = $validator->validatempty('oldpwd', 'oldPassword');
                $ept_newPassword = $validator->validatempty('newpwd', 'newpassword');
                $ept_ConfirmPassword = $validator->validatempty('conpwd', 'confirm password');

                if ($ept_password && $ept_newPassword && $ept_ConfirmPassword) {

                    $oldpwd = $_REQUEST['oldpwd'];
                    $newpwd = $_REQUEST['newpwd'];
                    $conpwd = $_REQUEST['conpwd'];

                    //check password validation
                    if ($validator->validatpassword($newpwd)) {     //password format is valid or not

                        if ($newpwd == $conpwd) {     //new and confirm password is match 

                            if (password_verify($oldpwd, $password)) {    //old password is match or not and $password from select.php

                                $hashpwd = password_hash($newpwd, PASSWORD_DEFAULT);
                                $data = ['password' => $hashpwd];
                                $condition = ['id' => $id];
                                $tablename = "users";

                                //update password
                                $obj = new database();
                                $user_update = $obj->updatedata($tablename, $data, $condition);
                                if ($user_update) {
                                    $_SESSION['success'][] = "password updated...";
                                } else {
                                    $_SESSION['error'][] = "Error updating password ";
                                }
                            } else {
                                $_SESSION['error'][] = "old password is wrong";
                            }
                        } else {
                            $_SESSION['error'][] = "Passwords do not match";
                        }
                    }
                }
            }
        }
        header("location:resetpassword.php");
        exit();
    }

    //registration logic
    public function registration()
    {
        include 'views/partials/send_mail.php';
        $_SESSION['error'] = [];
        $_SESSION['success'] = [];
        if (isset($_REQUEST['submit'])) {

            //check isset or not 
            $validator = new Validator();
            $isset_name = $validator->validatisset('name', 'name');
            $isset_email = $validator->validatisset('email', 'email');
            $isset_password = $validator->validatisset('pwd', 'password');
            $isset_conpassword = $validator->validatisset('cpwd', 'confirm password');

            if ($isset_name && $isset_email && $isset_password && $isset_conpassword) {

                //check empty or not
                $ept_name = $validator->validatempty('name', 'name');
                $ept_email = $validator->validatempty('email', 'email');
                $ept_password = $validator->validatempty('pwd', 'password');
                $ept_conpassword = $validator->validatempty('cpwd', 'confirm password');

                if ($ept_name && $ept_email && $ept_password && $ept_conpassword) {

                    $name = htmlspecialchars($_REQUEST['name'], ENT_QUOTES, 'UTF-8');
                    $email = $_REQUEST['email'];
                    $password = $_REQUEST['pwd'];
                    $cpwd = $_REQUEST['cpwd'];

                    //check email format validation 
                    if ($validator->validateemail($email)) {

                        //check password validation
                        if ($validator->validatpassword($password)) {

                            //check password and confirm password is match or not
                            if ($password == $cpwd) {
                                $tablename = "users";
                                $wherevalue = ['email' => $email];

                                //check email is found or not
                                $obj = new database();
                                $users_result = $obj->selectdata($tablename, $wherevalue);
                                if ($users_result->num_rows > 0) {
                                    $_SESSION['error'][] = "Email already exists.!";
                                } else {

                                    //insert data into table users
                                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                    $data = ['name' => $name, 'email' => $email, 'password' => $hashedPassword];
                                    $user_id = $obj->insertdata($tablename, $data);


                                    if ($user_id) {
                                        $_SESSION["email"] = $email; //set session variable
                                        $_SESSION["id"] = $user_id;
                                        //bydefult simpleuser here get role name user id from the roles table
                                        $roles_name = ['role_name' => "user"];
                                        $role_data = $obj->selectdata("roles", $roles_name);
                                        $row = $role_data->fetch_assoc();
                                        $role_id = $row['role_id'];


                                        if ($role_id) {
                                            //insert user_id and role_id into user_roles table
                                            $rol_user_id = ['user_id' => $user_id, 'role_id' => $role_id];
                                            $insert_userid_roleid = $obj->insertdata("user_roles", $rol_user_id);
                                        }
                                    }

                                    // Generate token randomly
                                    $token = md5(rand());
                                    $tokenTimestamp = time();
                                    $time_data = ['token' => $token, 'token_timestamp' => date('Y-m-d H:i:s', $tokenTimestamp)]; // Save the timestamp and token in the database 
                                    $wherecondition = ['email' => $email];

                                    //insert token & timestamp
                                    $time_update = $obj->updatedata($tablename, $time_data, $wherecondition);
                                    if ($time_update) {
                                        $basePath = dirname($_SERVER['PHP_SELF']);
                                        $pagePath = "/views/auth/dashbord.php";

                                        // Create the complete URL
                                        $path = "http://$_SERVER[HTTP_HOST]$basePath$pagePath?token=$token";

                                        //send verification link
                                        $msg = send_mail($name, $email, $path);
                                        if (!$msg->send()) {
                                            $_SESSION['error'][] = 'Message not sent!';
                                        } else {
                                            $_SESSION['success'][] = 'Message sent!';
                                        }
                                    }
                                }
                            } else {
                                $_SESSION['error'][] = "Passwords do not match";
                                $redirectURL = "registration.php?email=" . urlencode($email) . "&name=" . urlencode($name);
                                header("location:$redirectURL");
                                exit();
                            }
                        }
                    }
                }
            }
        }
        header('location:registration.php');
        exit();
    }
    //forgot password logic
    public function forgotpassword()
    {
        include 'views/partials/send_mail.php';
        $_SESSION['error'] = [];
        $_SESSION['success'] = [];
        if (isset($_REQUEST['submit'])) {
            // check isset or not 
            $validator = new Validator();
            if ($validator->validatisset('email', 'email')) {

                //check empty or not
                if ($validator->validatempty('email', 'email')) {

                    $email = $_REQUEST['email'];

                    // check if the email is match
                    $obj = new database();
                    $wherevalue = ['email' => $email];
                    $tablename = "users";
                    $users_result = $obj->selectdata($tablename, $wherevalue);
                    if ($users_result->num_rows > 0) {
                        $row = $users_result->fetch_assoc();
                        $name = $row['name'];
                        $email = $row['email'];
                        $id = $row['id'];

                        // Generate a new token and timestemp
                        $token = md5(rand());
                        $tokenTimestamp = time();

                        $time_data = ['token' => $token, 'token_timestamp' => date('Y-m-d H:i:s', $tokenTimestamp)];

                        $wherecondition = ['id' => $id];

                        $stmt_update = $obj->updatedata($tablename, $time_data, $wherecondition);

                        if ($stmt_update) {
                            $basePath = dirname($_SERVER['PHP_SELF']);
                            $pagePath = "/views/auth/change_password.php";

                            // Create the complete URL
                            $path = "http://$_SERVER[HTTP_HOST]$basePath$pagePath?token=$token";

                            // send verification link
                            $msg = send_mail($name, $email, $path);
                            if (!$msg->send()) {
                                $_SESSION['error'][] = 'Message not sent!';
                            } else {
                                $_SESSION['success'][] = 'Message sent!';
                            }
                        } else {
                            $_SESSION['error'][] = "Link invalid; please check again in your email";
                        }
                    } else {
                        $_SESSION['error'][] = "Please enter a valid email";
                    }
                }
            }
        }
        header('location:forgotpassword.php');
        exit();
    }

    //verification logic
    public function verification()
    {
        $_SESSION['error'] = [];
        $_SESSION['success'] = [];
        if (isset($_REQUEST['submit'])) {

            // check isset or not empty
            $validator = new Validator();

            //check email is set or not
            if ($validator->validatisset('email', 'email')) {

                //check email is empty or not
                if ($validator->validatempty('email', 'email')) {

                    $email = $_REQUEST['email'];

                    // check email is match or not if match then generate new token 
                    $wherevalue = ['email' => $email];
                    $tablename = "users";
                    $obj = new database();
                    $stmt_result = $obj->selectdata($tablename, $wherevalue);
                    if ($stmt_result->num_rows > 0) {
                        $row = $stmt_result->fetch_assoc();
                        $name = $row['name'];
                        $email = $row['email'];
                        $id = $row['id'];


                        // generate new token and set timestemp into the database
                        $token = md5(rand());
                        $tokenTimestamp = time();
                        $time_data = ['token' => $token, 'token_timestamp' => date('Y-m-d H:i:s', $tokenTimestamp)];
                        $wherecondition = ['id' => $id];
                        $stmt_update = $obj->updatedata($tablename, $time_data, $wherecondition);

                        if ($stmt_update) {

                            //pagename get from the session veriable
                            if (isset($_SESSION['path'])) {
                                $basePath = dirname($_SERVER['PHP_SELF']);

                                //if pagename register then redirect path dashbord.php otherwise change_password.php
                                if ($_SESSION['path'] == "dashbord") {
                                    $pagePath = "/views/auth/dashbord.php";
                                } else {
                                    $pagePath = "views/auth/change_password.php";
                                }

                                // Create the complete URL
                                $path = "http://$_SERVER[HTTP_HOST]$basePath$pagePath?token=$token";
                                $_SESSION['email'] = $email;
                                $_SESSION['id'] = $id;
                                // send verification link with name,token,email and path
                                $msg = send_mail($name, $email, $path);
                                if (!$msg->send()) {
                                    $_SESSION['error'][] = 'Message not sent!';
                                } else {
                                    $_SESSION['success'][] = 'Message sent!';
                                }
                            }
                        } else {
                            $_SESSION['error'][] = "record is not update";
                        }
                    } else {
                        $_SESSION['error'][] = "Please enter a valid email";
                    }
                }
            }
        }
        header("location:verification.php");
        exit();
    }

    //user login
    public function login()
    {
        $_SESSION['error'] = [];
        $_SESSION['success'] = [];
        if (isset($_REQUEST['submit'])) {
            $validator = new Validator();
            //check isset or not 
            $isset_email = $validator->validatisset('email', 'email');
            $isset_password = $validator->validatisset('pwd', 'password');

            if ($isset_email && $isset_password) {

                //check empty or not
                $ept_email = $validator->validatempty('email', 'email');
                $ept_password = $validator->validatempty('pwd', 'password');

                if ($ept_email && $ept_password) {

                    //if isset and not empty then assign value
                    $email = $_REQUEST['email'];
                    $pwd = $_REQUEST['pwd'];

                    $wherevalue = ['email' => $email];
                    $tablename = "users";

                    //match email or password into the database if is match then check user verified or not 
                    $obj = new database();
                    $users_result = $obj->selectdata($tablename, $wherevalue);
                    if ($users_result->num_rows > 0) {
                        $user = $users_result->fetch_assoc();
                        $password = $user['password'];
                        $flag = $user['varify'];   //verify time get from the database 

                        // Use password_verify to check hashed password
                        if (password_verify($pwd, $password)) {

                            //check timestemp if get proper time then redirect to the dashbord otherwise verification.php
                            if ($flag !== NULL) {
                                $_SESSION["id"] = $user['id'];
                                $_SESSION["email"] = $email;
                                header('Location:dashbord.php');
                                exit();
                            } else {
                                $_SESSION['error'][] = "please varify your email";
                                $_SESSION['path'] = "dashbord";
                                header('Location:verification.php');
                                exit();
                            }
                        } else {
                            $_SESSION['error'][] = "Email or password is invalid";
                            $redirectURL = "login.php?email=" . urlencode($email);
                            header("Location: $redirectURL");
                            exit();
                            // header('Location:login.php');
                        }
                    } else {
                        $_SESSION['error'][] = "Email or password is invalid";
                        $redirectURL = "login.php?email=" . urlencode($email);
                        header("Location: $redirectURL");
                        exit();
                    }
                }
            }
        }
        header('Location:login.php');
        exit();
    }
}
