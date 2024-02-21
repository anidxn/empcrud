
<!DOCTYPE html>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../res/css/navstyle.css">
	</head>
<body>
    <?php include '../navbar.php'; ?>
    UPload file to folder & store the path in db
<!--  enctype="multipart/form-data" -->

<!-- <form action="upload_backend.php" method="post" enctype="multipart/form-data"> -->
<form action="upload_by_func.php" method="post" enctype="multipart/form-data">
    
    Select image to upload:  <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg,.jpeg,.png">
    <input type="submit" value="Upload Image" name="btnupload">
</form>

<?php
    include '../connect.php';

    $sql = "select name from images order by id";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result)){
        $image_src = $row['name'];
        echo $image_src;
        echo "<img src='$image_src' alt='no-image'><br>";
    }

?>

</body>
</html>
