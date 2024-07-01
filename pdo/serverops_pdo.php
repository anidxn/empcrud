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
	    
    } else if ( $opcode == 2) {    //UPDATE
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
	    
    } else if ( $opcode == 3) {    //DELETE
        $status = 0;
        try{
		    $bookid = intval($_POST['bkid']);

            $sql = "DELETE from books WHERE book_id = :book_id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':book_id', $bookid, PDO::PARAM_INT);

            if($stmt->execute()){
                $status = 1;
            } else {
                $status = 0;
            }

        } catch(Exception $e){
            echo $e->getMessage();
            $status = 0;
        } finally {
            $pdo = null;    //closing connection
        }

        if($status == 1){
            $response = array('status' => $status, 'message' => 'Item deleted successfully');
        } else {
            $response = array('status' => $status, 'message' => 'Failed to delete item');
        }

        //return json response
        echo json_encode($response);
    }

    else if ( $opcode == 4) {           // MySQL can not process nested query (SO break into 2 queries)
        if(isset($_POST['submit'])) {
            // $pdo = require_once 'pdo/PDOConnection.php';
            try{
            $dept_name = $_POST['dname'];

            $pdo->beginTransaction();
            
            $sql1 = "select coalesce (max(did),0)+1 as new_id from department";
            $statement = $pdo->prepare($sql1);
            $statement->execute();
            
            $result = $statement->fetch(PDO::FETCH_ASSOC); //fetch for single row
            $did = $result['new_id'];
            $status = 0;
            // $sql="INSERT INTO department (did, dname) VALUES ((select max(did)+1 from department),'$dept_name')"; this will work in postgressSQL
           
            $sql="INSERT INTO department (did, dname) VALUES ('$did','$dept_name')";
    
            $statement2 = $pdo->prepare($sql);
            if ($statement2->execute()){
                $status = 1;
                $statement->closeCursor(); //for memory management clear the memory after select query
                $statement2->closeCursor();
                $pdo->commit();
    
            }
        } catch(Exception $e) {
            $pdo->rollBack();
            $status=0;
        }
        finally{
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);//1 means autocomit on for future transactions
        }

            header("Location: ../deptentry.php?status=".$status);
            exit;
        }
    }

    else if ( $opcode == 5) {
        if(isset($_POST['submit_author'])) {
            // $pdo = require_once 'pdo/PDOConnection.php';
            try{
            $bkid = $_POST['ddlbookid'];
            $first_name = $_POST['fname'];
            $mid_name = $_POST['mname'];
            $last_name = $_POST['lname'];
    
            $pdo->beginTransaction();
            
            $sql1 = "CALL SAVEAUTHOR (:bk_id, :fname, :mname, :lname)";
            $statement = $pdo->prepare($sql1);
            
            $statement->bindParam(':bk_id', $bkid, PDO::PARAM_INT);
            $statement->bindParam(':fname', $first_name, PDO::PARAM_STR);
            $statement->bindParam(':mname', $mid_name, PDO::PARAM_STR);
            $statement->bindParam(':lname', $last_name, PDO::PARAM_STR);
            
            
            if ($statement->execute()){
                $status = 1;
                // $statement->closeCursor(); //for memory management clear the memory after select query
                // $statement2->closeCursor();
                $pdo->commit();
    
            }
        }catch(Exception $e) {
            $pdo->rollBack();
            $status=0;
            echo $e->getMessage();
    
        }
        finally{
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);//1 means autocomit on for future transactions
        }
    
            header("Location: authors.php?status=".$status);
            exit;
        }
    }
    

}








?>