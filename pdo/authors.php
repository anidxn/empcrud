<?php

include "serverops_func_pdo.php";

$pdo = require_once 'PDOConnection.php';
$get_data = get_book_list($pdo);

$dropdown_content = '';
foreach ($get_data as $row){
    $dropdown_content = $dropdown_content.'<option value='.$row['book_id'].'>'.$row['book_name'].'</option>';
}


?>
<!DOCTYPE html>
<html>
	<body>
	<?php include 'navbar-pdo.php'; ?>
		<form action="serverops_pdo.php?opcode=5" method="POST">
			<table width="50%">
                <br>
					<select name="ddlbookid" id="book_name">
    					<option value="0">--select--</option>
    					<?php echo $dropdown_content; ?>
					</select>
				<tr>
					<td>First Name of author:</td><td><input type="text" name="fname" id="fname"/></td>
				</tr>
				<tr>
					<td>Middle Name of author:</td><td><input type="text" name="mname" id="mname"/></td>
				</tr>
				<tr>
					<td>Last Name of author</td><td><input type="text" name="lname" id="lname"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit_author" id="submit_author" value="Save"/></td>
				</tr>
				
			</table>
		</form>

    </body>
<?php
if(isset($_GET['status'])) {
	if ( $_GET['status'] == 0) {
		echo "<script>alert('Failed to save data');</script>";
	} else {
		echo "<script>alert('Author Inserted successfull');</script>";
	}
}

?>

</html>