<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = require_once 'PDOConnection.php';

    $opcode= $_GET['opcode'];

    if ( $opcode == 1) {
        try{
		$bname = $_POST['txtName'];
		$bprice = $_POST['txtPrice'];
		$bqnty = (int)$_POST['txtQnty'];
		
		$sql="INSERT INTO books(book_name, price, quantity) VALUES(:book_name, :price, :quantity)";

        $statement = $pdo->prepare($sql);

        $statement->execute([   // liat of parameters
            ':name' => $bname, 
            ':price' => $bprice,
            ':quantity' => $bqnty
        ]);
        
        $book_id = $pdo->lastInsertId();  # Returns the PKey of last inserted row

        } catch(Exception $e){
            echo $e->getMessage();
            $book_id = 0;
        } finally {
            echo "Closing connection by destroying the object";
            $pdo = null;
        }

		//header("Location: data_store.php?status=".$book_id);
		exit;
	    
    }

}

