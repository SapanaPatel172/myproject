<?php
include 'views/partials/validator.class.php';
include 'views/partials/generalfunctions.php';
include 'models/database.php';
class ModulesController
{
    public function create()
    {
        $_SESSION['create_error'] = [];
        $_SESSION['create_success'] = [];

        if (isset($_REQUEST['submit'])) {
            $validator = new Validator();

            //check modulename is set or not
            if ($validator->validatisset('modulename', 'modulename')) {

                //check modulename is empty or not
                if ($validator->validatempty('modulename', 'modulename')) {

                    $mod_name = htmlspecialchars($_REQUEST['modulename'], ENT_QUOTES, 'UTF-8');
                    $wherevalue = ['module' => $mod_name];
                    $tablename = "module";

                    //check module is found or not if not then add otherwise error
                    $obj = new database();
                    $module_result = $obj->selectdata($tablename, $wherevalue);
                    if ($module_result->num_rows > 0) {
                        $_SESSION['mod_error'][] = "module already exists.!";
                        header("location:show_modules.php");
                    } else {
                        $sql = $obj->insertdata($tablename, $wherevalue);
                        $tbl = "permissions";
                        $per = [$mod_name . '_create', $mod_name . '_update', $mod_name . '_view', $mod_name . '_delete'];
                        foreach ($per as $permission) {
                            $data = ['permission_name' => $permission, 'mod_id' => $sql];
                            $mos_result = $obj->insertdata($tbl, $data);
                        }
                        //if record is inserted then redirect show_modules.php file
                        if ($mos_result) {
                            $_SESSION['create_success'][] = "module created successfully..";
                        } else {
                            $_SESSION['create_error'][] = "sorry module not created..";
                        }
                    }
                }
            }
        }
        header("location:show_modules.php");
        exit();
    }
}
