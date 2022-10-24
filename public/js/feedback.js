$(document).ready(function () {
    $wrapperHeight = $("#wrapper").height();
    $navbarHeight = $("#navbar").height();
    $height = $wrapperHeight - $navbarHeight;
    $("iframe").attr("height", $height); 
});