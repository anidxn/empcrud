
<!DOCTYPE html>
<html>
	<body>
	<?php include 'navbar-pdo.php'; ?>

    <?php
    $pdo = require_once 'PDOConnection.php';

    $bkid = isset($_GET['bid']) ? $_GET['bid'] : '';

    //========================= SELECT WITH CLAUSE (with where condition) ==================================
    // $sql="SELECT book_id, book_name, price, quantity FROM books where book_id = :book_id";
    // OR 
    $sql="SELECT book_id, book_name, price, quantity FROM books where book_id = ?";
    
    $stmnt = $pdo->prepare($sql);
    
    // $stmnt -> execute([':book_id' => $bkid]);   or $stmnt->bindParam(':book_id', $bkid, PDO::PARAM_INT); $stmnt->execute(); => prevents sql injection
    //OR
    $stmnt -> execute([$bkid]); 
    

    $result = $stmnt->fetchall(PDO::FETCH_ASSOC); // returns an array of rows

    //if (count($result) > 0) {  // count number of elements in an array
        // foreach ($result as $row){
        // }
        $row = $result[0]; // get 1 record

?>

		<form action="serverops_pdo.php?opcode=2" method="POST">
			<table width="50%">
				<tr>
					<td>Book name:</td>
                    <td>
                        <input type="text" name="txtName" id="txtName" value="<?php echo $row['book_name'];?>"/>
                        <input type="hidden" name="hdnBkid" id="hdnBkid" value="<?php echo $bkid;?>">
                    </td>
				</tr>
				<tr>
					<td>Price:</td><td><input type="text" name="txtPrice" id="txtPrice"  value="<?php echo $row['price'];?>"/></td>
				</tr>
				<tr>
					<td>Quantity:</td><td><input type="text" name="txtQnty" id="txtQnty"  value="<?php echo $row['quantity'];?>"/></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" id="submit" value="UPDATE"/></td>
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