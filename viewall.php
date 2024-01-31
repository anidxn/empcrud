<?php 
    include 'connect.php';

    session_start(); //get any existing session

    if(!isset($_SESSION['login_user'])){
        header("location:index.php?err=2");
        die(); //get out
    }

    $logged_user = $_SESSION['login_user'];


    if(isset($_GET['status'])) {
        if ( $_GET['status'] == 1) {
            echo "<script>alert('Employee updated successfully');</script>";
        } else {
            echo "<script>alert('Failed to update employee');</script>";
        }
    }
?>

<html>
    <head>
        <style>
        table, th, td {
            border: 1px solid white;
            border-radius: 10px;
            border-collapse: collapse;
        }
        th {
            background-color: #96D4D4;
            padding: 10px;
        }
        td {
            background-color: #96D4A2;
            padding: 7px;
        }
        </style>
    </head>
    <body>
        <a href='dashboard.php'>Home</a>
        <a href='usrgen.php'>Create user</a>
        <a href='viewall.php'>View all user</a>
        <a href='logout.php'>Logout</a>
        <br>
        Welcome <?php echo $logged_user; ?><br>

<?php
$sql="select * from users";

$result=$conn->query($sql);
if ($result->num_rows > 0) {
?>
    <table>
        <thead>
            <th>Sl #</th><th>Name</th><th>email</th><th>username</th><th>Password</th><th>Access level</th><th>Edit</th><th>Delete</th>
        </thead>
<?php
        $sl = 0;
        while ($row = $result->fetch_assoc()) { 
?>
        <tr>
            <td><?php echo ++$sl; ?></td>
            <td><?php echo $row['ename']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['uname']; ?></td>
            <td><?php echo $row['upass']; ?></td>
            <td><?php echo $row['access_lvl']; ?></td>
            <td><a href="edit.php?id=<?php echo $row['uid']; ?>">edit</a></td>
            <td><a href="remove.php?id=<?php echo $row['uid']; ?>&name=<?php echo $row['ename']; ?>">delete</a></td>
        </tr>
<?php   
        }
?>
    </table>   

<?php
    $result -> free_result(); //FREE the resultset
} else {
    echo 'No records found';
}

$conn->close();
?>

    </body>
</html>