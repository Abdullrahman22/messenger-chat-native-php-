<?php

    include("includes/template/header.php");
    $obj = new base_class; // this contain {db , bas_class}
    session_start();
    $sessionUserID   = $_SESSION["loginUserID"] ;
    $obj->updateUserInfo($sessionUserID , "Status" , 0);

    session_unset();
    session_destroy();
    header("location: login.php");

    exit();