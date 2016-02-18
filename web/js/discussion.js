$(document).ready(function () {

    // скрываем стандартный навигатор
    $('.paginator').hide();

    // глобальные переменные
    var body = $('body');
    var button = $('#discussion-show-more');
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var loadingFlag = false;

    body.on('click', '#create_discussion_dialog_open', function () {
        system_dialog('Создание обсуждений временно отключено.');
        return false;
    });

    /**
     * Задать вопрос
     */
    $('#form_ask_questions').validate({
        errorClass: 'error',
        success: '',
        errorElement: "span",
        rules: {
            "Discussion[title]": {
                required: true,
                minlength: 2
            },
            "Discussion[content]": {
                required: true,
                minlength: 2
            }
        },
        submitHandler: function (form) {

            var form_ask_questions = $('#form_ask_questions');

            if (!loadingFlag) {
                loadingFlag = true;

                $.ajax({
                    type: 'POST',
                    url: form_ask_questions.attr('action'),
                    dataType: 'json',
                    data: form_ask_questions.serialize(),
                    cache: false,
                    beforeSend: function (xhr) {
                        jpreloader('show');
                    },
                    success: function (data) {
                        if (data.url) {
                            window.location = data.url;
                            return false;
                        }

                        if (!data.url && data) {
                            // если объект с массивом ошибок, в цикле показываем ошибки для каждого поля
                            if (data instanceof Object) {
                                for (var key in data) {
                                    var id_input = $(".discussion-" + key).attr('id');
                                    $("#" + id_input).addClass('error');
                                    $("#" + id_input).after('<span for="' + id_input + '" class="error">' + data[key] + '</span>');
                                    $("#" + id_input + " + span").show();
                                }
                            }
                        }
                        loadingFlag = false;
                        jpreloader('hide');
                    }
                });
            }
        }
    });

    /**
     * Форма добавления коментариев
     */
    $('#form_add_comments').validate({
        errorClass: 'error',
        success: '',
        errorElement: "span",
        rules: {
            "Comment[content]": {
                required: true
            }
        },
        submitHandler: function (form) {

            var form_add_comments = $('#form_add_comments');

            if (!loadingFlag) {
                loadingFlag = true;

                $.ajax({
                    type: 'POST',
                    url: form_add_comments.attr('action'),
                    dataType: 'json',
                    data: form_add_comments.serialize(),
                    cache: false,
                    beforeSend: function (xhr) {
                        jpreloader('show');
                    },
                    success: function (data) {

                        if (data.url) {
                            window.location = data.url;
                        }

                        if (!data.url && data) {
                            $('#form_add_comments_content').addClass('error');
                            $('#form_add_comments_content').after(
                                '<span for="form_add_comments_content" class="error">' + data['content'] + '</span>'
                            );
                            $('#form_add_comments_content + span').show();
                        }
                        loadingFlag = false;
                        jpreloader('hide');
                    }
                });
            }
        }
    });

    /**
     * Показать еще (пейджер)
     */
    body.on('click', '#discussion-show-more', function () {

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            var page = parseInt(button.attr('data-page'));
            var total = parseInt(button.attr('data-total'));

            $.ajax({
                type: 'POST',
                url: window.location.href,
                data: {
                    // передаём номер нужной страницы методом POST
                    'page': page + 1,
                    '_csrf': csrf_token
                },
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {
                    // увеличиваем номер текущей страницы и снимаем блокировку
                    page++;
                    $('#discussion-show-more').attr('data-page', page);

                    // вставляем полученные записи после имеющихся в наш блок
                    $('.gamer_comments').append(data);

                    // если достигли максимальной страницы, то прячем кнопку
                    if (page >= total) {
                        $('#discussion-show-more').hide();
                    }
                    jpreloader('hide');
                    loadingFlag = false;
                }
            });
        }
    });
});
