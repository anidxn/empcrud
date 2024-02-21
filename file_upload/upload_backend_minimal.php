<?php

include 'connect.php';

if(isset($_POST["btnupload"]) && !empty($_FILES["fileToUpload"]["name"])) {
  //  $_FILES["fileToUpload"] gives the uploaded file 

  $allowed_ext = array("jpg" => "image/jpg",
                            "jpeg" => "image/jpeg",
                            "gif" => "image/gif",
                            "png" => "image/png");

  $max_size = 500 * 1024;
  $uploadOk = 1;

$target_dir = "uploads/";
if(!is_dir($target_dir)) {   //if folder does not exist 
    mkdir($target_dir);       //create a folder
}

$file_name = basename($_FILES["fileToUpload"]["name"]); //basename() returns the trailing name component of a path
$target_file = $target_dir.$file_name ;

// Check if file already exists
if (file_exists($target_file)) {
  echo "<br> Sorry, file already exists.";
  $uploadOk = 0;
}

$file_size = $_FILES["fileToUpload"]["size"];   // gives size in Bytes
$file_temp_path = $_FILES["fileToUpload"]["tmp_name"]; // temprary uploaded file in server => E:\INstallationS\xamp\tmp\php7876.tmp
//echo $file_extn." -- Ext -- ".$file_type."<br>";

// Check if image file is a actual image or fake image
$file_mime = mime_content_type($file_temp_path);
//echo "  File mime = ".$file_mime."  <br>  ";
if (! in_array($file_mime, $allowed_ext)) {
  echo "<br> Sorry, not an allowed MIME-type. This file MIME = ".$file_mime;
  $uploadOk = 0;
}


// Check file size  is 500kb or more
if ( $file_size > $max_size) {
  echo "<br> Sorry, your file is too large.";
  $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "<br> Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($file_temp_path , $target_file)) { // move the file from temp folder to actual folder

    //$sql="INSERT INTO images(name) VALUES('$target_file')";
		//$result=$conn->query($sql);
		
    //if ($result == TRUE) {
      echo "<br> The file ". htmlspecialchars($file_name). " has been uploaded.";
    //} else {
    //  echo "Database update error";
    //}
    
  } else {
    echo "<br> Sorry, there was an error uploading your file.";
  }
}

} else {
  echo "Please select a file to upload.";
}

?>

<br>
Click <a href="upload.php">here</a> too go to upload page