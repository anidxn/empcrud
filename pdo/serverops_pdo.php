<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = require_once 'PDOConnection.php';

    $opcode= $_GET['opcode'];

    if ( $opcode == 1) {    //INSERT
        try{
		$bname = $_POST['txtName'];
		$bprice = floatval($_POST['txtPrice']);
		$bqnty = (int)$_POST['txtQnty'];
        
        // OPTION 1: -------- usual execution ------
        // $sql = "INSERT INTO books (book_name, price, quantity)  VALUES ('$bname', '$bprice', '$bqnty')";
        // $pdo->exec($sql);  // use exec() because no results are returned
		
        
        // OPTION 2a: --------- using prepared statement + BIND PARAMS() ------------
		$sql="INSERT INTO books(book_name, price, quantity) VALUES(:book_name, :price, :quantity)";

        $statement = $pdo->prepare($sql);

        /*
        $statement->bindParam(':book_name', $bname, PDO::PARAM_STR);
        $statement->bindParam(':price', $bprice, PDO::PARAM_STR);  // * * * * FOR fractional values (numeric/float) use STR
        $statement->bindParam(':quantity', $bqnty, PDO::PARAM_INT);
        $statement->execute();
        */

        /* Additionally ------->>> We can insert multiple records using the same same perpared statement, for ex. 
        $bname = "Coffee Can Investing";    $bprice = "200.5";     $bqnty = "10";
        $stmt->execute();

        // insert another row
        $bname = "Diamond In the Dust";    $bprice = "545.8";     $bqnty = "56";
        $stmt->execute();
        */

        // OPTION 2b: ---------- using array of parameters ----------
        $statement->execute([ ':book_name' => $bname, ':price' => $bprice, ':quantity' => $bqnty]);  // list of parameters
        // OR without using :
        //$statement->execute([ 'book_name' => $bname, 'price' => $bprice, 'quantity' => $bqnty]);

        /* Additionally ----->> Inserting multiple rows --->>
        $names = [
	        'Penguin/Random House',
	        'Hachette Book Group',
	        'Harper Collins',
	        'Simon and Schuster'
        ];

        foreach ($names as $name) { //process array in loop
	        $statement->execute([
		        ':name' => $name
	        ]);
        }
        */
        
        $book_id = $pdo->lastInsertId();  # Returns the PKey of last inserted row

        } catch(Exception $e){
            echo $e->getMessage();
            $book_id = 0;
        } finally {
            echo "Closing connection by destroying the object";
            $pdo = null;
        }

		header("Location: data_store.php?status=".$book_id);
		exit();
	    
    } else if ( $opcode == 2) {    //INSERT
        $status = 0;
        try{
		$bname = $_POST['txtName'];
		$bprice = floatval($_POST['txtPrice']);
		$bqnty = (int)$_POST['txtQnty'];
        $bkid = intval($_POST['hdnBkid']);

        // OPTION 1: -------- usual execution ------
        // $sql = "INSERT INTO books (book_name, price, quantity)  VALUES ('$bname', '$bprice', '$bqnty')";
        // $pdo->exec($sql);  // use exec() because no results are returned
		
        
        // OPTION 2a: --------- using prepared statement + BIND PARAMS() ------------
        $sql = "UPDATE books SET book_name = :book_name, price = :price, quantity = :quantity WHERE book_id = :book_id";

        $statement = $pdo->prepare($sql);

        $statement->bindParam(':book_name', $bname, PDO::PARAM_STR);
        $statement->bindParam(':price', $bprice, PDO::PARAM_STR);  // * * * * FOR fractional values (numeric/float) use STR
        $statement->bindParam(':quantity', $bqnty, PDO::PARAM_INT);
        $statement->bindParam(':book_id', $bkid, PDO::PARAM_INT);

        $statement->execute();
        $status = 1;

        // OPTION 2b: ---------- using array of parameters ----------
        // $statement->execute([ ':book_name' => $bname, ':price' => $bprice, ':quantity' => $bqnty, ':book_id' => $bkid]);  // list of parameters
        // OR without using :
        // $statement->execute([ 'book_name' => $bname, 'price' => $bprice, 'quantity' => $bqnty, 'book_id' => $bkid]);

        } catch(Exception $e){
            echo $e->getMessage();
            $status = 0;
        } finally {
            echo "Closing connection by destroying the object";
            $pdo = null;
        }

		header("Location: data_retrieve.php?status=".$status);
		exit();
	    
    }

}

//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
INSERT MULTIPLE rows with loop execute statement
-------------------------------------------------------
$pdo = require_once 'connect.php';

$names = [
	'Penguin/Random House',
	'Hachette Book Group',
	'Harper Collins',
	'Simon and Schuster'
];

$sql = 'INSERT INTO publishers(name) VALUES(:name)';

$statement = $pdo->prepare($sql);

foreach ($names as $name) {
	$statement->execute([
		':name' => $name
	]);
}
*/

?>