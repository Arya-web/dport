<?php
    // session start!
    session_start();

    // include db connection!
    include "./db.php";

    // declare variables!
    $email = "";
    $password = "";
    $salt = "";
    $encPassword = "";
    $dbPassword = "";

    // get form data!
    if(isset($_POST['email'])) {
        $email = $_POST['email'];
    }

    if(isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    // check for all the fields!
    if($email != "" && $password != "") {

        // getting user details!
        $getUser = "SELECT * FROM `users` WHERE `email` = '$email'";
        $getUserRes = mysqli_query($conn,$getUser) or die(mysqli_error($conn));

        if(mysqli_num_rows($getUserRes) > 0) {

            $getUserRow = mysqli_fetch_assoc($getUserRes);
            // get password and salt!
            $dbPassword = $getUserRow['password'];
            $salt = $getUserRow['salt'];

            // encrypt password!
            $encPassword = md5(md5($password).md5($salt));

            // check password!
            if($dbPassword == $encPassword) {
                
                $_SESSION['email'] = $email;
                header('Location: ../dashboard.php?message=Logged in successfully!');

            } else {
                
                header('Location: ../login.php?message=Password fields dont match!');

            }

        } else {

            header('Location: ../register.php?message=No such user exists!');

        }

    } else {
        header('Location: ../login.php?message=Please fill all the details!');
    }
?>