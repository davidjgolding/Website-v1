/* Animation to move about front and shadow together */

function aboutAnimation() {
    $("#aboutFront").animate({ right: "80px" });
    $("#aboutBack").css({
        animation: "shadowAnimation 0.5s",
        transform: "translate(-30px, 10px)"
    });
}

/* Check if element is visable */
function isScrolledIntoView(elem) {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return elemBottom <= docViewBottom * 1.03 && elemTop * 1.2 >= docViewTop;
}

/* Check if experience is visable */
function isScrolledIntoViewExperience() {
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    var elemBottom = $("#about").offset().top + $("#about").height();
    var elemTop = $("#contact").offset().top;
    return elemBottom <= docViewBottom * 1.03 && elemTop * 1.2 >= docViewTop;
}

/* Find the current slide */
function findView() {
    if (isScrolledIntoView($("#about")) == true) {
        return "#navAbout";
    } else if (isScrolledIntoView($("#contact")) == true) {
        return "#navContact";
    } else if (isScrolledIntoViewExperience() == true) {
        return "#navExperience";
    } else if (isScrolledIntoView($("#landing")) == true) {
        return "#landing";
    } else {
        return "none";
    }
}

/* Apply appropriate properties depending on current slide */
function selection() {
    let tags = ["#navAbout", "#navExperience", "#navContact"];
    let current = findView();
    // If about back is visable, play animation
    if (current == "#navAbout") {
        aboutAnimation();
    }
    // Disable snap scroll for experience
    if (current == "#navExperience") {
        $("body").css("scroll-snap-type", "y proximity");
        $("html").css("scroll-snap-type", "y proximity");
    } else if (current != "none") {
        $("body").css("scroll-snap-type", "both mandatory");
        $("html").css("scroll-snap-type", "both mandatory");
    }
    // Change the nav bar for current slide
    if (current != "none") {
        for (i in tags) {
            if (tags[i] != current) {
                $(tags[i])
                    .removeClass("selected")
                    .addClass("unselected");
            } else {
                $(tags[i])
                    .removeClass("unselected")
                    .addClass("selected");
            }
        }
    }
}

/* Center experience grid based on screen size */
function centerGrid() {
    if ($("#grid").height() > $(window).height()) {
        $("#experience").css("padding", "60px 0px 0px 5px");
    } else {
        $("#experience").css("padding", "0px");
    }
}

$(document).ready(function() {
    $(window).resize(function() {
        centerGrid();
    });
    centerGrid();
    $("#mobileMenu").bind("click", function() {
        $("#navLinks").animate({ width: "toggle" });
    });
});

window.addEventListener("scroll", function(event) {
    selection();
});
