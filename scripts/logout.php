<?php
    // session start!
    session_start();
    
    // session unset!
    unset($_SESSION['email']);

    // session destroy!
    session_destroy();

    header('Location: ../index.html?message=Successfully logged out!');
?>