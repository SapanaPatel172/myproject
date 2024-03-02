<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
  include '../../models/database.php';

$role_id = $_REQUEST['role_id'];

//get permission_id from the table role_permissions using role_id 
$obj = new database();
$permissions = $obj->selectdata("role_permissions", ['role_id' => $role_id]);

$per_result = [];
while ($row = $permissions->fetch_assoc()) {
   $per_result[] = ['permission_id' => $row['permission_id']];
}
// return result array
echo json_encode($per_result);
}

