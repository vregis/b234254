$(document).ready(function () {

    // глобальные переменные
    var body = $('body');
    var loadingFlag = false;
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    /**
     * Удаление фото
     */
    body.on('click', '.upload-photo-remove', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!confirm(self.attr('data-confirm_message'))) {
            return false;
        }

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: self.attr('data-url'),
                data: {
                    _csrf: csrf_token
                },
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {
                    if (data.status) {
                        $(self).closest('.file-upload-bl').slideUp('normal', function () {
                            $(self).remove();
                        });
                    } else {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Добавление нового альбома с изображениями
     */
    /*body.on('click', '#create-album-button', function (e) {
     e.preventDefault();
     window.location = $(this).attr('data-url');
     });*/

    /**
     * Переключение на другой альбом в диалоговом окне просмотра фото
     */
    body.on('click', '.dialog-album-photo-other-album', function (e) {

        e.preventDefault();

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: $(this).attr('data-url'),
                data: {
                    _csrf: csrf_token
                },
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {
                    close_dialog('dialog_foto');
                    $('.dialog-foto').html(data);
                    create_dialog_big_img(0);
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Голосование за фото
     */
    body.on('click', '#dialog-album-photo a', function (e) {
        e.preventDefault();

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            $.ajax({
                type: 'GET',
                url: '/rating/vote/' + $(this).attr('data-type') + '/user-media/photo/' + $('#current-id').val(),
                dataType: 'json',
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {
                    if (data.status) {
                        /* меняем количество лайков или дислайков на +1 */
                        if (data.change_counters) {
                            $('#rating-count-likes').text(data.count_likes);
                            $('#rating-count-dislikes').text(data.count_dislikes);
                        }
                    } else {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                }
            });
        }
    });

    /**
     * Голосование за видео
     */
    body.on('click', '#vote-media-video a', function (e) {

        e.preventDefault();

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            $.ajax({
                type: 'GET',
                url: '/rating/vote/' + $(this).attr('data-type') + '/user-media/video/' + $('#current-id').val(),
                dataType: 'json',
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {
                    if (data.status) {
                        /* меняем количество лайков или дислайков на +1 */
                        if (data.change_counters) {
                            $('#rating-count-likes').text(data.count_likes);
                            $('#rating-count-dislikes').text(data.count_dislikes);
                        }
                    } else {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                }
            });
        }
    });

    /**
     * Подгрузка комментариев
     */
    body.on('click', '#foto_comment_active', function (e) {

        e.preventDefault();

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            $.ajax({
                type: 'GET',
                url: $(this).attr('href') + '/' + $('#current-id').val(),
                dataType: 'json',
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {
                    if (data) {
                        $('#user-media-photo-comments').html(data);
                        $("#user-media-photo-comments").scrollTop($('#user-media-photo-comments')[0].scrollHeight);
                    }
                    $('#form_comment_add textarea').focus();
                    jpreloader('hide');
                    loadingFlag = false;
                }
            });
        }
    });

    /**
     * Добавление нового комментария
     */
    body.on('click', '#form_comment_add button', function (e) {

        e.preventDefault();

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: $(this).attr('data-url') + '/' + $('#current-id').val(),
                dataType: 'json',
                data: $('#form_comment_add').serialize(),
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {
                    if (data.status) {
                        $('#form_comment_add textarea').removeClass('error').val('').focus();
                        $('#user-media-photo-comments').html(data.comments);
                        $("#user-media-photo-comments").scrollTop($('#user-media-photo-comments')[0].scrollHeight);
                        $('#total_comments').text(parseInt($('#total_comments').text()) + 1);
                        // do fading 2 times
                        for (i = 0; i < 2; i++) {
                            $('#user-comment-' + data.id).fadeTo('normal', 0.1).fadeTo('fast', 1.0);
                        }
                    } else if (!data.status && data.message) {
                        system_dialog(data.message);
                    } else {
                        $('#form_comment_add textarea').addClass('error').focus();
                    }
                    jpreloader('hide');
                    loadingFlag = false;
                }
            });
        }
    });

    /**
     * Смена обложки альбома
     */
    body.on('click', '#user-media-set-cover', function (e) {

        e.preventDefault();

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: $(this).attr('href'),
                data: {
                    _csrf: csrf_token,
                    photo_id: $(this).attr('data-photo_id')
                },
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {
                    system_dialog(data.message);
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * При изменении ссылки + снятии фокуса - отправляем форму
     */
    body.on('change', '#video-url', function (e) {
        $('.video-button-get-data').click();
    });

    /**
     * При нажатии клавиши в инпуте - очищаем загруженный контент
     */
    body.on('keyup', '#video-url', function (e) {
        clear_video_form();
    });

    /**
     * При вставке ссылки (paste) - отправляем форму
     */
    body.on('paste', '#video-url', function (e) {
        /* @see http://stackoverflow.com/questions/686995/catch-paste-input */
        setTimeout(function () {
            $('.video-button-get-data').click();
        }, 100);
    });

    /**
     * Добавление нового видео
     * 1 - получение информации о видео
     */
    body.on('click', '.video-button-get-data', function (e) {

        e.preventDefault();

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            var create_video_form = $('#create-video-form');

            $.ajax({
                type: 'POST',
                url: create_video_form.attr('action'),
                dataType: 'json',
                data: create_video_form.serialize(),
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {

                    $('#video-url-error').remove();
                    $('#video-url').removeClass('error');

                    if (data.status) {
                        $('#create-video-form').attr('action', '/user/media/video/create');
                        $('#video-info').html(data.html);
                        $('#create-video-button').text(data.saveText);
                        $('#create-video-button').addClass('video-button-create').removeClass('video-button-get-data');
                        center_dialog('create_video_win');
                    } else {
                        // errors
                        $('#video-info').empty();
                        $('#video-url').addClass('error');
                        $('#video-url').after('<span for="video-url" id="video-url-error" class="error" style="width:560px;">'
                        + data.message +
                        '</span>');
                        $('#video-url' + ' + span').show();
                    }
                    jpreloader('hide');
                    loadingFlag = false;
                }
            });
        }
    });

    /**
     * Добавление нового видео
     * 2 - создание видео
     */
    body.on('click', '.video-button-create', function (e) {

        e.preventDefault();

        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            var create_video_form = $('#create-video-form');

            $.ajax({
                type: 'POST',
                url: create_video_form.attr('action'),
                dataType: 'json',
                data: create_video_form.serialize(),
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {

                    $('span.error').remove();
                    $('#create_video_win input').removeClass('error');

                    if (data.url) {
                        window.location = data.url;
                        return false;
                    }

                    if (!data.url && data) {
                        // если объект с массивом ошибок, в цикле показываем ошибки для каждого поля
                        if (data instanceof Object) {
                            for (var key in data) {
                                var id_input = $(".video-" + key).attr('id');
                                $("#" + id_input).addClass('error');
                                $("#" + id_input).after('<span for="' + id_input + '" class="error" style="width:560px;">' + data[key] + '</span>');
                                $("#" + id_input + " + span").show();
                            }
                        }
                    }
                    jpreloader('hide');
                    loadingFlag = false;
                }
            });
        }
    });

    /**
     * Окно просмотра видео
     */
    body.on('click', '.open_video_dialog', function (e) {

        e.preventDefault();

        register_video_dialog_keys();

        // закрываем и очищаем старый диалог
        close_dialog('dialog_video');
        $('#video_dialog_block').empty();

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: '/user/media/video/get-video/' + $(this).closest('.block-video-id').attr('data-id'),
                dataType: 'json',
                data: {
                    _csrf: csrf_token
                },
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {
                    if (data.status) {
                        $('#video_dialog_block').html(data.html);
                        open_dialog('dialog_video');
                    } else {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Автосохранение названия альбома
     */
    body.on('focusout', '#album-title', function (e) {
        e.preventDefault();

        var album_id = $('#current_album_id').val(),
            title = $(this).val();

        $.post('/user/media/album/update-title?album_id=' + album_id, {_csrf: csrf_token, title: title});
    });

});

/**
 * Переопределяем close_dialog для очистки данных при закрытии диалога
 *
 * @param id
 */
function close_dialog(id) {

    $("body").removeClass("modal-open");

    // удаляем фрейм с видео при закрытии
    if (id == 'dialog_video') {
        $('#youtube_iframe').remove();
    }

    clear_video_form();

    $('#video-url').val('');

    $('.dialog-box#' + id + ' .dialog-close').attr('onclick', '');
    $('.dialog-box#' + id).css('z-index', 0);
    $('.dialog-box#' + id).removeClass('open');
    $('.dialog-box#' + id + ' + .back_background').remove();
}

/**
 * Горячие клавиши для видео диалога
 */
function register_video_dialog_keys() {
    $(document).keydown(function (e) {

        switch (e.which) {
            case 40: // down arrow
                e.preventDefault();
                if (!$('#foto_comment_active').hasClass('active')) {
                    $('#foto_comment_active').click();
                }
                break;
            case 38: // up arrow
                e.preventDefault();
                $('.foto-comment').click();
                break;
            case (e.ctrlKey && 13): // ctrl + enter
                e.preventDefault();
                $('#form_comment_add button').click();
                break;
        }
    });
}

/**
 * Горячие клавиши для фото диалога
 */
function register_photo_dialog_keys() {
    $(document).keydown(function (e) {

        switch (e.which) {
            case 40: // down arrow
                e.preventDefault();
                if (!$('#foto_comment_active').hasClass('active')) {
                    $('#foto_comment_active').click();
                }
                break;
            case 38: // up arrow
                e.preventDefault();
                $('.foto-comment').click();
                break;
            case 39: // right arrow
                e.preventDefault();
                $('.next').click();
                $('.foto-comment').click();
                break;
            case 37: // left arrow
                e.preventDefault();
                $('.prev').click();
                $('.foto-comment').click();
                break;
            case (e.ctrlKey && 13): // ctrl + enter
                e.preventDefault();
                $('#form_comment_add button').click();
                break;
        }
    });
}

/*
 * Просмотр фото
 */
function create_dialog_big_img(id) {
    register_photo_dialog_keys();
    open_dialog('dialog_foto');
    next_big_img(id);
}

function resize_dialog_big_img() {
    var margin_top = false;
    var max_width = false;
    var max_hight = false;

    if (screenWidth() > 1100) {
        max_width = screenWidth() - screenWidth() * 0.2;
        max_hight = screenHeight() - screenHeight() * 0.2;
        margin_top = parseInt(screenHeight() * 0.1)
    } else {
        max_width = screenWidth() - screenWidth() * 0.1;
        max_hight = screenHeight() - screenHeight() * 0.1;
        margin_top = parseInt(screenHeight() * 0.05);
    }

    img_width = max_width - 200;
    img_hight = max_hight - 60 - 70;

    $('#dialog_foto').attr('style', 'width: ' + max_width + 'px; height: ' + max_hight + 'px; margin-top: ' + margin_top + 'px; z-index: 1003;');
    $('#dialog_foto .foto-albums-sp').attr('style', 'height: ' + parseInt(max_hight - 60) + 'px;');
    $('#big_foto_bl .img-bl img').attr('style', 'max-width: ' + parseInt(max_width - 200) + 'px; max-height: ' + parseInt(max_hight - 60 - 70) + 'px;');
    $('#big_foto_bl ').attr('style', 'height: ' + parseInt(max_hight - 60 - 70) + 'px;');

    $('#dialog_foto .foto-comment-active').attr('style', 'height: ' + parseInt(max_hight) + 'px;');
    $('#dialog_foto .foto-comment-active .foto-com-tbl').attr('style', 'height: ' + parseInt(max_hight) + 'px;');
    $('#dialog_foto .foto-comment-active .comments-block').attr('style', 'height: ' + parseInt(max_hight - 130 - 60) + 'px;');
}

function next_big_img(id) {

    var next_id = false;
    var prev_id = false;
    var count_max = false;
    var id_bl = '';

    var img_width = false;
    var img_hight = false;

    id = parseInt(id);
    if (!id) {
        id = 0;
    }

    // очищаем блок с комментариями
    $('#user-media-photo-comments').empty();

    // рейтинг
    $.ajax({
        type: 'GET',
        url: '/user/media/photo/get-rating/' + img_massiv[id]['id'],
        async: true,
        error: function (data) {
            system_dialog(data.responseJSON.message);
        },
        success: function (data) {
            if (data.status) {
                $('#rating-count-likes').html(data.likes);
                $('#rating-count-dislikes').html(data.dislikes);
            } else {
                system_dialog(data.message);
            }
        }
    });

    // изображение
    for (var key in img_massiv) {
        count_max = key;
        if (parseInt(id) == parseInt(key)) {
            $('#big_foto_bl .img-bl img').attr('src', img_massiv[key].img_url);
            img_width = img_massiv[key].width;
            img_hight = img_massiv[key].height;
            $('#dialog-album-photo-description').html(img_massiv[key].description);
            $('#current-id').val(img_massiv[key].id);
            $('#dialog-album-title .photo-counter').text(parseInt(key) + 1 + '/' + img_massiv[key].total_photos);
            $('#total_comments').text(img_massiv[key].total_comments);
        }
    }

    // если фото 1 - убираем стрелки
    if (count_max == 0) {
        $('#big_foto_bl .prev').hide();
        $('#big_foto_bl .next').hide();
    }

    if (id == 0) {
        prev_id = count_max;
        next_id = id + 1;
    } else if (id == count_max) {
        next_id = 0;
        prev_id = id - 1;
    } else {
        next_id = id + 1;
        prev_id = id - 1;
    }

    $('#big_foto_bl .prev').attr('onClick', 'next_big_img(' + prev_id + ')');
    $('#big_foto_bl .next').attr('onClick', 'next_big_img(' + next_id + ')');
    resize_dialog_big_img();

    $(window).resize(function () {
        resize_dialog_big_img();
    });
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
 * Очищает форму добавления видео
 */
function clear_video_form() {
    $('#video-info').empty();
    $('#create-video-form').attr('action', '/user/media/video/get-data');
    $('#create-video-button').addClass('video-button-get-data').removeClass('video-button-create');
    $('span.error').remove();
    $('#create-video-form input').removeClass('error');
    $('#get-info-video-form input').removeClass('error');
}