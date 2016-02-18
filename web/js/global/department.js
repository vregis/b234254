/**
 * Created by toozzapc2 on 22.12.2015.
 */

$(".button-sidebar").click(function () {

    // Set the effect type
    var effect = 'slide';

    // Set the options for the effect type chosen
    var options = { direction: 'left' };

    // Set the duration (default: 400 milliseconds)
    var duration = 400;

    $('#body-sidebar').toggle(effect, options, duration);
    var button_icon = $('#button-icon');
    if(button_icon.hasClass( 'icon-login' )) {
        button_icon.removeClass('icon-login');
        button_icon.addClass('icon-logout');
    }
    else if(button_icon.hasClass( 'icon-logout' )) {
        button_icon.removeClass('icon-logout');
        button_icon.addClass('icon-login');
    }
});
$(function () {
    var showPopover = function () {
        $(this).popover('show');

    };

    $('html').click(function(e) {
        $('#body-collapse [data-toggle="popover"],#body-sidebar [data-toggle="popover"]').popover('hide');
    });

    $('#body-sidebar .body-collapse-description [data-toggle="popover"]').popover({
        trigger:'manual',
        placement: "right"
    });
    $('#body-collapse [data-toggle="popover"],#body-sidebar [data-toggle="popover"]').click(function(e) {
        $(this).popover('toggle');
        $('#body-collapse [data-toggle="popover"],#body-sidebar [data-toggle="popover"]').not($(this)).popover("hide");
        e.stopPropagation();
    });

});

function updatePage() {
    var headerHeight = $('.page-header').outerHeight();
    var footerHeight = $('.page-footer').outerHeight();

    var height = $(window).height() - headerHeight - footerHeight;
    $('#body-sidebar').css('min-height',height + 'px');
    $('.button-sidebar span').css('top',height/2.05 + 'px');
}
$( document ).ready(updatePage);
$( window ).resize(updatePage);