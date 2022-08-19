<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Content-type: application/json');
    header("Access-Control-Max-Age: 1000");
    header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding, enctype");
    header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
?>