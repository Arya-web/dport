<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $email = "";
    $getTes = array();
    
    //check for form data
    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }

    if($email != ""){

        $checkID = "SELECT `id`, `tesName`, `tesCred`, `tesDetails`,`tesImage` FROM `testimonials` WHERE `email` = '$email'";
        $checkIDRes = mysqli_query($conn, $checkID) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkIDRes) > 0){
            
            while($b = mysqli_fetch_assoc($checkIDRes)){
                $getTes[] = $b;
            }

            $status = true;
            $response = "Testimonials fetched successfully!";
            
        }else{

            $status = false;
            $response = "NO Testimonials";
        }
    }else {
        $status = false;
        $response = "email not provided!";    
    }

    $responseArray = array("status" => $status, "response" => $response, "tes" => $getTes);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
