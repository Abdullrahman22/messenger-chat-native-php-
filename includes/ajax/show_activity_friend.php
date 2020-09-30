<?php

    include("../../init.php");
    $obj = new base_class; // this contain {db , bas_class}

    if( isset($_SESSION["loginUserID"]) ){

        
        $sessionUserID   = $_SESSION["loginUserID"] ;
        $fid             = $_SESSION["fid"] ;
        $chat_Link       = $_SESSION["chat_Link"] ;
        
        
        if( isset( $_GET["messege"] ) ){

            



            $friendImg        = $obj->getUserinfo( "UserID" , $fid , "Pic" );
            $friendName       = $obj->getUserinfo( "UserID" , $fid , "Username" );
            $friendStatus     = $obj->getUserinfo( "UserID" , $fid , "Status" );
            $last_time_online = $obj->getUserinfo( "UserID" , $fid , "offline_date" );
            ?>
            <div class="friend-img">
                <img src="assets/images/users-img/<?php  echo $friendImg; ?>" alt="">
                <span class="user-staus <?php if( $friendStatus == 0){ echo "offline";} else{ echo "online"; } ?>"></span>
            </div>
            <div class="friend-info">
                <div class="friend-name"> <?php echo ucfirst( $friendName ); ?> </div>
                <div class="friend-status">
                    <?php
                        if( $friendStatus == 1){
                            echo "<p class='active-now'>Active now..</p>";
                        } else{
                            echo "<p class='offline-now'>". $obj->time_ago_offline( $last_time_online ) ."</p>";
                        } 
                    ?> 
                </div>
            </div>
            <?php

        }


    }else{
        header("Location: ../../index.php");
    }
