$(document).ready(function () {

    // глобальные переменные
    var body = $('body');
    var loadingFlag = false;

    /**
     * Голосование
     */
    body.on('click', '.rating-button', function (e) {
        e.preventDefault();

        if ($(this).hasClass('onlyUser')) {
            return false;
        }

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            var current_id = $(this).attr('data-id');

            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                dataType: 'json',
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {

                    if (data.status) {
                        /* меняем количество лайков или дислайков на +1 */
                        if (data.change_counters) {
                            $('#rating-count-likes-' + current_id).text(data.count_likes);
                            $('#rating-count-dislikes-' + current_id).text(data.count_dislikes);
                        }

                        /* меняем суммарную оценку */
                        if (data.change_summary) {
                            $('#rating-summary-' + current_id).text(data.rating_summary);
                        }
                    } else {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                }
            });
        }
    });
});

/**
 * Открывает диалог с сообщением об ошибке/успехе
 *
 * @param message
 */
function system_dialog(message) {
    $('#system-dialog .body-dialog p').html(message);
    open_dialog('system-dialog');
    $('#system-dialog').css('position', 'absolute');
}

/**
 * Центрует окно по середине
 *
 * @param id
 */
function center_dialog(id) {
    var margin_top = 0;
    var hight = parseInt($('.dialog-box#' + id).height());
    var win_hide = parseInt(screenHeight());
    if (hight > win_hide) {
        margin_top = pageYOffset;
    } else {
        margin_top = (win_hide - hight) / 2;
        margin_top = pageYOffset + margin_top;
    }
    $('.dialog-box#' + id).css('margin-top', margin_top);
}