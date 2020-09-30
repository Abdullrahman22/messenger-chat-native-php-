<?php 
    $pagetitle = "Login ";
    include("includes/template/header.php");

    if( isset($_SESSION["loginUserID"]) ){
        header("Location: index.php");
    }else {
    
    

        $obj = new base_class; // this contain {db , bas_class}

        if(isset($_POST["loginBtn"])){
            $username        = $obj->security($_POST["loginUsername"] );
            $password        = $obj->security( $_POST["loginPassword"] ); 
            $username_status = $password_status = 1;
    
    
            //===================== Username Validation ==============================
    
            if( empty( $username) ){
                $username_error = "Username is required";
                $username_status = ""; // make email_status empty
            }else {
                if(strlen($username) > 25 || strlen($username) < 5 ){
                    $username_error = "Username must be between 5 and 25 characters";
                    $username_status = "";   // make email_status  empty
                }
            }
    
            //===================== Password Validation ==============================
            if( empty( $password ) ){
                $password_error = "Password is required";
                $password_status = "";
            }else{
                if(strlen($password) > 25 || strlen($password) < 5 ){
                    $username_error = "Password must be between 5 and 25 characters";
                    $username_status = "";  // make password_status  empty
                }else{
                    if( preg_match("/[^A-Za-z0-9]/" , $password)){
                        $password_error = "Password must only contain numbers and letters";
                        $password_status = ""; // make password_status  empty
                    }
                }
            }
    
            //===================== Check if user in DB ==============================
            if( !empty($username_status) && !empty($password_status)  ){
    
                $hashPassword = md5($password);
                $stmt = $obj->con->prepare("SELECT * FROM users WHERE Username = ? AND Pass = ?");
                $stmt->execute(array( $username , $hashPassword)) ;
                
                if($stmt->rowCount() > 0){  // because rowCount() must be 1 when this user has table in db
                    $sessionUserID = $obj->getUserinfo( "Username", $username , "UserID" );// get UserID by Username
                    $obj->create_session( "loginUserID" , $sessionUserID );
                    header("Location: index.php");
                }else {
                    $username_error = "Username or password is incorrect";
                    $password_error = "";                
                }

            }
    
    
    
        }
    
        ?>
            <div id="register-page">
        
                <div class="register-form">
                    
                    <div class="login-form">
                            
                        <?php
                            if( isset($_SESSION["creating_account_success"])){
                                echo '<div class="popup-messege signup-success "> ';
                                    echo '<p class="text-center">';
                                        echo $_SESSION["creating_account_success"] ;
                                    echo '</p>';
                                echo '</div>';
                            }
                            elseif ( isset($_SESSION["creating_account_failed"]) ) {
                                echo '<div class="popup-messege signup-failed "> ';
                                    echo '<p class="text-center">';
                                        echo $_SESSION["creating_account_failed"] ;
                                    echo '</p>';
                                echo '</div>';
                            }
                            unset( $_SESSION["creating_account_success"] );
                            unset( $_SESSION["creating_account_failed"] );
                        ?>
                            
                        <div class="inner">
                            <p> <i class="fas fa-user"></i> User LOGIN</p>
                            <hr>
                            <form action="<?php echo  $_SERVER["PHP_SELF"]; ?>" method="POST">
                                <div class="input-content">
                                    <input class="form-control" name="loginUsername" type="text" placeholder="Enter Username..." value="<?php  echo getInputValue("loginUsername");  ?>" autocomplete="off" required />
                                    <?php
                                        if( isset( $username_error ) ){
                                            echo '<p class="error-messege">' . $username_error . '</p>'; 
                                        }
                                    ?>  
                                </div>
                                <div class="input-content">
                                    <div class="password-content">
                                        <input class="form-control" name="loginPassword" type="password" placeholder="Enter Password..." value="<?php  echo getInputValue("loginPassword");  ?>" autocomplete="new-password" required />  
                                        <div class="eye-icons">
                                                <i class="fa fa-eye" style="display: none"></i> 
                                                <i class="fa fa-eye-slash" ></i> 
                                        </div>
                                    </div>
                                    <?php
                                        if( isset( $password_error ) ){
                                            echo '<p class="error-messege">' . $password_error . '</p>'; 
                                        }
                                    ?>     
                                </div>
                                <input type="submit" name="loginBtn" value="User Login">
                            </form>
                            <a href="signUp.php"> Create new account ?</a>
                        </div>
                    </div>
        
                </div>
                <?php
                include("componends/background-left.php");
                ?>
        
        
            </div>
        <?php include("includes/template/footer.php");
    }




