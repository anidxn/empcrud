
<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["images"])) {
    $uploadDirectory = "uploads/"; // Directory where uploaded images will be saved
    $uploadedFiles = $_FILES["images"];

    // Loop through all the uploaded files
    foreach ($uploadedFiles["name"] as $key => $fileName) {
        $fileTmpName = $uploadedFiles["tmp_name"][$key];
        $fileType = $uploadedFiles["type"][$key];
        $fileSize = $uploadedFiles["size"][$key];
        $fileError = $uploadedFiles["error"][$key];

        // Check if file is uploaded without any errors
        if ($fileError == UPLOAD_ERR_OK) {
            $destination = $uploadDirectory . $fileName;
            
            // Move uploaded file to destination
            if (move_uploaded_file($fileTmpName, $destination)) {
                echo "File {$fileName} has been uploaded successfully.<br>";
            } else {
                echo "Error uploading {$fileName}.<br>";
            }
        } else {
            echo "Error uploading {$fileName}: " . getUploadErrorMessage($fileError) . "<br>";
        }
    }
} else {
    echo "No files were uploaded.";
}

// Function to get upload error message
function getUploadErrorMessage($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            return "The uploaded file exceeds the upload_max_filesize directive in php.ini";
        case UPLOAD_ERR_FORM_SIZE:
            return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
        case UPLOAD_ERR_PARTIAL:
            return "The uploaded file was only partially uploaded";
        case UPLOAD_ERR_NO_FILE:
            return "No file was uploaded";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Missing a temporary folder";
        case UPLOAD_ERR_CANT_WRITE:
            return "Failed to write file to disk";
        case UPLOAD_ERR_EXTENSION:
            return "A PHP extension stopped the file upload";
        default:
            return "Unknown error";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multiple Image Upload</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple accept="image/*">  <!-- the "multiple" attribute must be set -->
        <button type="submit">Upload</button>
    </form>
</body>
</html>
