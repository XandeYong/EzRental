$(document).ready(function () {
    $starClicked = false;

    $("#visit_appointment_button").click(function (e) { 
        var now = currentTime(0, 1, 0);

        now = now.toISOString().slice(0,16);
        $("#visit_appointment_datetime").attr("min", now);
    });

});


function currentTime(addDay = 0, addHour = 0, addMin = 0) {
    addDay = addDay * 1440;
    addHour = addHour * 60;

    var now = new Date();
    now.setMinutes((now.getMinutes() - now.getTimezoneOffset()) + addDay + addHour + addMin);

    return now;
}