<?php
    include 'connect.php';

    session_start();

    if(!isset($_SESSION['login_user'])){
        header("location:index.php?err=2");
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

<html>
    <body>
        <a href='usrgen.php'>Create user</a>
        <a href='viewall.php'>View all user</a>
        <a href='pg_login.php'>Switch to postgres</a>
        <a href='logout.php'>Logout</a>
        <br>
        Welcome <?php echo $logged_user; ?><br>

<?php
$sql="select * from users where uid=".$usrid;

//-------- Procedural Approach ----------
$result = mysqli_query($conn, $sql);    // $result = $conn->query($sql);
if(mysqli_num_rows($result) == 1) {     // if ($result->num_rows == 1) { 
    while($row = mysqli_fetch_assoc($result)) { //while ($row = $result->fetch_assoc()) {
?>
        email id : <?php echo $row['email']; ?> <br>
        username : <?php echo $row['uname']; ?> <br>
<?php
    }  
    
    mysqli_free_result($result); //$result -> free_result(); //FREE the resultset
} else {
    echo 'No details found';
}

mysqli_close($conn); // $conn->close();

?>


    </body>
</html>