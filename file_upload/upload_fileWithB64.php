<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../res/css/navstyle.css">
	</head>
    <body>
        <?php include '../navbar.php'; ?>

<form method="post" action="" enctype='multipart/form-data'>
    <input type='file' name='file' />
    <input type='submit' value='Save name' name='but_upload'>
</form>

<?php
include("../connect.php");

if(isset($_POST['but_upload'])  && !empty($_FILES["file"]["name"])){
 
    $name = $_FILES['file']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $file_temp_path = $_FILES['file']['tmp_name']; // temprary uploaded file in server => E:\INstallationS\xamp\tmp\php7876.tmp

    // Valid file extensions
    //$extensions_arr = array("jpg","jpeg","png","gif");
    $allowed_ext = array("jpg" => "image/jpg",
                            "jpeg" => "image/jpeg",
                            "gif" => "image/gif",
                            "png" => "image/png");

    $file_mime = mime_content_type($file_temp_path);

    // Check extension
    //if( in_array($imageFileType, $extensions_arr) ){
    // Check Mime-type
    if( in_array($file_mime , $allowed_ext) ){
         // Upload file ***
         if(move_uploaded_file($file_temp_path, $target_dir.$name)){ // move the file from temp folder to actual folder
               // Convert to base64 
               $image_base64 = base64_encode(file_get_contents($target_dir.$name) ); // extract from actual uploaded file path
               
               $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

               // Insert record
               $query = "insert into images(name, image_data) values('".$target_dir.$name."', '".$image."')";
               mysqli_query($conn,$query);

               echo "image uploaded successfully. reload page ...";

               // delete the uploaded file as it is converted to base64 & stored
               //unlink($target_dir.$name);
         }
    
    }
 
} else {
    $sql = "select image_data from images order by id";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result)){
        $image_src = $row['image_data'];
        echo "<img src='$image_src' alt='no-image'><br>";
    }
    
}

$conn->close();
?>
    
    </body>
</html>