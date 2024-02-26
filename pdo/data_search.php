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
    include('serverops_func_pdo.php');
    $pdo = require_once 'PDOConnection.php';

    $key = isset($_GET['txtBook']) ? $_GET['txtBook'] : '';  //get search key from text box

    echo "<br>You searched for - ".$key."</br>";
    
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    // calling a function with connection object parameter & getting result as array
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $books = find_by_btitle($pdo, $key);

    if (count($books) > 0) {  // count number of elements in an array
?>
    <table>
        <thead>
            <th>Sl #</th><th>Name</th><th>Price</th><th>Quantity</th><th>Edit</th><th>Delete</th>
        </thead>
<?php
        $sl = 0;
     
        foreach ($books as $row){
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
