<?php
include 'connect.php';

$opcode= $_GET['opcode'];
if ( $opcode == 1) {							//--------- INSERT USING ObjectOriented Approach ------------
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
} elseif( $opcode == 2) {			//------- login -----------

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

} elseif ( $opcode == 3) {		//------- update ---------

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
} elseif ( $opcode == 5) {  					 // ----------------- INSERT project detils using PREPARED STATEMENTS in MYSQL --------
	$stmt = $conn->prepare("INSERT INTO projects (ptitle, pdesc, est_cost) VALUES ( ?, ?, ?)");
	// bind parameters with appropriate data type
	$stmt->bind_param("ssd", $title, $description, $cost);

	/*
	i => corresponding variable has type int
	d => corresponding variable has type float
	s => corresponding variable has type string
	b => corresponding variable is a blob and will be sent in packets
	*/

	// set parameters &  execute
	$title = isset($_POST['txtptitle']) ? $_POST['txtptitle'] : '';
	$description = isset($_POST['txtpdesc']) ? $_POST['txtpdesc'] : '';
	$cost = isset($_POST['txtcost']) ? $_POST['txtcost'] : 0.0;
	
	$stmt->execute();
	$status = 1;

	/* * * * WE can insert multiple rows using different values with prev 4 lines, for example
	// insert a row
  $firstname = "John";
  $lastname = "Doe";
  $email = "john@example.com";
  $stmt->execute();

  // insert another row
  $firstname = "Mary";
  $lastname = "Moe";
  $email = "mary@example.com";
  $stmt->execute();

  // insert another row
  $firstname = "Julie";
  $lastname = "Dooley";
  $email = "julie@example.com";
  $stmt->execute();
	*/

	$stmt->close();
	$conn->close();

	# header("Location: autofillsrch.php?status=".$status);

}

?>