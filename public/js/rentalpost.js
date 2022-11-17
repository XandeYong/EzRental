$(document).ready(function () {
    $starClicked = false;

    $("#visit_appointment_button").click(function (e) { 
        var now = currentTime();

        now = now.toISOString().slice(0,16);
        $("#visit_appointment_datetime").attr("min", now);
    });

    $("#rent_button").click(function (e) { 
        var now = currentTime(1);
        var later = currentTime(30);

        now = now.toJSON().slice(0,10);
        later = later.toJSON().slice(0,10);

        $("#rent_start_date").attr("min", now);
        $("#rent_end_date").attr("min", later);
    });

    if ($("input[name=rating]").attr('checked') !== 'undefined' && $("[name=rating]").attr('checked') !== false && $("#comment_submit_input").val() === "Update") {
        $(".rating__icon--star").removeClass('rating__icon--star-initial');
        $starClicked = true;
    }


    $(".rating-group").one('click', function (e) { 
        $(".rating__icon--star").removeClass('rating__icon--star-initial');
        $(".rating-error").fadeOut();
        $starClicked = true;
    });

    $(".rating-group").hover(function () {
        if ($starClicked == false) {
            $(".rating__icon--star").removeClass('rating__icon--star-initial');
        }

        }, function () {
            if ($starClicked == false) {
                $(".rating__icon--star").addClass('rating__icon--star-initial');
            }
        }
    );

    $("#comment_submit_input").click(function (e) { 
        if (!$("[name=rating]").is(':checked')) {
            $(".rating-error").removeClass('d-none');
        }
    });

    
    //validation
    $("#visit_appointment_button").click(function(e) {
        if (access['appointment'] === "forbidden") {
            $message = "You already have an on-going Appointment. \n"
                     +"You can only have one on-going Appointment at a time."
            window.alert($message);
            e.preventDefault();
        }
    });

    $("#negotiate_button").click(function(e) {
        if (access['negotiate'] === "forbidden") {
            $message = "You already have an on-going Negotiattion session. \n"
                     +"You can only have one on-going Negotiattion session at a time."
            window.alert($message);
            e.preventDefault();
        }
    });

    $("#rent_button").click(function(e) {
        if (access['rent'] === "forbidden") {
            $message = "You already have an on-going Rent request. \n"
                     +"You can only have one on-going Rent request at a time."
            window.alert($message);
            e.preventDefault();
        }
    });

});


function currentTime(addDay = 0) {
    addDay = addDay * 1440;

    var now = new Date();
    now.setMinutes((now.getMinutes() - now.getTimezoneOffset()) + addDay);

    return now;
}