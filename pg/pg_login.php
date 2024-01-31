<?php
    
    //redirect to user dashboard if already logged in
    session_start();

    if(isset($_SESSION['pg_login_user'])){
        header("location:pg_dashboard.php");
        die(); //get out
    } 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="res/css/style.css">
    </head>
    <body>
        <div id="loginform">
        <form action="pg_serverops.php?opcode=2" method="post">
            <img src="res/img/postgre.jpeg" height="50">
            <p>
                <label> Username: </label>
                 <input type="text" name="txtuname" id = "txtuname"/>
            </p>
            <p>
                <label> Password: </label>
                <input type="password" name="txtupass" id = "txtupass"/>
            </p>
            <p>
                <input type="submit" id="btnlogin" name="btnlogin" value="Login">
            </p>
        </form>
        </div>

<?php 
if(isset($_REQUEST["err"]))
    if($_REQUEST["err"] == 1)
	    $msg="Invalid username or Password";
    elseif($_REQUEST["err"] == 2)
        $msg="Session expired, please login again";
?>
<p style="color:red;">
<?php
if(isset($msg)){
    echo $msg;
}
?>
    </body>
</html>