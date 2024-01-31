<?php
    //check for existing session
    session_start();
    
    if(!isset($_SESSION['login_user'])){
        header("location:index.php?err=2");
        die(); //get out
    }

    $logged_user = $_SESSION['login_user'];

    // get the user id from request parameter
    $usrid = 0;
    if(isset($_GET['id'])){
        $usrid = (int)$_GET['id'];   // String to integer conversion
    }
    $empname = '';
    if(isset($_GET['name'])){
        $empname = $_GET['name'];
    }
?>

<html>
    <head>
    <script src="res/js/jquery-3.6.3.js"></script>
    </head>
    <body>
        <a href='dashboard.php'>Home</a>
        <a href='usrgen.php'>Create user</a>
        <a href='viewall.php'>View all user</a>
        <a href='logout.php'>Logout</a>
        <p>
        <button type="button" id='btnDel'>Delete</button>
        <p>
        <div id="message"></div>
    </body>

    <script>
        $(document).ready(function() {
        
            $('#btnDel').click(function() {
                
                if (confirm("Are you sure you want to delete?") == true) {
                    $.ajax({
                        url : "serverops.php?opcode=4",
                        type: "POST",
                        data : {
                            userid : <?php echo $usrid; ?>
                        },
		                success : function(response, status, xhr) {
                            $('#message').html(response);
                        },
                        error: function(xhr, status, error){
                            $('#message').html(error);
                        }
                    });
                } 
                
	        });
        
        });
    </script>
</html>
