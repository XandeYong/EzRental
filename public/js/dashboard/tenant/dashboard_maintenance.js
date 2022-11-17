$(document).ready(function () {
    
    $itemTemplate = $(".upload-image-item").clone();

    $(".upload-image-container").delegate(".upload-input", "change", function (e) { 
        
        var generate = true;
        $item = $itemTemplate.clone();

        $.each($(".upload-image-item"), function (i, v) { 
            $_this = $(v).children().children(".upload-input");
            $delete = $(v).find(".image-delete .btn-close");
            
            if ($_this[0].files.length < 1) {
                generate = false;
            } else {
                $delete.removeClass("opacity-0");
                $delete.removeAttr("disabled");
            }
        });

        if (generate == true) {
            $item = $itemTemplate.clone();
            $item.find(".upload-input").removeAttr("required");
            $(".upload-image-container").append($item);
        }
        
        $imageFile = this.files[0];
        $url = window.URL.createObjectURL($imageFile);
        $(this).siblings().children("img").attr("src", $url);
    });

    $(".upload-image-container").delegate(".btn-close", "click", function(e) {
        $(this).parent().parent().parent().remove();

        if ($(".upload-image-item").length == 1) {
            $(".upload-image-item input").attr("required", "required");
        }
    });

});