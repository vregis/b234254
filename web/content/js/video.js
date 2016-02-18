$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
        csrf_token = $("meta[name=csrf-token]").attr("content"),
        loadingFlag = false;

    /**
     * При изменении ссылки + снятии фокуса - отправляем форму
     */
    body.on('change', '.content-video-edit-form-url', function (e) {
        //alert('change');
        // пытаемся получить видео
    });

    /**
     * При нажатии клавиши в инпуте - очищаем загруженный контент
     */
    body.on('keyup', '.content-video-edit-form-url', function (e) {
        //alert('keyup');
        clearVideoForm();
    });

    /**
     * При вставке ссылки (paste) - отправляем форму
     */
    body.on('paste', '.content-video-edit-form-url', function (e) {

        // отключаем повторную вставку
        if ($(e.target).is(".video-not-editable")) {
            return false;
        }

        var self = $(this);
        /* @see http://stackoverflow.com/questions/686995/catch-paste-input */
        setTimeout(function () {
            jpreloader('show');
            clearVideoForm();
            // парсим ссылку и пытаемся получить видео
            $.post(self.attr('data-url'), {url: self.val(), _csrf: csrf_token})
                .done(function (data) {

                    if (data.message) {
                        system_dialog(data.message);
                        self.closest('.content-video-edit-form-url').addClass('error');
                    }

                    if (data.html) {
                        self.closest('.content-video-edit-form-url').removeClass('error')
                            .prop('disabled', true).css('background', '#999').addClass('video-not-editable');
                        self.closest('.input-video').addClass('next2');
                        self.closest('.content-video-edit-form').slideUp('fast').append(data.html).slideDown('slow');
                    }

                    /** TODO: video type */
                    if (data.videoType) {
                        self.closest('.content-video-type').val(data.videoType);
                    }

                    jpreloader('hide');
                });
        }, 100);
    });

    /**
     * Сохранение видео
     */
    body.on('click', '.content-video-edit-form-submit', function (e) {
        e.preventDefault();

        if (!loadingFlag) {
            loadingFlag = true;

            var form = $(this).closest('form');

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                dataType: 'json',
                data: form.serialize() + '&content_id=' + $('#content_id').val(),
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        if (data.message) {
                            system_dialog(data.message);
                        }

                        if (data.html) {
                            if (data.isNew) {
                                $('#content_block_sortable').append(data.html);
                                $('#content_block_' + data.block_id).hide(1).slideDown('slow');
                                resetAllCreateForms();
                                $('#content_create_forms form').slideUp('normal');
                            } else {
                                $('#content_block_' + data.block_id).fadeOut(500, function () {
                                    $(this).replaceWith(data.html);
                                    $('#content_block_' + data.block_id).fadeIn(500);
                                });
                            }
                        }

                        loadingFlag = false;
                        jpreloader('hide');
                    }
                }
            });
        }
    });
});


/**
 * Очищает форму добавления видео
 */
function clearVideoForm() {
    $('#content_create_forms .content-video-edit-form input').empty();
    $('#content_create_forms .content-video-edit-form textarea').empty();
    $('#content_create_forms .content-video-edit-form img').attr('src', '');
}