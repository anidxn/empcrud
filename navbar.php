<?php 
    session_start();

    if(!isset($_SESSION['login_user'])){
        header("location:index.php?err=2");
        die(); //get out
    }

    $logged_user = $_SESSION['login_user'];
    $usrid = $_SESSION["login_usrid"];  // String value
?>

<a href='dashboard.php'>Dashboard</a>
        <a href='usrgen.php'>Create user</a>
        <a href='viewall.php'>View all user</a>
        <a href='offices.php'>Offices (dependency DDL)</a>
        <a href='autofillsrch.php'>Projects (Autofill)</a>
        <a href='pg_login.php'>Switch to postgres</a>
        <a href='logout.php'>Logout</a>
        <br>
        Welcome <?php echo $logged_user; ?><br>