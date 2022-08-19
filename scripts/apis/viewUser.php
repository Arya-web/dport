<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $email = "";
    $getUser = array();
    
    //check for form data
    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }

    //check if id param is given
    if($email != ""){

        //select user with respective email!
        $checkID = "SELECT * FROM `users` WHERE `email` = '$email'";
        $checkIDRes = mysqli_query($conn, $checkID) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkIDRes) > 0){
            
            //if user exists
            $user = "SELECT `id`, `name`, `techstack`, `about`,`site`,`userImage` FROM `users` WHERE `email` = '$email'";
            $userRes =  mysqli_query($conn, $user) or die(mysqli_error($conn));

            $b = mysqli_fetch_assoc($userRes);
            $getUser[] = $b;

            $status = true;
            $response = "User fetched successfully!";
            
        }else{

            $status = false;
            $response = "Invaild email ";
        }
    }else {
        $status = false;
        $response = "email not provided!";    
    }

    $responseArray = array("status" => $status, "response" => $response, "user" => $getUser);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
