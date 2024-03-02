<?php
session_start();
include '../../models/database.php';
include '../partials/select.php';
$obj = new database();

if (isset($_REQUEST['id'])) {
    $userId = $_REQUEST['id'];

    // Fetch user data based on the provided id
    $userData = $obj->selectdata("users", ['id' => $userId]);
    
    // Return user data as JSON
    header('Content-Type: application/json');
    echo json_encode($userData->fetch_assoc());
} else {
    // Return an empty object if no id is provided
    echo json_encode([]);
}

