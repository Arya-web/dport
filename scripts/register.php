<?php
    // Include db connection!
    include "./db.php";

    // declare variables!
    $email = "";
    $password = "";
    $encPassword = "";
    $salt = uniqid();
    $createdAt = date('d-m-Y H:i');
    $lastUpdatedOn = date('d-m-Y H:i');

    // getting form data!
    
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if(isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    // check for all fields!
    if($email != "" && $password != "") {

        // check if user exists!
        $checkUser = "SELECT * FROM `users` WHERE `email` = '$email'";
        $checkUserRes = mysqli_query($conn,$checkUser) or die(mysqli_error($conn));

        if(mysqli_num_rows($checkUserRes) > 0) {

            header('Location: ../login.php?message=User already exists login to continue!');

        } else {
            
            // encrypting password
            $encPassword = md5(md5($password).md5($salt));

            // Register user!
            $registerUser = "INSERT INTO `users`(`email`, `password`, `salt`, `createdAt`, `lastUpdatedOn`) 
                                            VALUES('$email','$encPassword','$salt','$createdAt','$lastUpdatedOn')";
            $registerUserRes = mysqli_query($conn,$registerUser) or die(mysqli_error($conn));

            if($registerUserRes) {

                header('Location: ../login.php?message=Login to proceed!');

            } else {

                header('Location: ../register.php?message=Unable to register user!');

            }

        }

    } else {
        header('Location: ../register.php?message=Please fill all the details!');
    }
?>