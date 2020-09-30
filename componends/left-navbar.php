<?php
    $Username = $obj->getUserinfo( "UserID" , $sessionUserID , "Username");
    $UserPhoto = $obj->getUserinfo( "UserID" , $sessionUserID , "Pic");



?>
<div class="top-bar">
    <p> <?php  echo ucfirst($Username); ?> </p>
</div>
<div class="slider-container">
    <div class="profile-info">
        <div class="profile-info-inner">
            <span> <img src="assets/images/users-img/<?php  echo $UserPhoto; ?>" alt=""> </span>
            <span class="username"> <a href="index.php">Chats</a> </span>
            <span class="user-setting"> <i class="fas fa-cog"></i> </span>
        </div>
    </div>
    <div class="search-input">
        <i class='fas fa-search'></i>
        <input type="text" class="form-control" placeholder="Search for friends...">
        <img src="assets/images/icon/loading.gif" alt="">
    </div>
</div>
<div class="freinds-messages">
    <div class="slider-container">


    </div>
</div>
<div class="search-box">
    <div class="slider-container">

    </div>
</div>