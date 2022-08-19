<?php 

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare vars!
    $status = false;
    $response = "";
    $pTech = "";
    $pDetails = "";
    $pLink = "";
    $pName = "";
    $email = $_POST['email'];
    $id = $_POST['id'];
    $lastUpdatedOn = date('d-m-Y H:i');

    if(isset($_POST['techStack'])){
        $pTech = $_POST['techStack'];
    }

    if(isset($_POST['projectName'])){
        $pName = $_POST['projectName'];
    }

    if(isset($_POST['projectDetails'])){
        $pDetails = $_POST['projectDetails'];
    }

    if(isset($_POST['projectLink'])){
        $pLink = $_POST['projectLink'];
    }

    //check for null submits
    if($pTech != "" && $pDetails != "" && $pLink != ""){
        
        $editProject = "UPDATE `projects` SET `pTech`='$pTech',`pDetails`='$pDetails',`pLink`='$pLink',`lastUpdatedOn`='$lastUpdatedOn' WHERE `id` = '$id'";
        $editProjectRes = mysqli_query($conn,$editProject) or die(mysqli_error($conn));

        
        $status = true;
        $response = "Project edited";

        if(isset($_FILES["projectImages"]["size"]) && 
            ($_FILES["projectImages"]["size"] > 0)){
             //images directory
             $uploadDir = "../../userImg/$email/projects/$pName/";

             if (!file_exists("$uploadDir")) {
                 mkdir("$uploadDir", 0777, true);
             }
 
             $photo_img = $uploadDir . basename($_FILES["projectImages"]["name"]);
 
             $imageFileType = strtolower(pathinfo($photo_img, PATHINFO_EXTENSION));
 
             $uploadOk = 1;
 
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
            
            }else {
                if (move_uploaded_file($_FILES["projectImages"]["tmp_name"], $photo_img)) {

                    $pImage = basename($_FILES["projectImages"]["name"]);
                    // edit project image!
                    $editImage = "UPDATE `projects` SET `pImage`='$pImage' WHERE `id` = '$id'";
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
