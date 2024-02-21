<?php

if(isset($_GET['status'])) {
	if ( $_GET['status'] == 1) {
		echo "<script>alert('Data saved successfully');</script>";
	} else {
		echo "<script>alert('Failed to save data');</script>";
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="res/css/navstyle.css">
	</head>
	<body>
	<?php include 'navbar.php'; ?>
		<form action="serverops.php?opcode=1" method="POST">
			<table width="50%">
				<tr>
					<td>emp name:</td><td><input type="text" name="ename" id="ename"/></td>
				</tr>
				<tr>
					<td>emp email:</td><td><input type="email" name="email" id="email"/></td>
				</tr>
				<tr>
					<td>emp username:</td><td><input type="text" name="uname" id="uname"/></td>
				</tr>
				<tr>
					<td>emp password:</td><td><input type="password" name="upass" id="upass"/></td>
				</tr>
				<tr>
					<td>emp type:</td>
					<td>
						<select id="acc_lvl" name="acc_lvl">
							<option value="2">Admin</option>
							<option value="3">Evaluator</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" id="submit" value="Create User"/></td>
				</tr>
				
			</table>
		</form>

	</body>
</html>