<?php

include 'upload_file_func.php';
include 'connect.php';


if(!empty($_FILES["fileToUpload"]["name"])) {   //  $_FILES["fileToUpload"] gives the uploaded file(s) 
    $ret = upload_to_server($_FILES["fileToUpload"]);

    $status = explode("~", $ret);

    if ($status[0] == "1"){
      $sql="INSERT INTO images(name) VALUES('$status[1]')";
		  $result=$conn->query($sql);
		
      if ($result == TRUE) {
        echo "File uploaded successfully.";
      }
    } else {
      echo "ERROR !! " . $status[1];
    }
  } else {
    echo "Please select a file to upload.";
  }

  echo "done";


?>