/*global $*/

$(function ($) {
    "use strict";

    /*-----------------------------------------------------------------------------------*/
    /*	Site Navigation */
    /* ----------------------------------------------------------------------------------- */
//    $('#navbar .navbar-menu').mobileMenu({className: 'form-control'})
    $('#navbar .navbar-menu li').each(function () {
        $(this).filter('.active').parents('li').addClass('active');
        if ($('ul', this).length > 0) {
            $(this).children('a').append('<i class="sub-indicator fa fa-angle-down fa-fw text-muted"></i>');
        }
    });
    $('#navbar .navbar-menu, #navbar .navbar-user').superfish({
        animation: {opacity: 'show', height: 'show'},
        delay: 100,
        speed: "slow"
    });
    $('#navbar .navbar-user > li > a').on('click', function () {
        $(this).parent().toggleClass('opened');
    });

    /*-----------------------------------------------------------------------------------*/
    /*	Main Search */
    /*-----------------------------------------------------------------------------------*/
    $.ajax({
        url: 'search-terms.php',
        dataType: 'json'
    }).done(function (data) {
        $('#header-search .search-field').autocomplete({
            lookup: data,
            appendTo: '#header-search .form-inline .form-group',
            onSearchStart: function () {
                $(this).addClass('loading');
            },
            onSearchComplete: function () {
                $(this).removeClass('loading');
            }
        });
    });
    $('#header-search .search-field').on('focus', function () {
        $('#header-search .search-advance-button').fadeIn();
        $('#header-search .search-advance').slideDown();
    });
    $('#header-search .search-advance-button').on('click', function (e) {
        e.preventDefault();
        $(this).fadeOut(100);
        $('#header-search .search-advance').slideUp(100);
    });

    /*-----------------------------------------------------------------------------------*/
    /*	Tooltip */
    /*-----------------------------------------------------------------------------------*/
    $('[data-toggle="tooltip"]').tooltip();

    /*-----------------------------------------------------------------------------------*/
    /*	Accordion */
    /*-----------------------------------------------------------------------------------*/
    $('.accordion .accordion-toggle').prepend('<i class="fa fa-caret-down fa-fw pull-left text-danger"></i>');

    /*-----------------------------------------------------------------------------------*/
    /*	Section */
    /*-----------------------------------------------------------------------------------*/
    $('.section-title').prepend('<i class="line"></i>');

    /*-----------------------------------------------------------------------------------*/
    /*	Tweets List */
    /*-----------------------------------------------------------------------------------*/
    $('#tweets-list').carousel();

    $('.dropdown a').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });


});