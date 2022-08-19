<?php

    //connect db
    include "../db.php";

    //include header
    include "../header.php";

    //declare variables
    $status = false;
    $response = "";
    $bid = "";
    
    if(isset($_POST)){
        $bid = $_POST['bid'];
    }


    if($bid != ""){

        $delBlog = "DELETE FROM `blogs` WHERE `id` = '$bid'";
        $delBlogRes = mysqli_query($conn, $delBlog) or die(mysqli_error($conn));

        if($delBlogRes){
            $status = true;
            $response = "Blog Deleted Successfully";
        }else{
            $status = false;
            $response = "Unable to delete blog";
        }

    }else{
        $status = false;
        $response = "no such blog found";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>