<?php 
    $pagetitle = "SignUp ";
    include("includes/template/header.php");

    if( isset($_SESSION["loginUserID"]) ){
        header("Location: index.php");
    }else {
        


        $obj = new base_class; // this contain {db , bas_class}
        if(isset($_POST["signUpBtn"])){
    
            $username      = $obj->security($_POST["username"] );
            $email         = $obj->security( $_POST["email"] );
            $password      = $obj->security( $_POST["password"] ); 
            $img_name      = $_FILES["img"]["name"];
            $img_name_rand = rand(0 , 1000) . "_" . $img_name;
            $img_tmp       = $_FILES["img"]["tmp_name"]; 
            $img_path      = "assets/images/users-img/";
            $extentions    = array("jpg" , "jpeg" , "png" );
            $img_ext       = explode("." , $img_name_rand); // explode mean that put every word in string at elements in array
            $img_extention = strtolower( end($img_ext) );  // last word in array "extention"
    









            $username_status = $email_status = $password_status = $img_status = 1 ;  // make status not empty;
    
    
            //===================== Username Validation ==============================
            if( empty( $username ) ){
                $username_error = "Username is required";
                $username_status = ""; // make email_status empty
            }else {
                if(strlen($username) > 16 || strlen($username) < 5 ){
                    $username_error = "Username must be between 5 and 25 characters";
                    $username_status = "";   // make email_status  empty
                }
            }
            //===================== Email Validation ==============================
            if( empty( $email ) ){
                $email_error = "Email is required";
                $email_status = "";
            }else{
                if( !filter_var( $email , FILTER_VALIDATE_EMAIL ) ){
                    $email_error = "Invalide Email";
                    $email_status = ""; // make email_status  empty
                }else{
                    if( $obj->Normal_Query("SELECT Email FROM users WHERE Email = ?" , array($email)) ){
                        if( $obj->Count_Rows() != 0 ){
                            $email_error = "Sorry this email is exist";
                            $email_status = ""; // make email_status  empty
                        }
                    }
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
            //===================== Img Validation ==============================
            if( empty( $img_name ) ){
                $img_error = "Upload photo is required";
                $img_status = ""; // make img_status  empty
            }else{ 
                if( !in_array( $img_extention ,  $extentions ) ) { 
                    $img_error = "You must upload only photos";
                    $img_status = ""; // make img_status  empty
                }
            }
            //===================== Insert user into database ==============================
            if( !empty($username_status) && !empty($email_status) && !empty($password_status) && !empty($img_status) ){
    
                $hashPassword = md5($password);
                $date = date('Y/m/d H:i:s'); // because now() work in mysql only EX ==> excute( now() , .....); 
                $status = 0;
                $GroupID = 1 ; // for users
                $obj->fix_rotate_jpg_image($img_tmp);
                move_uploaded_file( $img_tmp , "$img_path/$img_name_rand");
    
                $stmt = $obj->con->prepare(" INSERT INTO 
                            users ( Username , Pass , Email , GroupID , Status , `Date` , Pic)
                            VALUES(:zusername, :zpass , :zemail ,  :zgroupid  , :zstatus , now() , :zpic ) ");
                $stmt->execute(array(
                    ":zusername"         => $username,
                    ":zpass"             => $hashPassword,
                    ":zemail"            => $email,
                    ":zgroupid"          => $GroupID,
                    ":zstatus"           => $status,
                    ":zpic"              => $img_name_rand
                ));
                if($stmt->rowCount() > 0){  // because rowCount() must be 1 at inserting database
                    $obj->create_session( "creating_account_success" , " <i class='fas fa-check'></i> &nbsp; Your account successfuly created" );
                    header("Location: logIn.php");
                }else{
                    $obj->create_session( "creating_account_failed" , " <i class='fas fa-times'></i>  &nbsp; Failed to create your account" );
                    header("Location: logIn.php");
                }
            }
    
    
        }
    
        ?>
        
            <div id="register-page">
        
                <div class="register-form">
        
                    <div class="signUp-form">
                        <div class="inner">
                            <form action="<?php echo  $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data"> <!-- enctype must to upload files -->
                                <p> <i class="fas fa-user-plus"></i> Create new account</p>
                                <hr>
                                <div class="input-content">
                                    <input class="form-control" name="username" type="text" placeholder="Enter Username..." value="<?php  echo getInputValue("username");  ?>" autocomplete="off"  required/>
                                    <?php
                                        if( isset( $username_error ) ){
                                            echo '<p class="error-messege">' . $username_error . '</p>'; 
                                        }
                                    ?>
                                </div>
                                <div class="input-content">
                                    <input class="form-control" name="email" type="email" placeholder="Enter Email..." value="<?php  echo getInputValue("email");  ?>" autocomplete="off" required />
                                    <?php
                                        if( isset( $email_error ) ){
                                            echo '<p class="error-messege">' . $email_error . '</p>'; 
                                        }
                                    ?>
                                </div>
                                <div class="input-content">
                                    <div class="password-content">
                                        <input class="form-control" name="password" type="password" placeholder="Enter Password..."  value="<?php  echo getInputValue("password");  ?>" autocomplete="new-password" required /> 
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
                                <div class="upload-input">
                                    <label for="file" id="file-label">  <i class="fas fa-cloud-upload-alt"></i> &nbsp; Choose image...  </label>
                                    <input type="file" class="file form-control" id="file" name="img"   /> 
                                    <?php
                                        if( isset( $img_error ) ){
                                            echo '<p class="error-messege">' . $img_error . '</p>'; 
                                        }
                                    ?>
                                </div>
                                <input type="submit" name="signUpBtn" value="SignUp">
                                <a href="logIn.php"> Aleardy have an account ?</a>
                            </form>
                        </div>
                    </div>
        
                </div>
                <?php
                include("componends/background-left.php");
                ?>
        
        
            </div>
        <?php include("includes/template/footer.php");
    }

