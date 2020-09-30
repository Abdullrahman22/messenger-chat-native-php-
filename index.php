<?php
    $pagetitle = "Home"; 
    include("includes/template/header.php");

    if( isset($_SESSION["loginUserID"]) ){


        unset( $_SESSION["fid"] );
        unset( $_SESSION["chat_Link"] );

        

        $obj = new base_class; // this contain {db , bas_class}
        $sessionUserID   = $_SESSION["loginUserID"] ;
        $obj->updateUserInfo($sessionUserID , "Status" , 1);

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
                    <span class="alert-messege" > &nbsp; </span>
                </div>

                <div class="home-bg text-center">
                    <img src="assets/images/icon/Illustrations.png" alt="" />
                </div>
            </div>
            
        </div>    
        <?php include("includes/template/footer.php");

    }else{
        header("Location: login.php");
    }




