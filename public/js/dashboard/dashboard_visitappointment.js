$(document).ready(function () {
    $starClicked = false;

    $("#visit_appointment_button").click(function (e) { 
        var now = currentTime();

        now = now.toISOString().slice(0,16);
        $("#visit_appointment_datetime").attr("min", now);
    });

});


function currentTime(addDay = 0) {
    addDay = addDay * 1440;

    var now = new Date();
    now.setMinutes((now.getMinutes() - now.getTimezoneOffset()) + addDay);

    return now;
}