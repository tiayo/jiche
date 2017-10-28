$(document).ready(function(){
    $(".nav-top li").hover(function() {
        $(".nav-menu").show(function() {
            $(".nav-menu").hover(function() {
                $(".nav-menu").show();
            }, function() {
                $(".nav-menu").hide();
            });
        });
    }, function() {
        $(".nav-menu").hide();
    });

    $(".index .new .new-con li").hover(function() {
        $(this).children('strong').children('b').show();
    }, function() {
        $(this).children('strong').children('b').hide();
    });
});