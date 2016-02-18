/* Возвращает  высоту и ширину видимой области страницы */
function screenHeight() {
    return $.browser.opera ? window.innerHeight : $(window).height();
}
function screenWidth() {
    return $.browser.opera ? window.innerWidth : $(window).width();
}

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
        margin_top = pageYOffset + margin_top;
    }

    if (hight < win_hide) {
        $("body").addClass("modal-open");
    }


    $('.dialog-box#' + id).css('margin-top', margin_top);
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

    $('.dialog-box#' + id + ' .dialog-close').attr('onclick', '');
    $('.dialog-box#' + id).css('z-index', 0);
    $('.dialog-box#' + id).removeClass('open');
    $('.dialog-box#' + id + ' + .back_background').remove();
}
/* Для открытия диалогового окна End */