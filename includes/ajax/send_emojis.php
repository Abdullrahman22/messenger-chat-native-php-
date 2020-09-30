<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if( isset($_SESSION["loginUserID"]) ){


        $sessionUserID   = $_SESSION["loginUserID"] ;
        $fid             = $_SESSION["fid"] ;
        $chat_Link       = $_SESSION["chat_Link"] ;
        

        if( isset( $_POST["send_emoji"] ) ){

            $emoji = $obj->security( $_POST["send_emoji"] );
            $msg_type = "emoji";


            $stmt = $obj->con->prepare(" INSERT INTO 
                        messages ( chat_Link ,  message , msg_type , Sender_ID , Receiver_ID )
                        VALUES( :zchat_Link , :zmessage , :zmsg_type , :zSender_ID , :zReceiver_ID ) ");
            $stmt->execute(array(
            ":zchat_Link"    => $chat_Link,
            ":zmessage"      => $emoji,
            ":zmsg_type"     => $msg_type,
            ":zSender_ID"    => $sessionUserID,
            ":zReceiver_ID"  => $fid,
            ));
            
            if( $stmt ){
                echo json_encode(["status" => "success" ]); 
            }else{
                echo json_encode(["status" => "error" ]); 
            }
        }


    }else{
        header("Location: ../../index.php");
    }
