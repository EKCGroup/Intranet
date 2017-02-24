// NAVIGATION
$(function () {
    $('#side-menu').metisMenu();
});

$(function() {
    // Pace page load progress - on complete
    Pace.on("done", function(){
        //un-blur #wrapper
        $({blurRadius: 5}).animate({blurRadius: 0}, {
            duration: 220,
            easing: 'swing',
            step: function() {
                $('#wrapper, #ccm-toolbar').css({
                    "-webkit-filter": "blur("+this.blurRadius+"px)",
                    "filter": "blur("+this.blurRadius+"px)"
                });
            }
        });
    });

    // loads the correct sidebar on window load,
    // collapses the sidebar on window resize.
    // sets the min-height of #page-wrapper to window size
    $(window).bind("load resize", function () {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1)
            height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent().parent().addClass('in').parent();
    
    var element = $('ul.nav a').filter(function () {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});

//Responsive turn to mobile
$(window).resize(function() {
    var width = $(document).width();
    //If Desktop
    if (width > 765) {
        //If edit bar showing
        if ($('#ccm-toolbar').length > 0) {
            $("#wrapper").css("margin-top", "7.7em");
        }
    //If Mobile
    } else {
        //If edit bar showing
        if ($('#ccm-toolbar').length > 0) {
            $("#wrapper").css("margin-top", "3.5em");
        }
    }
}).trigger('resize');

$(document).ready(function () {
    //Enable Tooltips
    $('[data-toggle="tooltip"]').tooltip();
});

//Toolbar goback
function goBack() {
    window.history.back();
}

//Cant Remember
$("input").keyup(function () {
    if (this.value.length == this.maxLength) {
        $(this).next('input').focus();
    }
});