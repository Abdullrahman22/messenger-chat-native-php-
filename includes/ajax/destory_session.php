<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if (isset($_SESSION["loginUserID"])) {
    
        $sessionUserID   = $_SESSION["loginUserID"] ;


        if( isset( $_POST["destory_session"] ) ){

            $obj->updateUserInfo($sessionUserID , "Status" , 0);
            $obj->updateOfflineDate($sessionUserID );
    
        }
    
    }else{
        header("Location: ../../index.php");
    }

