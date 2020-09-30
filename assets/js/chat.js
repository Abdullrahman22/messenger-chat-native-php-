


$(document).ready( function () {
    "use strict";
/* ====================================================================================
|   |   |   |   |   |   |   Auto scroll down 
=====================================================================================*/

    $(".chat-area").animate({scrollTop :  $(".chat-area")[0].scrollHeight } , 1000);






/* ====================================================================================
|   |   |   |   |   |   |   Send Message 
=====================================================================================*/


    $("#send-messege").keypress(function (e) { 
        if(e.keyCode == 13){
            var send_message = $("#send-messege").val();
            if( send_message != ""){
                
                $.ajax({
                    type: "POST",
                    url: "includes/ajax/send_messege.php",
                    data: { send_message: send_message},
                    dataType: "JSON",
                    success: function (feedback) {
                        if(feedback.status == "success"){
                            $("#send-messege").val('');
                            show_messeges();
                            $(".chat-area").animate({scrollTop :  $(".chat-area")[0].scrollHeight } , 1000);
                        }
                        if( feedback.status == "error" ){
                            alert("error connection");
                            $("#send-messege").val('');
                        }
                    }
                });
            }
        }
    });
    $(".fa-paper-plane").click(function () { 
        var send_message = $("#send-messege").val();
        if( send_message != ""){
            
            $.ajax({
                type: "POST",
                url: "includes/ajax/send_messege.php",
                data: { send_message: send_message},
                dataType: "JSON",
                success: function (feedback) {
                    if(feedback.status == "success"){
                        $("#send-messege").val('');
                        show_messeges();
                        $(".chat-area").animate({scrollTop :  $(".chat-area")[0].scrollHeight } , 1000);
                    }
                    if( feedback.status == "error" ){
                        $(".problem-box").fadeIn( 1000 , function (){
                            $(".problem-box").fadeOut( 1000 );
                        });
                        $(".problem-box span").text(" Error connection ");
                        $("#send-messege").val('');
                    }
                }
            });

        }
    });

/* ====================================================================================
|   |   |   |   |   |   |   Send Files 
=====================================================================================*/

    $(".content-icon #file ").change( function (){
        var file_name = $(".content-icon #file").val();
        if( file_name.length != "" ){

            $.ajax({
                type: "POST",
                url: "includes/ajax/send_files.php",
                data: new FormData( $(" .content-icon ")[0] ),
                contentType: false,
                processData: false,
                success: function (feedback) {
                    if( feedback == "Unvalidate file"){
                        $(".problem-box").fadeIn( 1000 , function (){
                            $(".problem-box").fadeOut( 1000 );
                        });
                        $(".problem-box span").text(" Unvalidate file ");
                    }
                    if( feedback == "error connection"){
                        $(".problem-box").fadeIn( 1000 , function (){
                            $(".problem-box").fadeOut( 1000 );
                        });
                        $(".problem-box span").text(" Error connection ");
                    }
                    if( feedback == "file sent"){
                        show_messeges();
                        $(".chat-area").animate({scrollTop :  $(".chat-area")[0].scrollHeight } , 1000);
                    }
                }
            });

        }
    });
/* ====================================================================================
|   |   |   |   |   |   |   Send Emojis 
=====================================================================================*/

    $(".emojis-box .emojis").click(function () {
        var emojis = $(this).attr("src");
        if( emojis.length != "" ){

            $.ajax({
                type: "POST",
                url: "includes/ajax/send_emojis.php",
                data: { "send_emoji": emojis},
                dataType: "JSON",
                success: function (feedback) {

                    if( feedback.status == "error" ){
                        $(".problem-box").fadeIn( 1000 , function (){
                            $(".problem-box").fadeOut( 1000 );
                        });
                        $(".problem-box span").text(" Error connection ");
                    }if( feedback.status == "success" ){
                        show_messeges();
                        $(".chat-area").animate({scrollTop :  $(".chat-area")[0].scrollHeight } , 1000);
                    }

                }
            });

        }
    });
/* ====================================================================================
|   |   |   |   |   |   |   Send Like 
=====================================================================================*/
    $(".keyboard-section .fa-thumbs-up").click(function () {
        var like = $(this).attr("class");

            $.ajax({
                type: "POST",
                url: "includes/ajax/send_like.php",
                data: { "send_like": like},
                dataType: "JSON",
                success: function (feedback) {

                    if( feedback.status == "error" ){
                        $(".problem-box").fadeIn( 1000 , function (){
                            $(".problem-box").fadeOut( 1000 );
                        });
                        $(".problem-box span").text(" Error connection ");
                    }if( feedback.status == "success" ){
                        show_messeges();
                        $(".chat-area").animate({scrollTop :  $(".chat-area")[0].scrollHeight } , 1000);
                    }

                }
            });

    });
/* ====================================================================================
|   |   |   |   |   |   |   Show Messeges 
=====================================================================================*/

    function show_messeges(){
        var msg = "true"; 
        $.ajax({
            type: "GET",
            url: "includes/ajax/show_messeges.php",
            data: { "messege" : msg},
            success: function (feedback) {
                $(".chat-area .custom-container").html(feedback);
            }
        });
    }

    show_messeges();

    setInterval(function (){
        show_messeges();
    }, 3000);



/* ====================================================================================
|   |   |   |   |   |   |   seen massege 
=====================================================================================*/


    $(".friend-messge-box").click(function () {  

        var fid = $(this).attr("uid");

        $.ajax({
            type: "POST",
            url: "includes/ajax/seen_messege.php",
            data: { "fid": fid},
            dataType: "JSON",
            success: function (feedback) {

            }
        });
    });




    $(".keyboard-section .keyboard-input").focus(function () {  

        var fid = $(this).attr("fid");
        setInterval(function (){

            $.ajax({
                type: "POST",
                url: "includes/ajax/seen_messege.php",
                data: { "fid": fid},
                dataType: "JSON",
                success: function ( feedback) {

                }
            });
            
        }, 3000);


    });

    $(".chat-area").on( "click mouseover hover mouseleave mouseenter scroll" , function () {

        var fid = $(".keyboard-section .keyboard-input").attr("fid");
        setInterval(function (){

            $.ajax({
                type: "POST",
                url: "includes/ajax/seen_messege.php",
                data: { "fid": fid},
                dataType: "JSON",
                success: function (feedback) {

                }
            });
            
        }, 3000);

    });




/* ====================================================================================
|   |   |   |   |   |   |   show_alert_messeges in mob 
=====================================================================================*/

    function show_alert_messeges(){
        var msg = "true"; 
        $.ajax({
            type: "GET",
            url: "includes/ajax/show_alert_messeges.php",
            data: { "messege" : msg},
            success: function (feedback) {
                if( feedback == "alert" ){
                    $(".top-bar .alert-messege").css("opacity" , "1");
                }else{
                    $(".top-bar .alert-messege").css("opacity" , "0");
                }
            }
        });
    }

    show_alert_messeges();

    setInterval(function (){
        show_alert_messeges();
    }, 3000);





/* ====================================================================================
|   |   |   |   |   |   |   show_activity_friend in mob 
=====================================================================================*/

function show_activity_friend(){
    var msg = "true"; 
    $.ajax({
        type: "GET",
        url: "includes/ajax/show_activity_friend.php",
        data: { "messege" : msg},
        success: function (feedback) {
            $(".top-bar .friend-info-box").html(feedback);

        }
    });
}

show_activity_friend();

setInterval(function (){
    show_activity_friend();
}, 3000);

















});