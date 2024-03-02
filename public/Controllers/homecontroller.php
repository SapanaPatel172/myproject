<?php

class HomeController
{
    public function index()
    {
        //if user alredy login then redirect to dashbord
        if (isset($_SESSION["email"])) {
            header('Location:views/auth/dashbord.php');
            exit(); // Add exit after header to prevent further execution
        } else {
            header('location:views/auth/login.php');
            exit();
        }
    }
}
