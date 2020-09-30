

<?php

    if( isset($_SESSION["change_name_success"]) ){
        echo '<div class="session-messege">';
            echo '<div class="messege success"> <p> ' . $_SESSION["change_name_success"] . '  </p>  </div>';
        echo '</div>';
    }
    unset( $_SESSION["change_name_success"] );
?>


