<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $name = "";
    $techstack = "";
    $about = "";
    $email = "";
    $lastUpdatedOn = date('d-m-Y H:i');

    //getting form data!

    if(isset($_POST['name'])){
        $name = $_POST['name'];
    }

    if(isset($_POST['skills'])){
        $techstack = $_POST['skills'];
    }

    if(isset($_POST['about'])){
        $about = $_POST['about'];
    }

    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }


    //check for null submits
    if($email != "" && $name != "" && $about != "" && $techstack != ""){

        //select user with that email
        $user = "SELECT * FROM `users` WHERE `email` = '$email'";
        $userRes = mysqli_query($conn, $user) or die(mysqli_error($conn));

        //check if user exists
        if(mysqli_num_rows($userRes) > 0){

            $update = "UPDATE `users` SET `name`='$name',`techstack`='$techstack', `about` = '$about', `lastUpdatedOn`='$lastUpdatedOn' WHERE `email` = '$email'";
            $updateRes = mysqli_query($conn, $update) or die(mysqli_error($conn));

            $status = true;
            $response = "User details updated successfully! Do add your picture!";

            if(isset($_FILES["userImages"]["size"]) && 
            ($_FILES["userImages"]["size"] > 0)){
             //images directory
             $uploadDir = "../../userImg/$email/user/";

             if (!file_exists("$uploadDir")) {
                 mkdir("$uploadDir", 0777, true);
             }
 
             $photo_img = $uploadDir . basename($_FILES["userImages"]["name"]);
 
             $imageFileType = strtolower(pathinfo($photo_img, PATHINFO_EXTENSION));
 
             $uploadOk = 1;
 
             if(isset($_POST["submit"])) {

                $checkPhoto = getimagesize($_FILES["userImages"]["tmp_name"]);
    
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
            if ($_FILES["userImages"]["size"] > 5000000) {

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
                if (move_uploaded_file($_FILES["userImages"]["tmp_name"], $photo_img)) {

                    $userImage = basename($_FILES["userImages"]["name"]);
                    // edit project image!
                    $editImage = "UPDATE `users` SET `userImage`='$userImage' WHERE `email` = '$email'";
                    $editImageRes = mysqli_query($conn,$editImage) or die(mysqli_error($conn));
    
                } else {
    
                    $status = false;
                    $response = "Sorry, your image was not upload";
    
                }
            }

            $status = true;
            $response = "User details with Image uploaded";
        }

        }else{
            $status = false;
            $response = "Invalid email!";
        }
        
    }else{
        $status = false;
        $response = "Fill all the details!";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
