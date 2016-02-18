$(document).ready(function () {

    // глобальные переменные
    var body = $('body'),
        loadingFlag = false;

    /**
     * Если есть заголовок X-Redirect - редиректим
     */
    $(document).ajaxComplete(function (event, xhr, settings) {
        var url = xhr.getResponseHeader('X-Redirect');
        if (url) {
            window.location = url;
        }
    });

    /**
     * Отправка заявок друзьям из Steam
     */
    body.on('click', '#add-steam-friends', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                method: 'GET',
                url: self.attr('data-url'),
                dataType: 'json',
                cache: false,
                beforeSend: function (xhr) {
                    close_dialog('dialog_flash_message');
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.url) {
                        window.location = data.url;
                    }

                    if (!data.url && data.message) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
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
}

/**
 * Подгружает сообщения в чат игры
 */
function loadIndexChatMessages() {
    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            url: '/core/chat/get?id=' + $('#last_message_id').val(),
            type: 'GET',
            dataType: 'json',
            cache: false,
            async: true,
            success: function (data) {
                /** нет новых сообщений */
                if (data.noUpdate) {
                    return false;
                }
                $(".chat-messages").html(data.html);
                $(".chat-messages").scrollTop($('.chat-messages')[0].scrollHeight);
                if (data.lastMessageId) {
                    $('#last_message_id').val(data.lastMessageId);
                }
                loadingFlag = false;
            }
        });
    }
}

/**
 * @link http://stackoverflow.com/questions/17238222/ajax-chat-scroll-if-has-more-than-20-30-messages-scroll-to-bottom-will-work-if
 * @param block_id
 */
/*function appendItem(block_id, html) {
 var chat_block = $('#' + block_id),
 scrollPosition = chat_block.scrollTop(),
 scrollHeight = chat_block[0].scrollHeight;

 chat_block.append(html);

 if (scrollPosition + chat_block.height() === scrollHeight) {
 chat_block.scrollTop(scrollHeight);
 }
 }*/

/**
 * Горячие клавиши для чата
 */
function registerIndexChatKeys() {
    $('#index_chat_textarea').keydown(function (e) {

        switch (e.which) {
            case (13): // enter
                e.preventDefault();
                $('#index_chat_submit').click();
                break;
        }
    });
}
