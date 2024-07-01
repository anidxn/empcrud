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
		<form action="pdo/serverops_pdo.php?opcode=4" method="POST">
			<table width="50%">
				<tr>
					<td>Depratment Name</td><td><input type="text" name="dname" id="dname"/></td>
				</tr>
				
				<tr>
					<td colspan="2"><input type="submit" name="submit" id="submit" value="Create Department"/></td>
				</tr>
				
			</table>
		</form>

	</body>
</html>