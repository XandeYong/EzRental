/*
*  
*  Custom animation javascript using Jquery
*
*  @Author: Xande Yong
*  All right Reserved to @Xande_Yong
*  Credit to @Xande_Yong when using this js
*
*/


$(document).ready(function () {
    $( ".message-popup" ).fadeIn(400).delay(2000).fadeOut( 1600 );  
    
    $(".x-image-modal").click(function (e) { 
        $imageModal = $("#x-image-modal");
        $image = $("#x-image-modal #x-image")
    
        $imageModal.css("display", "block");
        $image.attr("src", $(this).attr("src"));
        
    });
    
    $("#x-image").click(function(e) {
        e.stopPropagation();
    });
    
    
    $("#x-image-modal, #x-image-modal .close").click(function(e) {
        $("#x-image-modal").css("display", "none");
    });


    $(".x-input-image").change(function (e) {
        $imageFile = this.files[0];
        $url = window.URL.createObjectURL($imageFile);
        $(".x-upload-image").attr("src", $url);
    })

});