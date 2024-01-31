<?php
    //include 'connect.php';

    session_start();

    if(!isset($_SESSION['pg_login_user'])){
        header("location:pg_login.php?err=2");
        die(); //get out
    }

    $logged_user = $_SESSION['login_user'];
    $usrid = $_SESSION["login_usrid"];  // String value

    // echo gettype($usrid);  *********** Gives datatype of a variable

    /* // ========== Manually setting timeout =============
    if(time() - $_SESSION['login_time'] >= 900){ //redirect if the page is inactive for 15 minutes
        session_destroy(); // destroy session.
        header("Location: logout.php");
        die(); 
    }
    else {        
       $_SESSION['login_time'] = time();   // update 'login_time' to the last time a page containing this code was accessed.
    } */
?>