<?php
    $pagetitle = "Change Account Name"; 
    include("includes/template/header.php");

    if( isset($_SESSION["loginUserID"]) ){

        $obj = new base_class; // this contain {db , bas_class}
        $sessionUserID   = $_SESSION["loginUserID"] ;
        $obj->updateUserInfo($sessionUserID , "Status" , 1);



        if(isset($_POST["submitBtn"])){
    
            $currentPass  = $obj->security(  $_POST["currentPass"] );
            $newPass      = $obj->security(  $_POST["newPass"] );
            $reNewPass    = $obj->security(  $_POST["reNewPass"] );
            $currentPass_status = $newPass_status = $reNewPass_status = 1 ;  // make status not empty;
            //===================== Password Validation ==============================
            $dbPassword =  $obj->getUserinfo( "UserID" , $sessionUserID , "Pass" );

            if( empty( $currentPass ) ){
                $currentPass_error = "Password is required";
                $currentPass_status = "";
            }else{
                if( md5($currentPass) != $dbPassword){
                    $currentPass_error  = "Please insert correct password";
                    $currentPass_status = ""; // make password_status  empty
                }
            }
            //===================== newPass Validation ==============================
            if( empty( $newPass ) ){
                $newPass_error = "Password is required";
                $newPass_status = "";
            }else{
                if(strlen($newPass) > 25 || strlen($newPass) < 5 ){
                    $newPass_error = "Password must be between 5 and 25 characters";
                    $newPass_status = "";  // make password_status  empty
                }else{
                    if( preg_match("/[^A-Za-z0-9]/" , $newPass)){
                        $newPass_error = "Password must only contain numbers and letters";
                        $newPass_status = ""; // make password_status  empty
                    }
                }
            }
            //===================== newPass Validation ==============================
            if( empty( $reNewPass ) ){
                $reNewPass_error = "Password is required";
                $reNewPass_status = "";
            }else{
                if ( $reNewPass != $newPass ){
                    $reNewPass_error = "Passwords do not match ";
                    $reNewPass_status = ""; 
                }
            }
            //===================== update password in db database ==============================
            if( !empty($currentPass_status) && !empty($newPass_status) && !empty($reNewPass_status)  ){

                $changePass = $obj->updateUserInfo($sessionUserID , "Pass" , md5($newPass) );
                if( $changePass->rowCount() > 0 ){
                    $obj->create_session( "change_pass_success" , "<i class='fas fa-check'></i> &nbsp; Your password has been changed" );
                    header("Location: index.php");
                }else {
                    $currentPass_error = "Sorry error at changing password";
                    $currentPass_status = "";   // make email_status  empty
                }

            }
        }
    
    
    
    
    
    
        ?>
            <div id="chat-page" class="change-password-page">
        
                <div class="left-navbar"> <?php include("componends/left-navbar.php");?> </div> 
                <div class="fixed-menu">  <?php include("componends/left-navbar.php");?> </div> 
                <?php include("componends/user-setting.php");?>  

        
                <div class="right-section">
        
                    <div class="overlay"></div>
                    <div class="top-bar">
                        <i class="fas fa-bars"></i>
                    </div>
        
                    <div class="change-password">
                            <h2>Change Password</h2>
                            <hr>
                            <form action="<?php echo  $_SERVER["PHP_SELF"]; ?>" method="POST"  >
                                <div class="input-content">
                                    <div class="password-content">
                                        <input type="password" name="currentPass" class="form-control" placeholder="Enter Currently Password..." value="<?php  echo getInputValue("currentPass");  ?>"  autocomplete="new-password" />
                                        <div class="eye-icons">
                                                <i class="fa fa-eye" style="display: none" ></i> 
                                                <i class="fa fa-eye-slash" ></i> 
                                        </div>
                                    </div>
                                    <?php
                                        if( isset( $currentPass_error ) ){
                                            echo '<p class="error-messege">' . $currentPass_error . '</p>'; 
                                        }
                                    ?>
                                </div>
                                <div class="input-content">
                                    <div class="password-content">
                                        <input type="password" name="newPass"   class="form-control" placeholder="Enter New Password..." value="<?php  echo getInputValue("newPass");  ?>" autocomplete="new-password" />
                                        <div class="eye-icons">
                                                <i class="fa fa-eye" style="display: none" ></i> 
                                                <i class="fa fa-eye-slash" ></i> 
                                        </div>
                                    </div>
                                    <?php
                                        if( isset( $newPass_error ) ){
                                            echo '<p class="error-messege">' . $newPass_error . '</p>'; 
                                        }
                                    ?>
                                </div>
                                <div class="input-content">
                                    <div class="password-content">
                                        <input type="password" name="reNewPass" class="form-control" placeholder="Confirm Password..." value="<?php  echo getInputValue("reNewPass");  ?>" autocomplete="new-password" />
                                        <div class="eye-icons">
                                                <i class="fa fa-eye" style="display: none"></i> 
                                                <i class="fa fa-eye-slash" ></i> 
                                        </div>
                                    </div>
                                    <?php
                                        if( isset( $reNewPass_error ) ){
                                            echo '<p class="error-messege">' . $reNewPass_error . '</p>'; 
                                        }
                                    ?>
                                </div>
                                <input type="submit"  name="submitBtn" value="Save Changes" required/>
                            </form>
                        </div>
                    </div>
        
                </div>
        
            </div>
        
        
        <?php include("includes/template/footer.php");          



    }else {
        header("Location: logIn.php");
    }


