/* ====================================================================
|   |   |   |   |   |   |   OWL CAROUSEL ==>   TEAM
=====================================================================*/
$(document).ready(function (){
    "use strict";
    $("#Backgrounds").owlCarousel({
        responsive:{
            200:{
                items: 1
            }
        },
        animateOut: 'fadeOut',
        loop: true,
        margin: 10,
        mouseDrag: false,
        pullDrag: false,
        touchDrag: false,
        autoplay: true,
        smartSpeed: 900,
        autoplayTimeout: 3500,

    });   
});
/* ====================================================================================
|   |   |   |   |   |   |   file lable 
=====================================================================================*/
$(document).ready(function (){
    "use strict";
    $(document).on("change" , ".upload-input #file" , function (){
        var image_name = $(".upload-input #file").val();
        $(".upload-input #file-label").text(image_name);
    });
});
/* ====================================================================================
|   |   |   |   |   |   |   drop-down-menu 
=====================================================================================*/
$(document).ready(function (){
    "use strict";
    $(".profile-info .user-setting i").click(function (){
        $(".drop-down-menu").fadeIn();
    });
    $(".drop-down-menu").click( function (){
        $(this).fadeOut();
    });
    $(".drop-down-menu-inner").click( function (e){
        e.stopPropagation();
    });
});
/* ====================================================================================
|   |   |   |   |   |   |   hide placeholder at focus 
=====================================================================================*/
$(document).ready(function (){
    "use strict";
    //  Hide placeholder
    $("[placeholder]").focus(function(){
        $(this).attr("data-type", $(this).attr('placeholder'));
        $(this).attr("placeholder","");
    });
    //  show placeholder
    $("[placeholder]").blur(function(){
        $(this).attr("placeholder", $(this).attr('data-type'));
    });
});


/* ====================================================================================
|   |   |   |   |   |   |   show fixed-menu in small devices
=====================================================================================*/
$(document).ready(function (){
    
    "use strict";
    $(".right-section .top-bar i").click(function (){
        $("#chat-page .fixed-menu").animate({ left : "0px"} , 200);
        $(".right-section > .overlay").fadeIn();
    });
    $(".right-section > .overlay").click(function (){
        $("#chat-page .fixed-menu").animate({ left : "-270px"}  , 300 );
        $(".right-section > .overlay").fadeOut();
    });

});
/* ====================================================================================
|   |   |   |   |   |   |   show / hidden password
=====================================================================================*/
$(document).ready( function (){
    "use strict";
    $(".password-content i.fa-eye").click( function (){
        $(this).hide();
        $(this).siblings("i.fa-eye-slash").show();
        $(this).parent(".eye-icons").siblings("input").attr("type" , "password");
    });

    $(".password-content i.fa-eye-slash").click( function (){
        $(this).hide();
        $(this).siblings("i.fa-eye").show();
        $(this).parent(".eye-icons").siblings("input").attr("type" , "text");
    });
});
/* ====================================================================================
|   |   |   |   |   |   |   show / hidden session change name-pass
=====================================================================================*/
$(document).ready(function(){
    "use strict";
    $(".right-section .session-messege").delay( 800 ).animate({ opacity: "0"} ,  700, function(){
        $(".right-section .session-messege").css( "display" , "none" );
    });
});
/* ====================================================================================
|   |   |   |   |   |   |   show emojis-box
=====================================================================================*/
$(document).ready( function () {
    "use strict";
    $(".keyboard-section i.fa-smile").click(function(){
        $(".emojis-box").css("display" , "block");
    });
    $(".emojis-box img , .chat-area , .fixed-menu , .left-navbar").click(function(){
        $(".emojis-box").css("display" , "none");
    });
});
/* ====================================================================================
|   |   |   |   |   |   |   Change Like Button at writing
=====================================================================================*/
$(document).ready( function () {
    "use strict";
    $('.keyboard-section input').on("focus keyup",function() {
        if ($(this).val() == '') { // check if value changed
            $(".keyboard-section .fa-paper-plane").css("display", "none");
            $(".keyboard-section .fa-thumbs-up").css("display", "inline");
        }
    });
    $('.keyboard-section input').on("keyup",function() {
        if ($(this).val() !== '') { // check if value changed
            $(".keyboard-section .fa-paper-plane").css("display", "inline");
            $(".keyboard-section .fa-thumbs-up").css("display", "none");
        }
    });

});


/* ====================================================================================
|   |   |   |   |   |   |   focus in search input
=====================================================================================*/
$(document).ready( function () {
    "use strict";

    
    $(".slider-container .search-input input").focus(function(){
        $(".freinds-messages .slider-container ").fadeOut();
        $(".search-box").fadeIn();

    });
    $("#chat-page .right-section").click(function(){
        $(".freinds-messages .slider-container ").fadeIn();
        $(".search-box").fadeOut();

    });



    $(".slider-container .search-input input").keypress(function (e) { 
        if(e.keyCode == 13){

            var search_content = $(".slider-container .search-input input").val();
            if( search_content != ""){
                
                $.ajax({

                    type: "GET",
                    url: "includes/ajax/search_friend.php",
                    data: { "search_content" : search_content},
                    success: function (feedback) {
                        $(".slider-container .search-input img").css("display", "block");
                        setTimeout(function(){
                            $(".slider-container .search-input img").css("display", "none");
                        }, 1000);
                        $(".search-box .slider-container").html(feedback);
                    }

                });


            }

        }
    });

   
});


/* ====================================================================================
|   |   |   |   |   |   |   destory_session
=====================================================================================*/
$(document).ready( function () {
    "use strict";

    window.addEventListener("beforeunload", function (e) { 
        
        var destory_session = true;
        
        $.ajax({
            type: "POST",
            url: "includes/ajax/destory_session.php",
            data: { "destory_session": destory_session},
            dataType: "JSON",

        });
        
    });

});

/* ====================================================================================
|   |   |   |   |   |   |   show_friends_box 
=====================================================================================*/
$(document).ready( function () {
    "use strict";


    function show_friends_box(){
        var friends_box = "true"; 
        $.ajax({
            type: "GET",
            url: "includes/ajax/show_friends_box.php",
            data: { "friends_box" : friends_box},
            success: function (feedback) {
                $(".freinds-messages .slider-container").html(feedback);
            }
        });
    }

    show_friends_box();

    setInterval(function (){
        show_friends_box();
    }, 3000);

});
