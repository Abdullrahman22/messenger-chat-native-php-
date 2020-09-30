<?php

    class base_class extends db{

        private $Query;

        public function Normal_Query( $query , $param = null ){
            
            if(is_null($param)){
                $this->Query = $this->con->prepare($query);
                return $this->Query->execute();
            }else{
                $this->Query = $this->con->prepare($query);
                return $this->Query->execute($param);
            }
        }


        public function Count_Rows(){
            return $this->Query->rowCount();
        }

        public function security( $data ){
            $data = strip_tags($data); // to remove tags from inputs
            return ltrim( $data, " " ); // to remove spaces after string
        }

        public function create_session( $session_name , $session_value ){
            $_SESSION["$session_name"] = "$session_value" ;
        }

        public function getUserinfo( $table , $session , $valueGet ){ // depende on UserID
            $stmt = $this->con->prepare("SELECT * FROM users WHERE $table = ? LIMIT 1");
            $stmt->execute( array( $session ) );
            $row = $stmt->fetch();
            return $row["$valueGet"];
        }

        public function updateUserInfo($sessionUserID , $table , $newValue){ // depende on UserID 
            $stmt = $this->con->prepare("UPDATE users SET $table = ? WHERE UserID = ? LIMIT 1");
            $stmt->execute(array( $newValue , $sessionUserID ));
            return $stmt;
        }

        

        public function updateOfflineDate( $sessionUserID ){ // depende on UserID 
            $stmt = $this->con->prepare(" UPDATE users SET offline_date = CURRENT_TIMESTAMP WHERE UserID = ?  LIMIT 1");
            $stmt->execute(array( $sessionUserID ));
            return $stmt;
        }




        public function messegeSeen($chat_Link , $fid ){
            $stmt = $this->con->prepare(" UPDATE messages SET seen = 1 WHERE chat_Link = ? AND Sender_ID = ? ");
            $stmt->execute(array( $chat_Link , $fid ));
            return $stmt;
        }

        public function getLastMsg ( $chat_Link ){ // depende on UserID
            $stmt = $this->con->prepare("SELECT message FROM messages WHERE chat_Link = ? ORDER BY `msg_id` DESC LIMIT 1 ");
            $stmt->execute( array( $chat_Link ) );
            $row = $stmt->fetch();
            return $row["message"];
        }

        public function getLastMsgSender ( $chat_Link ){ // depende on UserID
            $stmt = $this->con->prepare("SELECT Sender_ID FROM messages WHERE chat_Link = ? ORDER BY `msg_id` DESC LIMIT 1 ");
            $stmt->execute( array( $chat_Link ) );
            $row = $stmt->fetch();
            return $row["Sender_ID"];
        }

        public function getLastMsgType ( $chat_Link ){ // depende on UserID
            $stmt = $this->con->prepare("SELECT msg_type FROM messages WHERE chat_Link = ? ORDER BY `msg_id` DESC LIMIT 1 ");
            $stmt->execute( array( $chat_Link ) );
            $row = $stmt->fetch();
            return $row["msg_type"];
        }

        public function count_unseen_messege( $Sender_ID , $Receiver_ID  ){ // depende on UserID

            $stmt = $this->con->prepare("SELECT COUNT( message ) FROM messages WHERE `Sender_ID` = ? AND `Receiver_ID` = ? AND `seen` = 0  ");
            $stmt->execute( array( $Sender_ID , $Receiver_ID ) );   // do the statment
            return $stmt->fetchColumn(); 
    
        }

        public function count_online_users( $sessionID  ){ // depende on UserID

            $stmt = $this->con->prepare("SELECT COUNT( Username ) FROM users WHERE `UserID` = ?  ");
            $stmt->execute( array( $sessionID ) );   // do the statment
            return $stmt->fetchColumn(); 
    
        }



        public function fix_rotate_jpg_image( $tmp_name ){
        
            $exif = exif_read_data( $tmp_name );
            if (!empty($exif['Orientation'])) {
                $imageResource = imagecreatefromjpeg($tmp_name); // provided that the image is jpeg. Use relevant function otherwise
                switch ($exif['Orientation']) {
                    case 3:
                    $image = imagerotate($imageResource, 180, 0);
                    break;
                    case 6:
                    $image = imagerotate($imageResource, -90, 0);
                    break;
                    case 8:
                    $image = imagerotate($imageResource, 90, 0);
                    break;
                    default:
                    $image = $imageResource;
                } 
            }
            imagejpeg($image, $tmp_name, 90);
    
        }









        
        public function time_ago( $db_msg_time ){

            $db_time      = strtotime( $db_msg_time );

            date_default_timezone_set('Africa/Cairo');

            $current_time = time();
            $seconds = $current_time - $db_time ;

            $minutes = floor($seconds / 60); // 60
            $hours   = floor($seconds / 3600); // 60 *60
            $days    = floor($seconds / 86400); // 60 *60 * 24
            $weeks   = floor($seconds / 604800); // 60 *60 * 24 * 7
            $months  = floor($seconds / 2592000); // 60 *60 * 24 * 30
            $years   = floor($seconds / 31536000); // 60 *60 * 24 * 30 *12


            if( $seconds <= 60 ){
                return "Just Now";
            }
            elseif( $minutes <= 60 ){

                if( $minutes == 1 ){
                    return "1 minute ago";
                }else{
                    return $minutes . " minutes ago";
                }

            }
            elseif( $hours <= 24 ){

                if( $hours == 1 ){
                    return "1 hour ago";
                }else{
                    return $hours . " hours ago";
                }

            }
            elseif( $days <= 7 ){

                if( $days == 1 ){
                    return "1 day ago";
                }else{
                    return $days . " days ago";

                }

            }
            elseif( $weeks <= 4.3 ){

                if( $weeks == 1 ){
                    return "1 week ago";
                }else{
                    return $weeks . " weeks ago";

                }

            }
            elseif( $months <= 12 ){

                if( $months == 1 ){
                    return "1 month ago";
                }else{
                    return $months . " months ago";

                }

            }
            else{
                if( $years == 1 ){
                    return "1 year ago";
                }else{
                    return $years . " years ago";

                }
            }


        }
        
 

        public function time_ago_offline( $db_msg_time ){

            date_default_timezone_set('Africa/Cairo');

            $db_time      = strtotime( $db_msg_time );
            $current_time = time();

            $seconds = $current_time - $db_time ;
            

            $minutes = floor($seconds / 60); // 60
            $hours   = floor($seconds / 3600); // 60 *60
            $days    = floor($seconds / 86400); // 60 *60 * 24
            $weeks   = floor($seconds / 604800); // 60 *60 * 24 * 7
            $months  = floor($seconds / 2592000); // 60 *60 * 24 * 30
            $years   = floor($seconds / 31536000); // 60 *60 * 24 * 30 *12


            if( $seconds <= 60 ){
                return "active 1 minute ago";
            }
            elseif( $minutes <= 60 ){

                if( $minutes == 1 ){
                    return "active 1 minute ago";
                }else{
                    return "active " . $minutes . " minutes ago";
                }

            }
            elseif( $hours <= 24 ){

                if( $hours == 1 ){
                    return "active " . "1 hour ago";
                }else{
                    return "active " . $hours . " hours ago";
                }

            }
            elseif( $days <= 7 ){

                if( $days == 1 ){
                    return "active " .  "1 day ago";
                }else{
                    return "active " .  $days . " days ago";

                }

            }
            elseif( $weeks <= 4.3 ){

                if( $weeks == 1 ){
                    return "active " . "1 week ago";
                }else{
                    return "active " . $weeks . " weeks ago";

                }

            }
            elseif( $months <= 12 ){

                if( $months == 1 ){
                    return "active " . "1 month ago";
                }else{
                    return "active " . $months . " months ago";

                }

            }
            else{
                if( $years == 1 ){
                    return "active " . "1 year ago";
                }else{
                    return "active " . $years . " years ago";

                }
            }


        }
        
 


    }








?>