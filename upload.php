<?php
// Include the database configuration file
include 'dbconfig.php';
$statusMsg = '';

// File upload path
$targetDir = "image/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
?>


<!DOCTYPE html>
<html>
<head>
  <title>Upload your files</title>
  <style>
  body{
	  background-color: lightGray;
		background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }
  h2{
	  color: Gray;
	  font-family:"Comic Sans MS", cursive, sans-serif;  
  }
  .content{
	  border: 2px solid Gray;
	  width: 250px;
	  padding: 20px;
  }
  </style>
</head>
<body>
<h2>Third Eye</h2>
  <form  class="content" enctype="multipart/form-data" action="upload.php" method="POST">
    <p style="color:Gray">Upload your file</p>
    <input type="file" name="file"></input>
    <input type="submit"  name="submit" value="Upload"></input>
  </form>
</body>
</html>

