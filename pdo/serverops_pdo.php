<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = require_once 'PDOConnection.php';

    $opcode= $_GET['opcode'];

    if ( $opcode == 1) {
        try{
		$bname = $_POST['txtName'];
		$bprice = floatval($_POST['txtPrice']);
		$bqnty = (int)$_POST['txtQnty'];
        
        // -------- usual execution ------
        // $sql = "INSERT INTO books (book_name, price, quantity)  VALUES ('$bname', '$bprice', '$bqnty')";
        // $pdo->exec($sql);  // use exec() because no results are returned
		
        
        // --------- using prepared statement + BIND PARAMS() ------------
		$sql="INSERT INTO books(book_name, price, quantity) VALUES(:book_name, :price, :quantity)";

        $statement = $pdo->prepare($sql);

        $statement->bindParam(':book_name', $bname, PDO::PARAM_STR);
        $statement->bindParam(':price', $bprice, PDO::PARAM_STR);  // * * * * FOR fractional values (numeric) use STR
        $statement->bindParam(':quantity', $bqnty, PDO::PARAM_INT);
        $statement->execute();

        /*
       
        $statement->execute([   // list of parameters
            ':name' => $bname, 
            ':price' => $bprice,
            ':quantity' => $bqnty
        ]);*/
        
        
        $book_id = $pdo->lastInsertId();  # Returns the PKey of last inserted row
        

        } catch(Exception $e){
            echo $e->getMessage();
            $book_id = 0;
        } finally {
            echo "Closing connection by destroying the object";
            $pdo = null;
        }

		//header("Location: data_store.php?status=".$book_id);
		//exit;
	    
    }

}

//$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>