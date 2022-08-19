<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $sid = "";
    $email = "";
    $lastUpdatedOn = date('d-m-Y H:i');

    //getting form data!

    if(isset($_POST['sid'])){
        $sid = $_POST['sid'];
    }

    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }


    //check for null submits
    if($sid != ""){

        //select user with that email
        $user = "SELECT * FROM `skills` WHERE `email` = '$email'";
        $userRes = mysqli_query($conn, $user) or die(mysqli_error($conn));

        //check if user exists
        if(mysqli_num_rows($userRes) > 0){

            $check = mysqli_fetch_assoc($userRes);
            $knownSkills = $check['skill'];
            $knownProf = $check['prof'];

            $knownSkillsArr = explode(",", $knownSkills);
            $knownProfArr = explode(",", $knownProf);

            unset($knownSkillsArr[$sid]);
            unset($knownProfArr[$sid]);

            $newSkill = implode(",",$knownSkillsArr);
            $newProf = implode(",", $knownProfArr);

            $updateNew = "UPDATE `skills` SET `skill`='$newSkill',`prof`='$newProf', `lastUpdatedOn`='$lastUpdatedOn' WHERE `email` = '$email'";
            $updateNewRes = mysqli_query($conn, $updateNew) or die(mysqli_error($conn));

            $status = true;
            $response = "User skill deleted successfully!";

        }else{
            $status = false;
            $response = "No such user exists";
        }
        
    }else{
        $status = false;
        $response = "Fill all the details!";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
