$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
            csrf_token = $("meta[name=csrf-token]").attr("content"),
            loadingFlag = false;

    /**
     * Публикация контента
     */
    body.on('click', '.admin_content_publish_button', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!confirm(self.attr('data-confirm_message'))) {
            return false;
        }

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'GET',
                url: self.attr('data-url'),
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.content_id) {
                        if (data.count_contents == 0) {
                            window.location.reload();
                        }
                        $('#content_' + data.content_id).parent('.content-spisok-photo').slideUp('slow', function () {
                            $(this).remove();
                            system_dialog(data.success_message);
                            loadingFlag = false;
                            jpreloader('hide');
                        });
                    } else {
                        if (data.message) {
                            system_dialog(data.message);
                        }
                        loadingFlag = false;
                        jpreloader('hide');
                    }

                }
            });
        }

    });

    /**
     * Отказ публикация контента
     */
    body.on('click', '.send-message-cancel', function (e) {
        var message = $('#form_ask_questions_review').val();
        //alert(message);
        var id = $('#form_ask_questions .content_terget').val();
        close_dialog('okno_ask_questions');
        e.preventDefault();

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: 'admin-content-cancel',
                dataType: 'json',
                data: {
                    _csrf: csrf_token,
                    id: id,
                    message: message,
                },
                cache: false,
                beforeSend: function () {
                    jpreloader('show');
                },
                success: function (data) {
                    if (data.content_id) {
                        if (data.count_contents == 0) {
                            window.location.reload();
                        }
                        $('#content_' + data.content_id).parent('.content-spisok-photo').slideUp('slow', function () {
                            $(this).remove();
                            system_dialog(data.success_message);
                            loadingFlag = false;
                            jpreloader('hide');
                        });
                    } else {
                        if (data.message) {
                            system_dialog(data.message);
                        }
                        loadingFlag = false;
                        jpreloader('hide');
                    }
                }
            });
        }

    });



});
function beforSendMessage(id, cont_id) {
    open_dialog("okno_ask_questions");
    $('#form_ask_questions .user_terget').val(id);
    $('#form_ask_questions .content_terget').val(cont_id);
}