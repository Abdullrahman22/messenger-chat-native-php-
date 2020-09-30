<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if( isset($_SESSION["loginUserID"]) ){
        $sessionUserID   = $_SESSION["loginUserID"] ;
        
        if( isset( $_GET["friends_box"] ) ){


            $statment = $obj->con->prepare(" SELECT DISTINCT `chat_Link` FROM `messages` WHERE `Sender_ID` = ? OR `Receiver_ID` = ? GROUP By `msg_id` DESC LIMIT 9999");
            $statment->execute( array( $sessionUserID , $sessionUserID ) );
            $rows = $statment->fetchAll();

            foreach ($rows  as $row) {

                $friendId = str_replace( $sessionUserID ,"", $row["chat_Link"] );
                $friendId = str_replace( "_" ,"", $friendId);
                
                

                $stmt = $obj->con->prepare("SELECT * FROM `users` WHERE UserID = ? LIMIT 1 ");
                $stmt->execute( array( $friendId ) );
                $user = $stmt->fetch();

                if( $sessionUserID > $friendId ){
                    $chating_Link = $sessionUserID . "_" . $friendId;
                }else{
                    $chating_Link = $friendId . "_" . $sessionUserID;
                }






                $stmt2 = $obj->con->prepare("SELECT * FROM `messages` WHERE `Sender_ID` = ? AND `Receiver_ID` = ? AND `seen` = 0  ");
                $stmt2->execute( array( $friendId , $sessionUserID ) );
                $count = $stmt2->rowCount();
                ?>


                <div class="friend-messge-box <?php if( $count > 0 ){ echo "custom-alert" ;} ?>" onclick="location.href='friend_chat.php?fid=<?php echo $user['UserID'] ;?>'" uid = "<?php echo $user['UserID'] ;?>"> <!-- only way to dire-->
                    <?php
                        $count_unseen_messege   = $obj->count_unseen_messege( $friendId , $sessionUserID  );
                        if( $count_unseen_messege == "" ){
                            $count_unseen_messege = "0" ;
                        }
                        if( $count_unseen_messege >= 10 ){
                            $count_unseen_messege = "+9";
                        }
                        if( $count > 0 ){
                            echo '<span class="not_seen_num">' . $count_unseen_messege . "</span>";
                        }
                        
                    ?>
                    <div class="friend-img">
                        <img src="assets/images/users-img/<?php  echo  $user["Pic"]  ; ?>" alt="">
                        <span class="user-status <?php if($user['Status'] == 0){ echo "offline";} else{ echo "online"; } ?>"></span>
                    </div>
                    <div class="messege-info">
                        <div class="friend-name">
                            <?php  echo ucfirst( $user["Username"] ); ?>
                        </div>
                        <div class="friend-messge">
                            <?php
                            
                                if( $obj->getLastMsgSender($chating_Link) == $sessionUserID ){
                                    $sender = "You : ";
                                }else{
                                    $sender = " ";
                                }
                                if($obj->getLastMsg($chating_Link) == ""){
                                    echo 'Say Hi Now !! <img src="assets/images/icon/waving-icon.png" class="waving-icon" alt=""/> ';
                                }else{

                                    if( $obj->getLastMsgType($chating_Link) == "text" ){

                                        echo $sender . $obj->getLastMsg($chating_Link) ;

                                    }elseif( $obj->getLastMsgType($chating_Link) == "jpg" || $obj->getLastMsgType($chating_Link) == "png" || $obj->getLastMsgType($chating_Link) == "jpeg"  ){
                                        
                                        echo $sender .  '<i class="far fa-images"></i> ' . $obj->getLastMsg($chating_Link) ;

                                    }elseif( $obj->getLastMsgType($chating_Link) == "pdf" ){
                                        
                                        echo $sender .  '<i class="far fa-file-pdf"></i> ' . $obj->getLastMsg($chating_Link) ;

                                    }elseif( $obj->getLastMsgType($chating_Link) == "doxc" ){
                                        
                                        echo $sender .  '<i class="far fa-file-word"></i> ' . $obj->getLastMsg($chating_Link) ;

                                    }elseif(  $obj->getLastMsgType($chating_Link) == "xls" || $obj->getLastMsgType($chating_Link) == "xlsx"  ){
                                        
                                        echo $sender .  '<img src="assets/images/icon/xlsx-file.png" class="icon" alt=""/> ' . $obj->getLastMsg($chating_Link) ;

                                    }elseif( $obj->getLastMsgType($chating_Link) == "txt" ){
                                        
                                        echo $sender .  ' <img src="assets/images/icon/txt-file.png" class="icon" alt=""/> ' . $obj->getLastMsg($chating_Link) ;

                                    }elseif( $obj->getLastMsgType($chating_Link) == "emoji" ){
                                        
                                        echo  $sender .  '<img src="'. $obj->getLastMsg($chating_Link) .  '" class="emoji"/>' ;

                                    }elseif( $obj->getLastMsgType($chating_Link) == "like" ){
                                        
                                        echo   '<div class="like" > ' . $sender . $obj->getLastMsg($chating_Link) .'  </div>'  ;

                                    }


                                }

                            ?>
                        </div>
                    </div>
                </div>

                <?php
                
            }














            
        }


    }else{
        header("Location: ../../index.php");
    }
