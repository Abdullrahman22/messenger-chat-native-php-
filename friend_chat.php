<?php
    $pagetitle = "Home"; 
    $chat_page = "_";
    include("includes/template/header.php");

    if( isset($_SESSION["loginUserID"]) ){

        $obj = new base_class; // this contain {db , bas_class}
        $sessionUserID   = $_SESSION["loginUserID"] ;
        $obj->updateUserInfo($sessionUserID , "Status" , 1);



        
        if( isset($_GET["fid"]) && is_numeric($_GET["fid"]) ){
            $fid = intval( $_GET["fid"] ); // dont forget id not found in db
            $obj->create_session( "fid" , $fid );

            $stmt = $obj->con->prepare("SELECT * FROM users WHERE UserID = ? ");
            $stmt->execute( array( $fid ));
            $count = $stmt->rowCount();
            if( $count == 0 ){
                header("Location: index.php");
            }

            if( $fid == $sessionUserID ){
                header("Location: index.php");
            }
            if( $sessionUserID > $fid ){
                $chat_Link = $sessionUserID . "_" . $fid;
            }else{
                $chat_Link = $fid . "_" . $sessionUserID;
            }
            $obj->create_session( "chat_Link" , $chat_Link );

            
        }else{
            header("Location: index.php");
        }

?>
        <div id="chat-page">

            <div class="left-navbar"> <?php include("componends/left-navbar.php");?> </div> 
            <div class="fixed-menu">  <?php include("componends/left-navbar.php");?> </div> 
            <?php include("componends/user-setting.php");?>  
            
    
            <div class="right-section">

                <?php include("componends/change-name-messege.php");?>
                <?php include("componends/change-pass-messege.php");?>
                <?php include("componends/change-image-messege.php");?>

                <div class="overlay"></div>
                <?php include("componends/emojis.php");?>
                <div class="top-bar">
                    <i class="fas fa-bars"></i>
                    <span class="alert-messege">  &nbsp;  </span>
                    <div class="friend-info-box">
                        
                    </div>
                </div>
                <div class="chat-area">
                    <div class="custom-container">
                     

                    

                    </div>
                </div>
                <?php include("componends/msg-problem.php");?>
                <?php include("componends/keyboard-section.php");?>
            </div>
            
        </div>    
        <?php include("includes/template/footer.php");

    }else{
        header("Location: login.php");
    }