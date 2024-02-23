<?php 
    if(isset($_GET['status'])) {
        if ( $_GET['status'] == 1) {
            echo "<script>alert('Book updated successfully');</script>";
        } else {
            echo "<script>alert('Failed to update book');</script>";
        }
    }
?>

<html>
    <head>
    
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../res/css/navstyle.css">
	

        <style>
        table, th, td {
            border: 1px solid white;
            border-radius: 3px;
            border-collapse: collapse;
        }
        th {
            background-color: #96D4D4;
            padding: 10px;
        }
        td {
            background-color: #96D4A2;
            padding: 7px;
        }
        </style>
    </head>
    <body>
        
    <?php include 'navbar-pdo.php'; ?>

        <form action="" method="get">
            <input type="text" name="txtBook" id="txtBook">
            <input type="submit" value="SEARCH">
        </form>

    Book inventory 

<?php
    $pdo = require_once 'PDOConnection.php';

    $bookname = isset($_GET['txtBook']) ? $_GET['txtBook'] : '';

    $sql="SELECT book_id, book_name, price, quantity FROM books";

    if($bookname != ''){
        $sql = $sql . " where book_name = ?";
        //or
        // $sql = $sql." where book_name = :book_name ";
    }

    $stmnt = $pdo->prepare($sql);
    if($bookname != ''){
        $stmnt -> execute([$bookname]); // With parameter e.g. $stmnt->execute([175, 'yellow']);
        // or
        // $stmnt -> execute([':book_name' => $bookname]); 
    } else {
        $stmnt -> execute();
    }

    $result = $stmnt->fetchall(PDO::FETCH_ASSOC); // returns an array of rows

    if (count($result) > 0) {  // count number of elements in an array
?>
    <table>
        <thead>
            <th>Sl #</th><th>Name</th><th>Price</th><th>Quantity</th><th>Edit</th><th>Delete</th>
        </thead>
<?php
        $sl = 0;
        // while ($row = $result->fetch_assoc()) { 
        foreach ($result as $row){
?>
        <tr>
            <td><?php echo ++$sl; ?></td>
            <td><?php echo $row['book_name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><a href="data_edit.php?bid=<?php echo $row['book_id']; ?>">edit</a></td>
            <td><a href="data_remove.php?bid=<?php echo $row['book_id']; ?>">delete</a></td>
        </tr>
<?php   }   ?>
    </table>   

<?php
 //   $result -> free_result(); //FREE the resultset
 } else {
     echo '<br>No records found';
 }

    // closing connection
    $pdo  = null;
?>

    </body>
</html>

<?php 
/*
// fetching records using function --> USE of LIKE operator
//-----------------------------------------------------------------
function find_book_by_title(\PDO $pdo, string $keyword): array
{
    $pattern = '%' . $keyword . '%';

    $sql = 'SELECT book_id, title FROM books WHERE title LIKE :pattern';

    $statement = $pdo->prepare($sql);
    $statement->execute([':pattern' => $pattern]);

    return  $statement->fetchAll(PDO::FETCH_ASSOC);
}

// connect to the database
$pdo = require 'connect.php';

// find books with the title matches 'es'
$books = find_book_by_title($pdo, 'es');

foreach ($books as $book) {
    echo $book['title'] . '<br>';
}
*/
?>