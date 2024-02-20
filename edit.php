<?php
    include 'connect.php';

    //check for existing session
    session_start();

    if(!isset($_SESSION['login_user'])){
        header("location:index.php?err=2");
        die(); //get out
    }

    $logged_user = $_SESSION['login_user'];

    // get the user id from request parameter
    $usrid = 0;
    if(isset($_GET['id'])){
        $usrid = (int)$_GET['id'];   // String to integer conversion
    }

$sql="select * from users where uid=".$usrid;

$result=$conn->query($sql);

$ename = '';
$email = '';
$uname = '';
$upass = '';
$etype = 0;

if ($result->num_rows == 1) {  // should be 1
    while ($row = $result->fetch_object()){ //fetch_assoc()) {
        $ename = $row->ename;   //$row['ename'];
        $email = $row->email;   //$row['email'];
        $uname = $row->uname;   //$row['uname'];
        $upass = $row->upass;   //$row['upass'];
        $etype = $row->access_lvl;  //$row['access_lvl'];
    }

    $result->close(); // $result->free_result(); //FREE the resultset
} else {
    echo "<script>alert('user does not exist. Please try again')</script>";
    header("location:viewall.php");
    //die();
}

$conn->close();
?>

<html>
    <head>
        <style>
        table, th, td {
            border: 1px solid #96D4D4;
            border-collapse: collapse;
        }
        </style>
    </head>
    <body>
    <?php include 'navbar.php'; ?>

        <form action="serverops.php?opcode=3" method="POST">
			<table width="50%">
				<tr>
					<td>emp name:</td><td><input type="text" name="ename" id="ename" value="<?php echo "$ename"; ?>"/></td>
				</tr>
				<tr>
					<td>emp email:</td><td><input type="email" name="email" id="email"  value="<?php echo "$email"; ?>"/></td>
				</tr>
				<tr>
					<td>emp username:</td><td><input type="text" name="uname" id="uname" value="<?php echo "$uname"; ?>"/></td>
				</tr>
				<tr>
					<td>emp password:</td><td><input type="password" name="upass" id="upass" value="<?php echo "$upass"; ?>"/></td>
				</tr>
				<tr>
					<td>emp type:</td>
					<td>
						<select id="acc_lvl" name="acc_lvl">
                            <option value="1">Super</option>
							<option value="2">Admin</option>
							<option value="3">Evaluator</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="btnedit" id="btnedit" value="Update User"/></td>
                    <input type="hidden" name="hdnuid" id="hdnuid" value="<?php echo $usrid;?>"/>
				</tr>
				
			</table>
		</form>
    </body>
    <script>
        document.getElementById("acc_lvl").value = <?php echo $etype; ?>;
    </script>
</html>

