<?php 

require_once 'connect.php';

$sql="select * from mas_state";
$ddlStateData = '';
//-------- Procedural Approach ----------
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) { //while ($row = $result->fetch_assoc()) {
        $ddlStateData = $ddlStateData.'<option value='.$row['scode'].'>'.$row['sname'].'</option>';
    }  
    
    mysqli_free_result($result); //$result -> free_result(); //FREE the resultset
} else {
    // echo 'No details found';
}

mysqli_close($conn); // $conn->close();

?>

<?php

if(isset($_GET['status'])) {
	if ( $_GET['status'] == 1) {
		echo "<script>alert('Data saved successfully');</script>";
	} else {
		echo "<script>alert('Failed to save data');</script>";
	}
}

?>

<!DOCTYPE html>
<html>
    <head>
    <script src="res/js/jquery-3.6.3.js"></script>
    </head>
	<body>
        <?php include 'navbar.php'; ?>
		<form action="serverops.php?opcode=5" method="POST">
			<table width="50%">
				<tr>
					<td>Office name:</td><td><input type="text" name="ofcname" id="ofcname"/></td>
				</tr>
				<tr>
					<td>Address:</td><td><textarea name="txtaddr" id="txtaddr" rows="4" cols="50"></textarea></td>
				</tr>
				<tr>
					<td>State:</td>
                    <td>
                        <select id="ddlstate" name="ddlstate">
							<option value='0'>-- select --</option>
                            <?php echo $ddlStateData; ?>
						</select>
                    </td>
				</tr>
				<tr>
					<td>District:</td><td>
                        <div id='dvDist' name='dvDist'>
                        <select id="ddldist" name="ddldist">
							<option value='0'>-- select --</option>
						</select>
                        </div>
                    </td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" id="submit" value="Save office"/></td>
				</tr>
				
			</table>
		</form>

	</body>

    <script>
        $(document).ready(function() {
        
            $('#ddlstate').change(function() {
                     $.ajax({
                        url : "serverajax.php?ajaxcode=1",
                        type: "POST",
                        data : {
                            ddlscode : $("#ddlstate").val()
                        },
		                success : function(response, status, xhr) {  //populate html based on ajax response
                            $('#dvDist').html(response);
                        },
                        error: function(xhr, status, error){
                            $('#dvDist').html(error);
                        }
                    });
	        });
        
        });
    </script>
</html>