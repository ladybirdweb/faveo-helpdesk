
$(function () {

    $('.tabs a, .tabs button').click(function(e) {
        e.preventDefault(); // Prevent default link behavior.
        var tabID = $(this).attr('data-target'); // Pull the data-target value as the tabID.

        $(this).addClass('active').parent().addClass('active'); // Add the .active class to the link and it's parent li (if one exists).
        $(this).siblings().removeClass('active'); // Remove the .active class from sibling tab navigation elements.
        $(this).parent('li').siblings().removeClass('active').children().removeClass('active'); // Remove the .active class from sibling li elements and their links.
        $(tabID).addClass('active'); // Add the .active class to the div with the tab content.
        $(tabID).siblings().removeClass('active'); // Remove the .active class from other tab content divs.
    });

});






(function($) {
    $(function () {
        $('body').addClass('js'); // On page load, add the .js class to the <body> element.
    });
})(jQuery);
