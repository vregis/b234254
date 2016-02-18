$(document).ready(function () {

    // глобальные переменные
    var body = $('body');
    var loadingFlag = false;
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    /**
     * Обновление баланса
     */
    if (typeof disableTimeoutAjax == 'undefined') {

        setInterval(function () {
            if (!loadingFlag) {
                loadingFlag = true;
                $.ajax({
                    url: '/finance/get-balance',
                    type: 'GET',
                    dataType: 'json',
                    cache: false,
                    async: true,
                    success: function (data) {
                        $("#user_current_balance").html(data);
                        loadingFlag = false;
                    }
                });
            }
        }, 10000);
    }

    /* Проверка новых сообщений  */
    $.ajax({
        url: '/message/checkout',
        type: 'POST',
        dataType: 'json',
        data: {
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            //alert(data);
            if (data > 0) {
                $('.message-items').remove();
                $('.message-button').prepend('<div class=\"message-items\">' + data + '</div>');
            }
        }
    });
    /* Проверка новых сообщений END */


    /* Отправить отзыв */
    $('#form_add_review').validate({
        errorClass: 'error',
        success: '',
        errorElement: "span",
        rules: {
            "Guestbook[content]": {
                required: true,
                minlength: 5
            }
        },
        submitHandler: function (form) {

            if (!loadingFlag) {
                loadingFlag = true;

                $.ajax({
                    url: $('#form_add_review').attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $('#form_add_review').serialize(),
                    cache: false,
                    success: function (data) {

                        if (data.url) {
                            window.location = data.url;
                        }

                        if (!data.url && data) {

                            $('#form_add_review textarea').addClass('error');
                            $('#form_add_review textarea').after(
                                '<span for="form_review" class="error">' + data['content'] + '</span>'
                            );
                            $('#form_add_comments_content + span').show();

                        }

                        if (!data.url && data) {
                            // если объект с массивом ошибок, в цикле показываем ошибки для каждого поля
                            if (data instanceof Object) {
                                for (var key in data) {
                                    var id_input = $("." + key).attr('id');
                                    $("#" + id_input).addClass('error');
                                    $("#" + id_input).after('<span for="' + id_input + '" class="error">' + data[key][0] + '</span>');
                                    $("#" + id_input + " + span").show();
                                }
                            }
                        }
                        loadingFlag = false;
                    }
                });
            }
        }
    });
    /* Отправить отзыв END */

    /**
     * Удаление аватара
     */
    body.on('click', '#user_delete_avatar', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!confirm(self.attr('data-confirm_message'))) {
            return false;
        }

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                url: self.attr('data-url'),
                method: 'POST',
                dataType: 'json',
                data: {
                    '_csrf': csrf_token
                },
                cache: false,
                beforeSend: function () {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.status) {
                        $(".user_avatar").attr("src", data.avatar_url);
                        $("#user_delete_avatar").hide();
                    } else {
                        $("#system-dialog .body-dialog p").html(data.message);
                        open_dialog("system");
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Отправить сообщение в чат
     */
    body.on('click', '#index_chat_submit', function (e) {
        e.preventDefault();

        var index_chat_form = $('#index_chat_form');

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: index_chat_form.attr('action'),
                dataType: 'json',
                data: index_chat_form.serialize(),
                cache: false,
                beforeSend: function (xhr) {
                    //jpreloader('show');
                },
                success: function (data) {

                    if (data.status) {
                        $('#index_chat_textarea').val('');
                        loadIndexChatMessages();
                    }

                    if (!data.status && data.message.length > 0) {
                        $('#index_chat_textarea').val(data.filteredMessage);
                        system_dialog(data.message);
                    }

                    loadingFlag = false;

                    //jpreloader('hide');
                }
            });
        }
    });
});