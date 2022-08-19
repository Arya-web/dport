<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare vars!
    $status = false;
    $response = "";
    $tesName = "";
    $tesDetails = "";
    $tesCred = "";
    $email = "";
    $createdOn = date('d-m-Y H:i');
    $lastUpdatedOn = date('d-m-Y H:i');

    //getting form data!
    if(isset($_POST['tesName'])){
        $tesName = $_POST['tesName'];
    }

    if(isset($_POST['tesDetails'])){
        $tesDetails = $_POST['tesDetails'];
    }

    if(isset($_POST['tesCred'])){
        $tesCred = $_POST['tesCred'];
    }

    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }

    if($tesName != "" && $tesDetails != "" && $tesCred != ""){
        $uploadDir = "../../userImg/$email/tes/$tesName/";
        if(!file_exists("$uploadDir")){
            mkdir("$uploadDir", 0777, true);
        }

        $photo_img = $uploadDir . basename($_FILES['tesImages']['name']);
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($photo_img, PATHINFO_EXTENSION));

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
        
        } else {

            if (move_uploaded_file($_FILES["tesImages"]["tmp_name"], $photo_img)) {
                $tImage = basename($_FILES["tesImages"]["name"]);
                // update details!
                $createTes = "INSERT INTO `testimonials`(`email`, `tesName`, `tesDetails`, `tesCred`, `tesImage`, `createdOn`, `lastUpdatedOn`) 
                VALUES ('$email','$tesName','$tesDetails','$tesCred','$tImage','$createdOn','$lastUpdatedOn')";
                $createTesRes = mysqli_query($conn,$createTes) or die(mysqli_error($conn));

                if($createTesRes) {

                    $status = true;
                    $response = "Testimonial Added!";

                } else {

                    $status = false;
                    $response = "Unable to add the testimonial!";

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