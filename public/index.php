<?php
session_start();

// Extract the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Use parse_url to extract the path component
$path = parse_url($requestUri, PHP_URL_PATH);

// Ensure $path starts with a forward slash
$path = '/' . ltrim($path, '/');

// Split the path into segments
$pathSegments = explode('/', $path);

// Get the controller name from the first segment
$controllerName = !empty($pathSegments[4]) ? ucfirst($pathSegments[4]) . 'Controller' : 'HomeController';
// echo $controllerName;
// Build the full path to the controller file
$controllerFilePath = __DIR__ . '/controllers/' . strtolower($controllerName) . '.php';

// Check if the controller file exists
if (file_exists($controllerFilePath)) {
    // Include the controller file
    include($controllerFilePath);

    // Create an instance of the dynamically determined controller
    $controller = new $controllerName();

    // Determine the action from the second path segment (or use 'index' as the default)
    $action = !empty($pathSegments[5]) ? $pathSegments[5] : 'index';
    // echo $action;

    // Extract the argument from the URL (assuming it's in the third segment)
    $argument = !empty($_GET) ? $_GET : null;

    // Call the appropriate method on the controller
    if (method_exists($controller, $action)) {
        // Pass the argument to the method
        $controller->$action($argument);
    } else {
        // Handle the case where the action method doesn't exist
        // e.g., display an error page or redirect
        header("location:/myproject/public/views/auth/file_404.php");
        exit();
    }
} else {
    // Handle the case where the controller file doesn't exist
    // e.g., display an error page or redirect
    header("location:/myproject/public/views/auth/file_404.php");
    exit();
}
