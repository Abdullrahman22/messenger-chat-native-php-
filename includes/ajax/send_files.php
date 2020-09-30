<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if( isset($_SESSION["loginUserID"]) ){


        $sessionUserID   = $_SESSION["loginUserID"] ;
        $fid             = $_SESSION["fid"] ;
        $chat_Link       = $_SESSION["chat_Link"] ;


        if( isset($_FILES["file"]["name"]) ){
            $file_name       =  $_FILES["file"]["name"] ;
            $file_name_rand  = rand(0 , 1000) . "_" . $file_name;
            $file_name_rand  = str_replace( " " ,"_", $file_name_rand);
            $tmp_name        =  $_FILES["file"]["tmp_name"] ;
            $store_files     =  "../../assets/images/files-sent/";
            $extentions      = array("jpg" ,"png" , "jpeg" , "pdf" , "doxc" , "xlsx" , "xls" , "txt");
            $get_file_extention = explode("." , $file_name);
            $get_extention  = strtolower( end($get_file_extention) ) ;
            if( !in_array( $get_extention , $extentions) ){
                echo "Unvalidate file" ;
            }else{

                $obj->fix_rotate_jpg_image($tmp_name);
                move_uploaded_file( $tmp_name , "$store_files/$file_name_rand");
                $stmt = $obj->con->prepare(" INSERT INTO 
                            messages ( chat_Link , message , msg_type , Sender_ID , Receiver_ID)
                            VALUES( :zchat_Link , :zmessage , :zmsg_type , :zSender_ID , :zReceiver_ID ) ");
                $stmt->execute(array(
                ":zchat_Link"    => $chat_Link,
                ":zmessage"      => $file_name_rand,
                ":zmsg_type"     => $get_extention,
                ":zSender_ID"    => $sessionUserID,
                ":zReceiver_ID"  => $fid,
                ));

                if( $stmt ){
                    echo "file sent" ;
                }else{
                    echo "error connection" ;
                }
            }
        }

    }else{
        header("Location: login.php");
    }

