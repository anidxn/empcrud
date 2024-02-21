
<!DOCTYPE html>
<html>
	<body>
	<?php include 'navbar-pdo.php'; ?>
		<form action="serverops_pdo.php?opcode=1" method="POST">
			<table width="50%">
				<tr>
					<td>Book name:</td><td><input type="text" name="txtName" id="txtName"/></td>
				</tr>
				<tr>
					<td>Price:</td><td><input type="text" name="txtPrice" id="txtPrice"/></td>
				</tr>
				<tr>
					<td>Quantity:</td><td><input type="text" name="txtQnty" id="txtQnty"/></td>
				</tr>
				<!-- <tr>
					<td>:</td><td><input type="password" name="upass" id="upass"/></td>
				</tr> -->
				<tr>
					<td colspan="2"><input type="submit" name="submit" id="submit" value="Save"/></td>
				</tr>
				
			</table>
		</form>

    </body>
<?php
if(isset($_GET['status'])) {
	if ( $_GET['status'] == 0) {
		echo "<script>alert('Failed to save data');</script>";
	} else {
		echo "<script>alert('The book id  ". $_GET['status'] . " was inserted');</script>";
	}
}
?>
</html>