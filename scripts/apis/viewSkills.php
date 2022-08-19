<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $email = "";
    $getSkill = array();
    
    //check for form data
    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }

    if($email != ""){

        //select user with respective email!
        $checkID = "SELECT * FROM `skills` WHERE `email` = '$email'";
        $checkIDRes = mysqli_query($conn, $checkID) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkIDRes) > 0){
            
            //if user exists
            $user = "SELECT `id`, `skill`, `prof` FROM `skills` WHERE `email` = '$email'";
            $userRes =  mysqli_query($conn, $user) or die(mysqli_error($conn));

            $b = mysqli_fetch_assoc($userRes);
            $getSkill[] = $b;

            $status = true;
            $response = "Skills fetched successfully!";
            
        }else{

            $status = false;
            $response = "NO skills";
        }
    }else {
        $status = false;
        $response = "email not provided!";    
    }

    $responseArray = array("status" => $status, "response" => $response, "skills" => $getSkill);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
