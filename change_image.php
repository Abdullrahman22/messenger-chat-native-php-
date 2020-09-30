<?php
    $pagetitle = "Change Account Image"; 
    include("includes/template/header.php");

    if( isset($_SESSION["loginUserID"]) ){

        $obj = new base_class; // this contain {db , bas_class}
        $sessionUserID   = $_SESSION["loginUserID"] ;
        $obj->updateUserInfo($sessionUserID , "Status" , 1);


        if(isset($_POST["submitBtn"])){

            
            $img_name      = $_FILES["img"]["name"];
            $img_name_rand      = rand(0 , 1000) . "_" . $img_name;
            $img_tmp       = $_FILES["img"]["tmp_name"]; 
            $img_path      = "assets/images/users-img/";
            $extentions    = array("jpg" , "jpeg" , "png" , "JPG" , "JPEG" , "PNG");
            $img_ext       = explode("." , $img_name_rand); // explode mean that put every word in string at elements in array
            $img_extention = end($img_ext);  // last word in array "extention"
            $img_status = 1 ;  // make status not empty;


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
            //===================== Update Image in DB ==============================
            if( !empty($img_status)  ){


                $obj->fix_rotate_jpg_image($img_tmp);

                move_uploaded_file( $img_tmp , "$img_path/$img_name_rand");
                $changeImage = $obj->updateUserInfo($sessionUserID , "Pic" , $img_name_rand );
                if( $changeImage->rowCount() > 0 ){
                    $obj->create_session( "change_Image_success" , "<i class='fas fa-check'></i> &nbsp; Your Image has been changed" );
                    header("Location: index.php");
                }else {
                    $img_error = "Sorry error at changing Image";
                    $img_status = ""; // make email_status empty
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
    
                <div class="change-image">
                    <h2>Change Image</h2>
                    <hr>
                    <form action="<?php echo  $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                        <div class="upload-input">
                            <label for="file" id="file-label">   <i class="fas fa-cloud-upload-alt"></i> &nbsp; Choose image...  </label>
                            <input type="file" class="file form-control" id="file" name="img"   /> 
                            <?php
                                if( isset( $img_error ) ){
                                    echo '<p class="error-messege">' . $img_error . '</p>'; 
                                }
                            ?>
                        </div>
                        <input type="submit" name="submitBtn" value="Save Changes">
                    </form>
                </div>
    
            </div>
            
        </div>
    
        
        <?php include("includes/template/footer.php");


    }else {
        header("Location: logIn.php");
    }


