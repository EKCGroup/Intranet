$(function(){
    $(".simple-accordion-title-shell").click(function(){
        if($(this).parent().hasClass("open")){
            $(this).parent().removeClass("open").addClass("closed");
        }
        else if($(this).parent().hasClass("closed")){
            $(this).parent().removeClass("closed").addClass("open");
        }
    });
});
