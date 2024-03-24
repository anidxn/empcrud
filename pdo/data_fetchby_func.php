<html>
    <head>
    
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../res/css/navstyle.css">
        <script src="../res/js/jquery-3.6.3.js"></script>

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
        
    <?php
    include 'navbar-pdo.php'; 

    $pdo = require_once 'PDOConnection.php';



//    $published_year = isset($_GET['txtBook']) ? $_GET['txtBook'] : '';
    $published_year = 2022;

    $sql = 'CALL get_books_published_after(:published_year)';

    $stmnt = $pdo->prepare($sql);
    $stmnt->bindParam(':published_year', $published_year, PDO::PARAM_INT);
    $stmnt->execute();

    $result = $stmnt->fetchall(PDO::FETCH_ASSOC); // returns an array of rows

    if (count($result) > 0) {  // count number of elements in an array
        echo "Books published after ". $published_year. " are : ";
?>

    <table>
        <thead>
            <th>Sl #</th><th>Name</th><th>Price</th><th>Quantity</th><th>Edit</th><th>Delete</th>
        </thead>
<?php
        $sl = 0;
        foreach ($result as $row){
?>
        <tr>
            <td><?php echo ++$sl; ?></td>
            <td><?php echo $row['book_name']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><a href="data_edit.php?bid=<?php echo $row['book_id']; ?>">edit</a></td>
            <td><button type="button" class="btnDel" data-bid='<?php echo $row['book_id']; ?>'>DELETE</a></td>
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
/* ================= USING fetch() with a LOOP ==============

DELIMITER $$
USE `bookdb`$$
CREATE PROCEDURE get_books_published_after (IN published_year INT)
BEGIN
	SELECT 
		book_id, book_name, price, published, quantity 
	FROM 
		books 
	WHERE year(published) > published_year; 
END$$

DELIMITER ;

*/
?>