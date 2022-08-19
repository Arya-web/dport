<?php 

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare vars!
    $status = false;
    $response = "";
    $bName = "";
    $bType = "";
    $bDetails = "";
    $bLink = "";
    $email = $_POST['email'];
    $id = $_POST['id'];
    $lastUpdatedOn = date('d-m-Y H:i');

    if(isset($_POST['blogType'])){
        $bType = $_POST['blogType'];
    }

    if(isset($_POST['blogTopic'])){
        $bName = $_POST['blogTopic'];
    }

    if(isset($_POST['blogDetails'])){
        $bDetails = $_POST['blogDetails'];
    }

    if(isset($_POST['blogLink'])){
        $bLink = $_POST['blogLink'];
    }

    //check for null submits
    if($bType != "" && $bDetails != "" && $bLink != ""){
        
        $editBlog = "UPDATE `blogs` SET `bType`='$bType',`bDetails`='$bDetails',`bLink`='$bLink',`lastUpdatedOn`='$lastUpdatedOn' WHERE `id` = '$id'";
        $editBlogRes = mysqli_query($conn,$editBlog) or die(mysqli_error($conn));

        
        $status = true;
        $response = "Blog edited";

        if(isset($_FILES["blogImages"]["size"]) && 
        ($_FILES["blogImages"]["size"] > 0)){
             //images directory
             $uploadDir = "../../userImg/$email/blogs/$bName/";

             if (!file_exists("$uploadDir")) {
                 mkdir("$uploadDir", 0777, true);
             }
 
             $photo_img = $uploadDir . basename($_FILES["blogImages"]["name"]);
 
             $imageFileType = strtolower(pathinfo($photo_img, PATHINFO_EXTENSION));
 
             $uploadOk = 1;
 
             if(isset($_POST["submit"])) {

                $checkPhoto = getimagesize($_FILES["blogImages"]["tmp_name"]);
    
                if($checkPhoto !== false) {
    
                    echo "File is an image - " . $checkPhoto["mime"] . ".";
                    $uploadOk = 1;
    
                } else {
    
                    $status = false;
                    $response = "File is not an image.";
                    $uploadOk = 0;
    
                }
    
            }

                //Check if file already exists
            if (file_exists($photo_img)) {

                unlink($photo_img);

                $uploadOk = 1;

            }
            // Check file size
            if ($_FILES["blogImages"]["size"] > 5000000) {

                $status = false;
                $response = "Sorry, your file is too large.";

                $uploadOk = 0;

            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "webp" ) {

                $status = false;
                $response = "Sorry, only JPG, JPEG, PNG & WEBP files are allowed.";

                $uploadOk = 0;

            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {

                $status = false;
                $response = "Sorry, your image was not uploaded.";
            
            }else {
                if (move_uploaded_file($_FILES["blogImages"]["tmp_name"], $photo_img)) {

                    $bImage = basename($_FILES["blogImages"]["name"]);
                    // edit blog image!
                    $editImage = "UPDATE `blogs` SET `bImage`='$bImage' WHERE `id` = '$id'";
                    $editImageRes = mysqli_query($conn,$editImage) or die(mysqli_error($conn));
    
                } else {
    
                    $status = false;
                    $response = "Sorry, your image was not upload";
    
                }
            }

            $status = true;
            $response = "Image uploaded";
        }

    }else{
        $status = false;
        $response = "Add all details";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
