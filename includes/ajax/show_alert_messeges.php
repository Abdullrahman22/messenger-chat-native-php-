<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if( isset($_SESSION["loginUserID"]) ){
        $sessionUserID   = $_SESSION["loginUserID"] ;
        
        if( isset( $_GET["messege"] ) ){

            $stmt = $obj->con->prepare("SELECT * FROM `messages` WHERE `Receiver_ID` = ? AND `seen` = 0  ");
            $stmt->execute( array( $sessionUserID ) );
            $count = $stmt->rowCount();
            
            if( $count > 0 ){
                echo "alert";
            }else{
                echo "no_alert";
            }
        }


    }else{
        header("Location: ../../index.php");
    }
