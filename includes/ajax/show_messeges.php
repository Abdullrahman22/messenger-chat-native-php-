<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if( isset($_SESSION["loginUserID"]) ){
        $sessionUserID   = $_SESSION["loginUserID"] ;
        $fid             = $_SESSION["fid"] ;
        $chat_Link       = $_SESSION["chat_Link"] ;
        
        if( isset( $_GET["messege"] ) ){





            $stmt2= $obj->con->prepare("SELECT count(chat_Link) FROM messages  WHERE chat_Link = ? ");
            $stmt2->execute( array( $chat_Link ) );
            $staffrow = $stmt2->fetch(PDO::FETCH_NUM);
            $last_row_msg = $staffrow[0];
            $last_15_row_msg = $last_row_msg - 10;
            if( $last_15_row_msg < 0 ){
                $last_15_row_msg = 0;
            }



            $stmt = $obj->con->prepare("SELECT 
                            messages.*,users.Username , users.Pic
                            FROM 
                            messages
                            INNER JOIN users ON users.UserID = messages.Sender_ID 
                            WHERE chat_Link = ? ORDER BY msg_time  LIMIT  $last_15_row_msg , $last_row_msg 
                            ");
            $stmt->execute( array( $chat_Link ) );
            $rows = $stmt->fetchAll();
            foreach( $rows as $row){


                $seenMsg = $row["seen"]; 
                if( $seenMsg == 0){
                    $mgsSeen = '<img src="assets/images/icon/double_checking_grey.png" alt="" /> ';
                }else{
                    $mgsSeen = '<img src="assets/images/icon/double_checking_green.png" alt="" /> ';   
                }



                if ( $row["Sender_ID"] == $sessionUserID ){
                    if( $row["msg_type"] == "text" ){
                        echo    '<div class="my-message">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date">
                                                <div> '. $mgsSeen . " " . $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <span class="triangle"></span>
                                                '. $row["message"] .' 
                                            </div>
                                        </div>
                                    </div>
                                
                                </div> ';
                    }elseif(  $row["msg_type"] == "emoji" ){
                        echo    '<div class="my-message my_emoji">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date"> 
                                                <div>  '. $mgsSeen . " " .  $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <img src=" '. $row["message"] .' "  alt=""/>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div> ';
                    }elseif(  $row["msg_type"] == "like" ){
                        echo    '<div class="my-message my_like">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date"> 
                                                <div>  '. $mgsSeen . " " .  $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <i class="fas fa-thumbs-up"></i>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div> ';
                    }elseif( $row["msg_type"] == "jpg" || $row["msg_type"] == "png"  || $row["msg_type"] == "png" ){
                        echo    '<div class="my-message my_photo">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date">
                                                <div>  '. $mgsSeen . " " .  $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <img src="assets/images/files-sent/'. $row["message"] .'" alt=""/>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div> ';
                    }elseif( $row["msg_type"] == "pdf" ){
                        echo    '<div class="my-message my_pdf">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date">
                                                <div>  '. $mgsSeen . " " .  $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <span class="triangle"></span>
                                                <a href="assets/images/files-sent/'. $row["message"] .'"> <i class="far fa-file-pdf"></i> &nbsp;' . $row["message"] . '</a>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div> ';
                    
                    
                    }elseif( $row["msg_type"] == "docx" ){
                        echo    '<div class="my-message my_docx">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date">
                                                <div>  '. $mgsSeen . " " .  $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <span class="triangle"></span>
                                                <a href="assets/images/files-sent/'. $row["message"] .'"> <i class="far fa-file-word"></i> &nbsp;' . $row["message"] . '</a>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div> ';
                    
                    }elseif( $row["msg_type"] == "xlsx"  || $row["msg_type"] == "xls" ){
                        echo    '<div class="my-message my_xlsx">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date">
                                                <div>  '. $mgsSeen . " " .  $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <span class="triangle"></span>
                                                <a href="assets/images/files-sent/'. $row["message"] .'"> <img src="assets/images/icon/xlsx-file.png" class="icon" alt=""/> &nbsp;' . $row["message"] . '</a>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div> ';
                    
                    }elseif( $row["msg_type"] == "txt" ){
                        echo    '<div class="my-message my_txt">

                                    <div class="my-message-inner">
                                        <div class="my-message-content">
                                            <div class="date">
                                                <div>  '. $mgsSeen . " " .  $obj->time_ago( $row["msg_time"])  .'  </div>
                                            </div>
                                            <div class="message">
                                                <span class="triangle"></span>
                                                <a href="assets/images/files-sent/'. $row["message"] .'"> <img src="assets/images/icon/txt-file.png" class="icon" alt=""/> &nbsp;' . $row["message"] . '</a>
                                            </div>
                                        </div>
                                    </div>
                            
                                </div> ';
                    
                    }

                }elseif( $row["Sender_ID"] == $fid ){


                    if( $row["msg_type"] == "text" ){
                        echo    '<div class="friend-messege">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                            <span class="date ">
                                                <div> '. $obj->time_ago( $row["msg_time"])  .'   </div>
                                            </span>
                                        </div>
                                        <div class="message">
                                            <span class="triangle"></span>
                                            '. $row["message"] .' 
                                        </div>
                                    </div>
                                </div>';
                    }elseif(  $row["msg_type"] == "emoji" ){

                        echo    '<div class="friend-messege friend_emoji">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                            <span class="date">
                                                <div> '. $obj->time_ago( $row["msg_time"])  .'    </div>
                                            </span>
                                        </div>
                                        <div class="message">
                                            <img src=" '. $row["message"] .' "  alt=""/>
                                        </div>
                                    </div>
                                </div>';
                    }elseif(  $row["msg_type"] == "like" ){

                        echo    '<div class="friend-messege friend_like">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                            <span class="date">
                                                <div> '. $obj->time_ago( $row["msg_time"])  .'    </div>
                                            </span>
                                        </div>
                                        <div class="message">
                                            <i class="fas fa-thumbs-up"></i>
                                        </div>
                                    </div>
                                </div>';
                    }elseif( $row["msg_type"] == "jpg" || $row["msg_type"] == "png"  || $row["msg_type"] == "png" ){
                        echo    '<div class="friend-messege friend_photo">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                            <span class="date">
                                                <div> '. $obj->time_ago( $row["msg_time"])  .'     </div>
                                            </span>
                                        </div>
                                        <div class="message">
                                            <img src="assets/images/files-sent/'. $row["message"] .'" alt=""/>
                                        </div>
                                    </div>
                                </div>';
                    }elseif( $row["msg_type"] == "pdf" ){
                        echo    '<div class="friend-messege friend_pdf">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                        <span class="date">
                                            <div> '. $obj->time_ago( $row["msg_time"])  .'     </div>
                                        </span>
                                        </div>
                                        <div class="message">
                                            <span class="triangle"></span>
                                            <a href="assets/images/files-sent/'. $row["message"] .'"> <i class="far fa-file-pdf"></i> &nbsp;' . $row["message"] . '</a>
                                        </div>
                                    </div>
                                </div>';
                    }elseif( $row["msg_type"] == "docx" ){
                        echo    '<div class="friend-messege friend_docx">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                            <span class="date">
                                                <div> '. $obj->time_ago( $row["msg_time"])  .'     </div> 
                                            </span>
                                        </div>
                                        <div class="message">
                                            <span class="triangle"></span>
                                            <a href="assets/images/files-sent/'. $row["message"] .'"> <i class="far fa-file-word"></i> &nbsp;' . $row["message"] . '</a>
                                        </div>
                                    </div>
                                </div>';
                    }elseif( $row["msg_type"] == "xlsx" ||  $row["msg_type"] == "xls"  ){
                        echo    '<div class="friend-messege friend_xlsx">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                            <span class="date">
                                                <div> '. $obj->time_ago( $row["msg_time"])  .'     </div>
                                            </span>
                                        </div>
                                        <div class="message">
                                            <span class="triangle"></span>
                                            <a href="assets/images/files-sent/'. $row["message"] .'"> <img src="assets/images/icon/xlsx-file.png" class="icon" alt=""/> &nbsp;' . $row["message"] . '</a>
                                        </div>
                                    </div>
                                </div>';
                    }elseif( $row["msg_type"] == "txt" ){
                        echo    '<div class="friend-messege friend_txt">
                                    <div class="friend-messege-content">
                                        <div class="friend-info">
                                            <span class="date">
                                                <div> '. $obj->time_ago( $row["msg_time"])  .'    </div>
                                            </span>
                                        </div>
                                        <div class="message">
                                            <span class="triangle"></span>
                                            <a href="assets/images/files-sent/'. $row["message"] .'"> <img src="assets/images/icon/txt-file.png" class="icon" alt=""/> &nbsp;' . $row["message"] . '</a>
                                        </div>
                                    </div>
                            
                                </div>';
                    
                    }


                }
            }











            
        }


    }else{
        header("Location: ../../index.php");
    }
