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
        
    <?php include 'navbar-pdo.php'; ?>

    Book inventory 

<?php
    $pdo = require_once 'PDOConnection.php';

    $bookname = isset($_GET['txtBook']) ? $_GET['txtBook'] : '';

    $sql="SELECT book_id, book_name, price, quantity FROM books order by book_name";
    $stmnt = $pdo->query($sql);         // for select all

    $result = $stmnt->fetchall(PDO::FETCH_ASSOC); // returns an array of rows

    if (count($result) > 0) {  // count number of elements in an array
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

    <script>
        $(document).ready(function() {
        
            $('.btnDel').click(function() {
                // alert('Item id from data field: ' + $(this).data("bid"));
                
                if (confirm("Are you sure you want to delete?") == true) {
                    $.ajax({
                        url : "serverops_pdo.php?opcode=3",
                        type: "POST",
                        data : {
                            bkid : $(this).data("bid"),
                        },
                        dataType: 'json',
		                success : function(response, status, xhr) {
                            if (response.status == 1) {
                                alert(response.message);
                                // Reload the page or perform any other necessary actions
                                location.reload();
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error){  // incorrect URl or dta format
                            alert('Error');
                        }
                    });
                } 
                
	        });
        
        });
    </script>
</html>
