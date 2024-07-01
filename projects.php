<?php 
    include 'connect.php';
    include 'dataops.php';
    // session_start(); //get any existing session

    // if(!isset($_SESSION['login_user'])){
    //     header("location:index.php?err=2");
    //     die(); //get out
    // }

    // $logged_user = $_SESSION['login_user'];


    if(isset($_GET['status'])) {
        if ( $_GET['status'] == 1) {
            echo "<script>alert('Employee updated successfully');</script>";
        } else {
            echo "<script>alert('Failed to update employee');</script>";
        }
    }
?>

<html>
    <head>
    
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="res/css/navstyle.css">
	

        <style>
        table, th, td {
            border: 1px solid white;
            border-radius: 10px;
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
    <?php include 'navbar.php'; ?>


    <table>
        <thead>
            <th>Sl #</th><th>ID</th><th>TITLE</th><th>DESCRIPTION</th><th>COST</th><!--<th>Edit</th><th>Delete</th>-->
        </thead>
<?php
        /* CALL to a php function which returns a List of Objects */
        $prj_collection = get_project_data($conn);
       $sl = 0;
       foreach($prj_collection as $pobj){
?>
        <tr>
            <td><?php echo ++$sl; ?></td>
            <td><?php echo $pobj->get_pid(); ?></td>

            <td><?php echo $pobj->get_ptit(); ?></td>

            <td><?php echo $pobj->get_desc(); ?></td>
            
            <td><?php echo $pobj->get_est_cost(); ?></td>
            
            <!-- <td><a href="edit.php?id=<?php echo $row['uid']; ?>">edit</a></td>
            <td><a href="remove.php?id=<?php echo $row['uid']; ?>&name=<?php echo $row['ename']; ?>">delete</a></td> -->
        </tr>
<?php   
        }
?>
    </table>   



    </body>
</html>