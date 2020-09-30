<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if (isset($_SESSION["loginUserID"])) {
    
        $sessionUserID   = $_SESSION["loginUserID"] ;

        
        if( isset( $_GET["search_content"] ) ){

    
            $search_content = $_GET["search_content"] ; 
    
    
            $stmt = $obj->con->prepare(" SELECT * FROM `users` WHERE `Username` = ? AND UserID != ? LIMIT 1");
            $stmt->execute(array( $search_content , $sessionUserID ));
            $user = $stmt->fetch();
            $count = $stmt->rowCount();

            if( $count == 1 ){

                $friendId = $user['UserID'];
                if( $sessionUserID > $friendId ){
                    $chating_Link = $sessionUserID . "_" . $friendId;
                }else{
                    $chating_Link = $friendId . "_" . $sessionUserID;
                }

                ?>

                    <div class="friend-messge-box" onclick="location.href='friend_chat.php?fid=<?php echo $user['UserID'] ;?>'" uid = "<?php echo $user['UserID'] ;?>"> <!-- only way to dire-->
                        <div class="friend-img">
                            <img src="assets/images/users-img/<?php  echo  $user["Pic"]  ; ?>" alt="">
                            <span class="user-staus <?php if($user['Status'] == 0){ echo "offline";} else{ echo "online"; } ?>"></span>
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
            }else{
                ?>
                
                    <div class="no_data text-center">
                        <img src="assets/images/icon/no_data.png" alt="">
                        <p >Name Not Found !</p>
                    </div>

                <?php
            }
    
    
    
    
        }
    
    }else{
        header("Location: ../../index.php");
    }

