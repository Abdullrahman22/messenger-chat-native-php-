<?php
    $pagetitle = "Change Account name"; 
    include("includes/template/header.php");

    if( isset($_SESSION["loginUserID"]) ){

        $obj = new base_class; // this contain {db , bas_class}
        $sessionUserID   = $_SESSION["loginUserID"] ;
        $obj->updateUserInfo($sessionUserID , "Status" , 1);



        if(isset($_POST["submitBtn"])){

            $newName        = $obj->security($_POST["newName"] );
            $newName_status = 1 ;
        
            //===================== Username Validation ==============================
            if( empty( $newName ) ){
                $newName_error = "This faild is required";
                $newName_status = ""; // make email_status empty
            }else {
                if(strlen($newName) > 25 || strlen($newName) < 5 ){
                    $newName_error = "Username must be between 5 and 25 characters";
                    $newName_status = "";   // make email_status  empty
                }
            }
            //===================== Update Username ==============================
            if( !empty($newName_status)  ){
                $changeName = $obj->updateUserInfo($sessionUserID , "Username" , $newName );
                if( $changeName->rowCount() > 0 ){
                    $obj->create_session( "change_name_success" , "<i class='fas fa-check'></i> &nbsp; Your name has been changed" );
                    header("Location: index.php");
                }else {
                    $newName_error = "Sorry error at changing name";
                    $newName_status = ""; // make email_status empty
                }
            }

        }
        ?>
        <div id="chat-page">
    
    
            <div class="left-navbar"> <?php include("componends/left-navbar.php");?> </div> 
            <div class="fixed-menu">  <?php include("componends/left-navbar.php");?> </div> 
            <?php include("componends/user-setting.php");?>  

    
            <div class="right-section">
    
                <div class="overlay"></div>
                <div class="top-bar">
                    <i class="fas fa-bars"></i>
                </div>
    
                <div class="change-name">
                    <h2>Change Name</h2>
                    <hr>
                    <form action="<?php echo  $_SERVER["PHP_SELF"]; ?>"  method="POST">
                        <div class="input-content">
                            <input type="text" name="newName" class="form-control" value="<?php  echo getInputValue("newPass");  ?>" placeholder="New Name..." autocomplete="off" />
                            <?php
                                if( isset( $newName_error ) ){
                                    echo '<p class="error-messege">' . $newName_error . '</p>'; 
                                }
                            ?>
                        </div>
                        <input type="submit" name="submitBtn" value="Save Changes" />
                    </form>
                </div>
    
            </div>
            
        </div>
    
        
        <?php include("includes/template/footer.php");


    }else {
        header("Location: logIn.php");
    }


