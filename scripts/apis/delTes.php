<?php

    //connect db
    include "../db.php";

    //include header
    include "../header.php";

    //declare variables
    $status = false;
    $response = "";
    $ptid = "";
    
    if(isset($_POST)){
        $tid = $_POST['tid'];
    }


    if($tid != ""){

        $delTes = "DELETE FROM `testimonials` WHERE `id` = '$tid'";
        $delTesRes = mysqli_query($conn, $delTes) or die(mysqli_error($conn));

        if($delTesRes){
            $status = true;
            $response = "Testimonial Deleted Successfully"; 
        }else{
            $status = false;
            $response = "Unable to del testimonial";
        }

    }else{
        $status = false;
        $response = "no such testimonial found";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>