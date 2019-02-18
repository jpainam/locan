$(document).ready(function () {
    $("#container").css({width: "auto"});
    var h = $(window).height();
    var top = h / 2 - $("#content").height() + "px";
    //alert(top);
    $("#page-connect").css({marginTop: top});

});
