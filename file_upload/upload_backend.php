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

$file_extn = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));  // Gives   jpg
$file_type = $_FILES["fileToUpload"]["type"];    // gives image/jpeg
$file_size = $_FILES["fileToUpload"]["size"];   // gives size in Bytes
$file_temp_path = $_FILES["fileToUpload"]["tmp_name"]; // temprary uploaded file in server => E:\INstallationS\xamp\tmp\php7876.tmp
//echo $file_extn." -- Ext -- ".$file_type."<br>";

// Allow certain file formats => X X X X X both checks (type or extension) fail when a exe file is disguised as jpeg
if($file_extn != "jpg" && $file_extn != "png" && $file_extn != "jpeg" && $file_extn != "gif" ) {
  echo "<br> Sorry, only files with JPG, JPEG, PNG & GIF EXTEnsions are allowed.";
  $uploadOk = 0;
} else if (! in_array($file_type, $allowed_ext)) {
  echo "<br> Sorry, not an allowed type.";
  $uploadOk = 0;
}

// Check if image file is a actual image or fake image
// option 1:
// * + * + * + * + BEST approach to check MIME + * + * + * + * 
$file_mime = mime_content_type($file_temp_path); 
//echo "  File mime = ".$file_mime."  <br>  ";
if (! in_array($file_mime, $allowed_ext)) {
  echo "<br> Sorry, not an allowed MIME-type. This file MIME = ".$file_mime;
  $uploadOk = 0;
}

//option 2:
    /*
    The getimagesize() function will determine the size of any supported given image file and return the dimensions
     along with the file type and a height/width text string to be used inside a normal HTML IMG tag 
     and the correspondent HTTP content type. 

     ** CAUTION ** This function expects filename to be a valid image file. If a non-image file is supplied, 
     it may be incorrectly detected as an image and the function will return successfully, 
     but the array may contain nonsensical values. 

    */
  $check = getimagesize($file_temp_path);
  if($check !== false) {
    echo "<br> File is an image - " . $check["mime"];
    $uploadOk = 1;
  } else { 
    echo "<br> File is not an image";
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
      echo "<br> The file ". htmlspecialchars( $file_name ). " has been uploaded.";
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
//header("Location: usrgen.php?status=".$status);
?>

<br>
Click <a href="upload.php">here</a> too go to upload page