<?


    $sessionUserID   = $_SESSION["loginUserID"] ;
    $fid             = $_SESSION["fid"] ;
    $chat_Link       = $_SESSION["chat_Link"] ;


    $stmt = $obj->con->prepare("SELECT * FROM `users` WHERE UserID = ? LIMIT 1");
    $stmt->execute( array( $fid ) );
    $row = $stmt->fetch();
                                
    echo $row["Username"];


?>

<div class="friend-messege">

    <div class="friend-img">
        <img src="assets/images/users-img/user1.JPG" alt="">
    </div>
    <div class="friend-messege-content">
        <div class="friend-info">
            <span class="friend-name">
                AbdullRahman
            </span>
            <span class="date ">
                1 day ago
            </span>
        </div>
        <div class="message">
            <span class="triangle"></span>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo fuga, iste corrupti doloribus quibusdam 
        </div>
    </div>

</div>