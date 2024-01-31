<?php
session_start();

session_unset();  //remove variables

if(session_destroy()) {
    header("Location: index.php");
}

?>