<?php 

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare vars!
    $status = false;
    $response = "";
    $tesCred = "";
    $tesDetails = "";
    $tesName = "";
    $email = $_POST['email'];
    $id = $_POST['id'];
    $lastUpdatedOn = date('d-m-Y H:i');

    if(isset($_POST['tesName'])){
        $tesName = $_POST['tesName'];
    }

    if(isset($_POST['tesDetails'])){
        $tesDetails = $_POST['tesDetails'];
    }

    if(isset($_POST['tesCred'])){
        $tesCred = $_POST['tesCred'];
    }

    //check for null submits
    if($tesName != "" && $tesDetails != "" && $tesCred != ""){
        
        $editTes = "UPDATE `testimonials` SET `tesName`='$tesName',`tesDetails`='$tesDetails',`tesCred`='$tesCred',`lastUpdatedOn`='$lastUpdatedOn' WHERE `id` = '$id'";
        $editTesRes = mysqli_query($conn,$editTes) or die(mysqli_error($conn));

        
        $status = true;
        $response = "Testimonial edited";

        if(isset($_FILES["tesImages"]["size"]) && 
            ($_FILES["tesImages"]["size"] > 0)){
             //images directory
             $uploadDir = "../../userImg/$email/tes/$tesName/";

             if (!file_exists("$uploadDir")) {
                 mkdir("$uploadDir", 0777, true);
             }
 
             $photo_img = $uploadDir . basename($_FILES["tesImages"]["name"]);
 
             $imageFileType = strtolower(pathinfo($photo_img, PATHINFO_EXTENSION));
 
             $uploadOk = 1;
 
             if(isset($_POST["submit"])) {

                $checkPhoto = getimagesize($_FILES["tesImages"]["tmp_name"]);
    
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
            if ($_FILES["tesImages"]["size"] > 5000000) {

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
                if (move_uploaded_file($_FILES["tesImages"]["tmp_name"], $photo_img)) {

                    $tImage = basename($_FILES["tesImages"]["name"]);
                    // edit project image!
                    $editImage = "UPDATE `testimonials` SET `tesImage`='$tImage' WHERE `id` = '$id'";
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
