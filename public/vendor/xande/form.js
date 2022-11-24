/*
*  
*  Custom form control using Jquery
*
*  @Author: Xande Yong
*  All right Reserved to @Xande_Yong
*  Credit to @Xande_Yong when using this js
*
*/

$(document).ready(function () {
    
    $(".x-form").submit(function (e) { 
        var validation = true;

        if ($(this).hasClass('x-form-validation')) {
            validation = formValidation(e);
        }
        
        if (validation === true) {
            if ($(this).attr("x-confirm") !== "" && $(this).attr("x-confirm") !== null && $(this).attr("x-confirm") !== undefined) {
                var message = $(this).attr("x-confirm")
                if (confirm(message) !== true) {
                    e.preventDefault()
                }
            }

            if ($(this).attr("x-alert") !== "" && $(this).attr("x-alert") !== null && $(this).attr("x-alert") !== undefined) {
                var message = $(this).attr("x-alert")
                alert(message);
            }
        }
    });

    $("button[x-confirm], a[x-confirm]").click(function (e) {
        var message = $(this).attr("x-confirm")

        if ($(this).attr('href') != undefined && $(this).attr('disabled') == undefined) {

            if (confirm(message) !== true) {
                e.preventDefault()
            }
        }
    })

    $("button[x-alert], a[x-alert]").click(function (e) {
        var message = $(this).attr("x-alert")

        if ($(this).attr('href') != undefined && $(this).attr('disabled') == undefined) {
            alert(message);
        }
    })

});

function formValidation(e) {

    var validation = true;
    var required = $(".x-form-required");
    
    $.each(required, function (key, input) { 
        $input = $(input);

        if ($input.val() === "" || $input.val() === null) {
            if ($input.siblings(".x-form-error").length !== 0) {
                $error = $input.siblings(".x-form-error");
                $error.css("display", "block");
                $error.addClass(".c-red-error");

            } else {
                var errorElem = '<span class="x-form-error c-red-error"></span>';
                $input.parent().append(errorElem);

            }
            $error = $input.siblings(".x-form-error");

            if ($input.is("input")) {
                $error.html("*This field cannot be leave empty.");
            } else if ($input.is("select")) {
                $error.html("*Please select an option.");
            } else {
                $error.html("*This input box is not allow to be leave empty.");
            }

            validation = false;
            alert("Some input field cannot be leave empty.");
            e.preventDefault();
        }
    });

    return validation;
}
