<?php
date_default_timezone_set("Asia/Calcutta");   
class Validator
{
    //check variable isset or not
    function validatisset($key, $fieldName)
    { 
        if (!isset($_REQUEST[$key])) {
            $_SESSION['error'][] = "$fieldName is not set";
            return false;
        }
        return true;
    }
    

    //check variable empty or not
    function validatempty($key, $fieldName)
    {
        if (empty($_REQUEST[$key])) {
            $_SESSION['error'][] = "Please enter $fieldName";
            return false;
        }
        return true;
    }

    //token verification
    function validattoken($token)
    {
        if (!preg_match('/^[a-f0-9]{32}$/', $token)) {
            $_SESSION['error'][] = "Invalid token format";
            return false;
        }
        return true;
    }

    // check password validation
    function validatpassword($newpwd)
    {
        if (strlen($newpwd) < 8 || !preg_match('/[^a-zA-Z0-9]/', $newpwd) || !preg_match('/[0-9]/', $newpwd)) {
            if (strlen($newpwd) < 8) {
                $_SESSION['error'][] = "Password must be at least 8 characters long.";
            }
            if (!preg_match('/[^a-zA-Z0-9]/', $newpwd)) {
                $_SESSION['error'][] = "Password must contain at least one special character.";
            }
            if (!preg_match('/[0-9]/', $newpwd)) {
                $_SESSION['error'][] = "Password must contain at least one digit.";
            }
            return false;
        } else {
            return true;
        }
    }
// check email format
    function validateemail($email)
    {
        $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

        //check email validation 
        if (!preg_match($pattern, $email)) {
            $_SESSION['error'][] = "Please enter valid email address";
            return false;
        }
        return true;
    }

    // Function to check if a token has expired
    function isTokenExpired($tokenTimestamp)
    {
        $currentTimestamp = time();
        $tokenExpirationTime = 5 * 60; // 2 minute in seconds
       
        // Convert the string timestamp to Unix timestamp
        $tokenTimestamp = strtotime($tokenTimestamp);
       
        // var_dump($currentTimestamp, $tokenTimestamp, $tokenExpirationTime);exit;
        return ($currentTimestamp - $tokenTimestamp) < $tokenExpirationTime;
    }
}
