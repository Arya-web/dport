<?php

    //connect db!
    include "../db.php";

    //include header!
    include "../header.php";

    //declare variables!
    $status = false;
    $response = "";
    $skill = "";
    $prof = "";
    $email = "";
    $createdOn = date('d-m-Y H:i');
    $lastUpdatedOn = date('d-m-Y H:i');

    //getting form data!

    if(isset($_POST['skill'])){
        $skill = $_POST['skill'];
    }

    if(isset($_POST['prof'])){
        $prof = $_POST['prof'];
    }

    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }


    //check for null submits
    if($email != "" && $skill != "" && $prof != ""){

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

            if(in_Array($skill, $knownSkillsArr)){
                $key = array_search($skill, $knownSkillsArr);
                $knownProfArr[$key] = $prof;

                $newSkill = implode(",",$knownSkillsArr);
                $newProf = implode(",", $knownProfArr);

                $updateNew = "UPDATE `skills` SET `skill`='$newSkill',`prof`='$newProf', `lastUpdatedOn`='$lastUpdatedOn' WHERE `email` = '$email'";
                $updateNewRes = mysqli_query($conn, $updateNew) or die(mysqli_error($conn));

                $status = true;
                $response = "User prof updated successfully!";   
            
            }else{
                array_push($knownSkillsArr,$skill);
                array_push($knownProfArr, $prof);

                $newSkill = implode(",",$knownSkillsArr);
                $newProf = implode(",", $knownProfArr);

                $updateNew = "UPDATE `skills` SET `skill`='$newSkill',`prof`='$newProf', `lastUpdatedOn`='$lastUpdatedOn' WHERE `email` = '$email'";
                $updateNewRes = mysqli_query($conn, $updateNew) or die(mysqli_error($conn));

                $status = true;
                $response = "User skill updated successfully!"; 
            }

        }else{
            $update = "INSERT INTO `skills`(`email`,`skill`, `prof`, `createdOn`, `lastUpdatedOn`) VALUES ('$email','$skill','$prof','$createdOn','$lastUpdatedOn')";
            $updateRes = mysqli_query($conn, $update) or die(mysqli_error($conn));

            $status = true;
            $response = "User skill details added successfully!";
        }
        
    }else{
        $status = false;
        $response = "Fill all the details!";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
?>
