<?php
    // Initialize the session
    session_start();
    
    $url = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], "/")+1);
    if($url == 'user_login.php' || $url  == 'admin_login.php') {
        // Check if the user is already logged in, if yes then redirect him to welcome page
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            if(!empty($AdminID)){
                header("location: admin_homepage.php");
                exit;
            } else {
                header("location: user_homepage.php");
            }
            
        }
    } else {
        // Check if the customer is logged in, if not then redirect him to login page
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: user_login.php");
            exit;
        }
    }
?>