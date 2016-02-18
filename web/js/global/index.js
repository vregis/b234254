/**
 * Created by toozzapc2 on 04.01.2016.
 */
 if((navigator.userAgent.indexOf ('Linux')!= -1 && navigator.userAgent.indexOf ('Android')== -1) || navigator.userAgent.indexOf ('Windows NT') != -1 || (navigator.userAgent.indexOf ('Mac')!= -1 && navigator.userAgent.indexOf ('iPad') == -1 && navigator.userAgent.indexOf ('iPhone') == -1)){
     // console.log("desktop");

 }else{
     $(".btn-empty").removeAttr('data-toggle').click(function(e){e.preventDefault();}).popover({
         placement: "top",
         trigger: "focus",
         html:true,
         content : 'Please use the computer to access the tool.'
     });
     $(".enter-btn").click(function(e){e.preventDefault();}).popover({
         placement: "top",
         trigger: "focus",
         html:true,
         content : 'Please use the computer to access the tool.'
     });
     // console.log("Mobile");
 }


/* Возвращает  высоту и ширину видимой области страницы */
function screenHeight() {
    //return $.browser.opera ? window.innerHeight : $(window).height();
}
function screenWidth() {
    return $.browser.opera ? window.innerWidth : $(window).width();
}
/* Возвращает  высоту и ширину видимой области страницы END */

/* Для открытия диалогового окна */
function open_dialog(id) {


    /**
     * При нажатии esc - закрываем окно
     */
    $(document).keyup(function (e) {
        // esc
        if (e.keyCode == 27) {
            close_dialog(id);
        }
    });

    /* центрует окно по середине */
    var margin_top = 0;
    var hight = parseInt($('.dialog-box#' + id).height());
    var win_hide = parseInt(screenHeight());
    if (hight > win_hide) {
        margin_top = pageYOffset;
    } else {
        margin_top = (win_hide - hight) / 2;
        margin_top = pageYOffset + margin_top -335;
    }

    if (hight < win_hide) {
        $("body").addClass("modal-open");
    }


    $('.dialog-box#' + id).css('margin-top', "-"+$('.dialog-box#' + id).outerHeight() / 2+"px");
    $('.dialog-box#' + id).css('margin-left', "-"+$('.dialog-box#' + id).outerWidth() / 2+"px");
    $(window).resize(function(){
           $('.dialog-box#' + id).css('margin-top', "-"+$('.dialog-box#' + id).outerHeight() / 2+"px");
    $('.dialog-box#' + id).css('margin-left', "-"+$('.dialog-box#' + id).outerWidth() / 2+"px");
    });
    /* центрует окно по середине end */

    var z_index = parseInt($('.dialog-box#' + id).attr('data-index'));
    $('.dialog-box#' + id).addClass('open');
    $('.dialog-box#' + id).css('z-index', z_index + 1);
    $('.dialog-box#' + id).after('<div class="back_background" style="z-index: ' + z_index + ';"></div>');
    $('.dialog-box#' + id + ' .dialog-close').attr('onclick', 'close_dialog("' + id + '");');
    $('.dialog-box#' + id + ' + .back_background').attr('onclick', 'close_dialog("' + id + '");');

    $('#form_review').focus();
}
function close_dialog(id) {
    $("body").removeClass("modal-open");
    $(".backdr").fadeOut(500);
    $('.dialog-box#' + id + ' .dialog-close').attr('onclick', '');
    $('.dialog-box#' + id).fadeOut(500);
    $('.dialog-box#' + id).removeClass('open');
    $('.dialog-box#' + id + ' + .back_background').remove();
}
