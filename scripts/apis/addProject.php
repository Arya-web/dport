<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $pName = "";
    $pTech = "";
    $pDetails = "";
    $pLink = "";
    $email = "";
    $createdOn = date('d-m-Y H:i');
    $lastUpdatedOn = date('d-m-Y H:i');

    //getting form data!
    if(isset($_POST['projectName'])){
        $pName = $_POST['projectName'];
    }

    if(isset($_POST['techStack'])){
        $pTech = $_POST['techStack'];
    }

    if(isset($_POST['projectDetails'])){
        $pDetails = $_POST['projectDetails'];
    }

    if(isset($_POST['projectLink'])){
        $pLink = $_POST['projectLink'];
    }

    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }


    //check for null submits
    if($email != "" && $pName != "" && $pTech != "" && $pDetails != "" && $pLink != ""){

        $uploadDir = "../../userImg/$email/projects/$pName/";
        if(!file_exists("$uploadDir")){
            mkdir("$uploadDir", 0777, true);
        }

        $photo_img = $uploadDir . basename($_FILES['projectImages']['name']);
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($photo_img, PATHINFO_EXTENSION));

        if(isset($_POST["submit"])) {

            $checkPhoto = getimagesize($_FILES["projectImages"]["tmp_name"]);

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
        if ($_FILES["projectImages"]["size"] > 5000000) {

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

            if (move_uploaded_file($_FILES["projectImages"]["tmp_name"], $photo_img)) {
                $pImage = basename($_FILES["projectImages"]["name"]);
                // update details!
                $createProject = "INSERT INTO `projects`(`email`, `pName`, `pTech`, `pDetails`, `pLink`, `pImage`, `createdAt`, `lastUpdatedOn`) 
                VALUES ('$email','$pName','$pTech','$pDetails','$pLink','$pImage','$createdOn','$lastUpdatedOn')";
                $createProjectRes = mysqli_query($conn,$createProject) or die(mysqli_error($conn));

                if($createProjectRes) {

                    $status = true;
                    $response = "Project Added!";

                } else {

                    $status = false;
                    $response = "Unable to add the project!";

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
