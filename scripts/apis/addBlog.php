<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $bName = "";
    $bType = "";
    $bDetails = "";
    $bLink = "";
    $email = "";
    $createdOn = date('d-m-Y H:i');
    $lastUpdatedOn = date('d-m-Y H:i');

    //getting form data!
    if(isset($_POST['blogTopic'])){
        $bName = $_POST['blogTopic'];
    }

    if(isset($_POST['blogType'])){
        $bType = $_POST['blogType'];
    }

    if(isset($_POST['blogDetails'])){
        $bDetails = $_POST['blogDetails'];
    }

    if(isset($_POST['blogLink'])){
        $bLink = $_POST['blogLink'];
    }

    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }


    //check for null submits
    if($email != "" && $bName != "" && $bType != "" && $bDetails != "" && $bLink != ""){

        $uploadDir = "../../userImg/$email/blogs/$bName/";
        if(!file_exists("$uploadDir")){
            mkdir("$uploadDir", 0777, true);
        }

        $photo_img = $uploadDir . basename($_FILES['blogImages']['name']);
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($photo_img, PATHINFO_EXTENSION));

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
        
        } else {

            if (move_uploaded_file($_FILES["blogImages"]["tmp_name"], $photo_img)) {
                $bImage = basename($_FILES["blogImages"]["name"]);
                // update details!
                $createBlog = "INSERT INTO `blogs`(`email`, `bName`, `bType`, `bDetails`, `bLink`, `bImage`, `createdOn`, `lastUpdatedOn`) 
                VALUES ('$email','$bName','$bType','$bDetails','$bLink','$bImage','$createdOn','$lastUpdatedOn')";
                $createBlogRes = mysqli_query($conn,$createBlog) or die(mysqli_error($conn));

                if($createBlogRes) {

                    $status = true;
                    $response = "Blog Added!";

                } else {

                    $status = false;
                    $response = "Unable to add the blog!";

                }

            } else {

                $status = false;
                $response = "Unable to upload!";

            }

        }        
        
    }else{
        $status = false;
        $response = "Fill all the details!";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
