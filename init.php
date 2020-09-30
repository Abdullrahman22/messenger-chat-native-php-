<?php

    ob_start();
    session_start();

    spl_autoload_register(function($class_name){
        include "includes/classes/$class_name.php";      //this mean that use All class name in file name
    });

    include "includes/functions/functions.php";


?>