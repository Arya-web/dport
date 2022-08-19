<?php

    //connect db
    include "../db.php";

    //include header
    include "../header.php";

    //declare variables
    $status = false;
    $response = "";
    $pid = "";
    
    if(isset($_POST)){
        $pid = $_POST['pid'];
    }


    if($pid != ""){

        $delProj = "DELETE FROM `projects` WHERE `id` = '$pid'";
        $delProjRes = mysqli_query($conn, $delProj) or die(mysqli_error($conn));

        if($delProjRes){
            $status = true;
            $response = "Project Deleted Successfully";
        }else{
            $status = false;
            $response = "Unable to del project";
        }

    }else{
        $status = false;
        $response = "no such project found";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>