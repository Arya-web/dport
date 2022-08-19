<?php

    //include db
    include "../db.php";

    // include header
    include "../header.php";

    //vars!
    $status = false;
    $response = "";
    $email = "";

    //getting val!
    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }

    //null check!
    if($email != ""){

        //getting username
        $user = "SELECT * FROM `users` WHERE `email` = '$email'";
        $userRes = mysqli_query($conn, $user) or die(mysqli_error($conn));
        $userResRow = mysqli_fetch_assoc($userRes);
        $username = $userResRow['name'];
        $siteURL = "./portfolio/".$username;        

        ob_start();
        include("../../templates/template1/template1.php");
        $php_to_html = ob_get_clean();
        
    
        if(!is_dir("../../portfolio/".$username)){
            mkdir("../../portfolio/".$username);
        }
        $htmlFile = fopen("../../portfolio/".$username."/index.html", "w") or die("Unable to open file!");
        $html = $php_to_html;
        fwrite($htmlFile, $html);

        copy('../../templates/template1/style.css','../../portfolio/'.$username.'/style.css');
        copy('../../templates/template1/main.js','../../portfolio/'.$username.'/main.js');

        $createSite = "UPDATE `users` SET `site` = '$siteURL' WHERE `email` = '$email'";
        $createSiteRes = mysqli_query($conn, $createSite) or die(mysqli_error($conn));

        $status = true;
        $response = "./portfolio/".$username;

    }else{
        $status = false;
        $response = "Email not found";
    }

    $responseArray = array("status" => $status, "response" => $response);
    echo json_encode($responseArray, JSON_PRETTY_PRINT);
