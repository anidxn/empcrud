<?php
include 'connect.php';

$opcode= $_GET['opcode'];
if ( $opcode == 1) {
	if(isset($_POST['submit'])) {
		$emp_name = $_POST['ename'];
		$email = $_POST['email'];
		$usr_name = $_POST['uname'];
		$usr_pass = $_POST['upass'];
		$acc_lvl = $_POST['acc_lvl'];
		
		$sql="INSERT INTO users(uname, upass, ename, email, access_lvl) VALUES('$usr_name','$usr_pass','$emp_name','$email','$acc_lvl')";
		
		$result = $conn->query($sql);
		$status = 0;
		if ($result == TRUE) {
			$status = 1;
			//echo "User created successfully.";
		} else {
			//echo "Error:". $sql . "<br>". $conn->error;
		}

		header("Location: usrgen.php?status=".$status);
		exit;
	}
} elseif( $opcode == 2) {

	if(isset($_POST['btnlogin'])) {
		$usr_name = $_POST['txtuname'];
		$usr_pass = $_POST['txtupass'];
		
		$sql="select * from users where uname='$usr_name' and upass='$usr_pass'";
		
		$result=$conn->query($sql);
		$empname = '';
		$usrid = 0;
		if ($result->num_rows == 1) {  // should be 1
			while ($row = $result->fetch_assoc()) { // ??????? better way
				$empname = $row['ename'];
				$usrid = $row['uid'];
			}
			
			$result -> free_result(); //FREE the resultset
			$conn->close();

			session_start();
			$_SESSION["login_user"] = $empname;
			$_SESSION["login_usrid"] = $usrid;
			header("location:dashboard.php");
			exit;
		} else {
			header("location:index.php?err=1");	
		}
	}

} elseif ( $opcode == 3) {

	if(isset($_POST['btnedit'])) {
		$emp_name = $_POST['ename'];
		$email = $_POST['email'];
		$usr_name = $_POST['uname'];
		$usr_pass = $_POST['upass'];
		$acc_lvl = $_POST['acc_lvl'];
		$uid = $_POST['hdnuid'];
		
		$sql="UPDATE users set uname='$usr_name', upass='$usr_pass', ename='$emp_name', email='$email', access_lvl='$acc_lvl' where uid=".$uid;
		
		// Turn autocommit off
		//$conn->autocommit(FALSE);

		$result=$conn->query($sql);
		$status = 0;
		if ($result == TRUE) {
			$status = 1;

			/* $conn->commit();
			$conn->autocommit(TRUE); */
		} 

		$conn->close();

		header("Location: viewall.php?status=".$status);
		exit;
	}

}  elseif ( $opcode == 4) {  //called by ajax

		$uid = $_POST['userid'];
		//$empl = $_POST['emp'];

		$sql="DELETE from users where uid=".$uid;
		
		$result=$conn->query($sql);
		
		if ($result == TRUE) {
			echo "User ".$uid." deleted successfully";  //sending response to jquery ajax call
		}
}

?>