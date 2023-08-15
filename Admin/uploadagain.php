<?php
    require_once('../methods/extra_function.php');
    include('../authenticate/dbconnection.php');

    if(isset($_POST["submit"])){ 
        $status = 'error'; 
        if(!empty($_FILES["image"]["name"])) { 
            // Get file info 
            $fileName = basename($_FILES["image"]["name"]); 
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); 
             
            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){ 
                $image = $_FILES['image']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
             
                $query = "INSERT into images (image, created) VALUES ('$imgContent', NOW())";
                // Insert image content into database 
                $resultinsert = mysqli_query($link,$query);
                 
                if($resultinsert){ 
                    $status = 'success'; 
                    $statusMsg = "File uploaded successfully."; 
                }else{ 
                    $statusMsg = "File upload failed, please try again."; 
                }  
            }else{ 
                $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
            } 
        }else{ 
            $statusMsg = 'Please select an image file to upload.'; 
        } 
    } 
     
    // Display status message 
    echo $statusMsg; 

?>