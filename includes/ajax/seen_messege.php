<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if( isset($_SESSION["loginUserID"]) ){
        

        if( isset( $_POST["fid"] ) ){

            $sessionUserID   = $_SESSION["loginUserID"] ;
            $fid = $_POST["fid"];
            if( $sessionUserID > $fid ){
                $chat_Link = $sessionUserID . "_" . $fid;
            }else{
                $chat_Link = $fid . "_" . $sessionUserID;
            }

            $obj->messegeSeen( $chat_Link , $fid );

  
        }


    }else{
        header("Location: ../../index.php");
    }
/*

    echo json_encode(["status" => "sessionUserID =>  " . $sessionUserID . " / fid => " . $fid . " / chat_Link => " . $chat_Link  ]); 








*/