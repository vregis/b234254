$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
        csrf_token = $("meta[name=csrf-token]").attr("content"),
        loadingFlag = false;

    /**
     * Сохранение доп полей для конкурса
     */
    body.on('click', '#content_competition_dop_filds', function (e) {
        e.preventDefault();

        if (!loadingFlag) {
            loadingFlag = true;

            var form = $('#dop_polya_form');

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                dataType: 'json',
                data: form.serialize(),
                cache: false,
                //beforeSend: function () {
                //    jpreloader('show');
                //},
                success: function (data) {
                   //alert(data);
                    open_dialog('system_dialog')
                    //alert(data);
                    //$('.add-button-dop-fields').hide();
                        system_dialog(data);

                    //if (data.title) {
                    //    $('#content_title_view_text').text(data.title);
                    //    contentToggleBlock('content_title');
                    //    $('#content_select_type_block').removeClass('content-buttons-disabled');
                    //}

                    //jpreloader('hide');
                }
            });
            //открываю кнопку удаления
            //$('.content-close-content').show();
            loadingFlag = false;
        }
    });

    /**
     * Редактирование блока
     */
    body.on('click', '.content-edit-block', function (e) {
        e.preventDefault();

        hideAllForms();
        resetAllCreateForms();

        var data_id = $(this).attr('data-id');

        $('.content-text-edit-form').slideUp(500);
        $('.content-title').slideDown(600).css('opacity', 1);

        $('#content_view_' + data_id).slideUp(500);
        $('#content_form_' + data_id).slideDown(600).css('opacity', 1);
        $('#content_form_' + data_id + '_input-form').slideDown(600).css('opacity', 1);
        $('.form-content-add').css('opacity', 1);

        // отключаем сортировку
        $('#content_block_sortable').sortable('disable');
        registerFormKeys('#content_block_sortable');
    });

    /**
     * Скрытие формы редактирования и вывод отображения
     */
    body.on('click', '.content-cancel-edit-block', function (e) {
        e.preventDefault();

        var data_id = $(this).attr('data-id');

        if (data_id) {
            $('#content_view_' + data_id).slideDown(600).css('opacity', 1);
            $('#content_form_' + data_id).slideUp(500);
        } else {
            $(this).closest('content-title').slideDown(600).css('opacity', 1);
            $(this).closest('form').slideUp(500);
        }

        resetAllCreateForms();

        // включаем сортировку
        $('#content_block_sortable').sortable('enable');
    });

    /**
     * Кнопка "Добавить текст"
     */
    $('#content_add_text_button').click(function () {
        hideAllForms();
        $('.add-text-sp').slideDown(600).css('opacity', 1);
    });

    /**
     * Кнопка "Добавить фото"
     */
    $('#content_add_photo_button').click(function () {
        hideAllForms();
        $('#content_form_photo').slideDown(600).css('opacity', 1);
    });

    /**
     * Кнопка "Добавить видео"
     */
    $('#content_add_video_button').click(function () {
        hideAllForms();
        $('#content_create_forms').find('input[type="text"]').prop('disabled', false).css('background', '#ccc').removeClass('video-not-editable');
        $('#content_form_video').slideDown(600).css('opacity', 1);
    });

    /**
     * Кнопки добавления нового текста
     */
    $('.add-text-sp .btn-bl .a-bl').click(function (e) {
        e.preventDefault();

        resetAllCreateForms();

        var item = $(this).attr('data-form');

        $('.form-content-add').slideUp("slow", function () {
            $(this).hide();
            $(this).removeClass('active');
        });

        switch (item) {
            case 'title':
                $('#content_form_title').slideDown(600).css('opacity', 1);
                break;
            case 'text':
                $('#content_form_text').slideDown(600).css('opacity', 1);
                break;
            case 'quote':
                $('#content_form_quote').slideDown(600).css('opacity', 1);
                break;
            case 'spisok':
                $('#content_form_list').slideDown(600, function () {
                    $(this).addClass('active');
                }).css('opacity', 1);
                break;
        }
    });

    /**
     * Отправка форм по нажатию на Enter
     */
    $('.content-text-edit-form input[type="text"]').on("keyup keypress", function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            $(this).closest('form').find('.content-text-edit-form-submit').click();
            return false;
        }
    });

    /**
     * Отправка формы заголовка контента по нажатию на Enter
     */
    $('#content_title_form_title').on("keyup keypress", function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            $('#content_title_form_submit').click();
            //открываю кнопку удаления
            $('.content-close-content').show();
            return false;
        }
    });

    /**
     * Отправка textarea по нажатию на ctrl+enter
     */
    $('.content-text-edit-textarea').on("keyup keypress", function (e) {
        var code = e.keyCode || e.which;
        if (e.ctrlKey && code == 13) {
            e.preventDefault();
            $(this).closest('form').find('.content-text-edit-form-submit').click();
            return false;
        }
    });

    /**
     * Создание нового контента
     */
    body.on('click', '#content_create', function (e) {
        e.preventDefault();

        if (!loadingFlag) {
            loadingFlag = true;

            var self = $(this);

            $.ajax({
                type: 'GET',
                url: self.attr('data-action'),
                dataType: 'json',
                cache: false,
                beforeSend: function () {
                    jpreloader('show');
                },
                success: function (data) {
                    if (data.message) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Сохранение заголовка контента
     */
    body.on('click', '#content_title_form_submit', function (e) {
        e.preventDefault();

        //выводить на экран доп поля для конкурсов//
        $('#content_dop_polya_form').show();

        if (!loadingFlag) {
            loadingFlag = true;

            var form = $('#content_title_form');

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                dataType: 'json',
                data: form.serialize(),
                cache: false,
                beforeSend: function () {
                    jpreloader('show');
                },
                success: function (data) {
                    if (data.message) {
                        system_dialog(data.message);
                    }
                    if (data.title) {
                        $('#content_title_view_text').text(data.title);
                        contentToggleBlock('content_title');
                        $('#content_select_type_block').removeClass('content-buttons-disabled');
                        if (data.price) {
                            $('#content_title_view_price').text('Цена: ' + data.price);
                        }
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
            //открываю кнопку удаления
            $('.content-close-content').show();
        }
    });

    /**
     * Удаление блока
     */
    body.on('click', '.content-delete-block', function (e) {
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

                    if (data.message) {
                        system_dialog(data.message);
                    }

                    if (data.status) {
                        $('#content_block_' + data.block_id).slideUp("slow", function () {
                            $(this).remove();
                        });
                    }

                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Удаление контента
     */
    body.on('click', '.content-delete-content', function (e) {
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
                    if (data.message) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }
            });
        }
    });
    /**
     * Закрытие контента
     * KOstya
     */
    body.on('click', '.content-close-content', function (e) {
        e.preventDefault();
        var self = $(this);
        system_dialog(self.attr('data-confirm_message'));
        $('.button-green').attr('onclick', 'window.location.href="/user_media/content-unpublished"');
    });

    /**
     * Сортировка блоков
     */
    $('#content_block_sortable').sortable({
        axis: 'y',
        opacity: 0.5,
        cursor: 'move',
        distance: 24,
        update: function () {
            var data = $(this).sortable('serialize'),
                url = $(this).attr('data-sort_url');
            $.post(url, {'order': data, '_csrf': csrf_token}, function (data) {
                if (data.message) {
                    system_dialog(data.message);
                }
            });
        }
    });

    /**
     * Редактировать заголовок контента
     */
    body.on('click', '.content-title-edit', function () {
        hideAllForms();
        $('#content_title_view').slideUp();
        $('#content_title_form').slideDown(600).css('opacity', 1);
    });

    /**
     * Отмена редактирования заголовка контента
     */
    body.on('click', '.content-title-cancel', function () {
        hideAllForms();
        $('#content_title_view').slideDown(600).css('opacity', 1);
        $('#content_title_form').slideUp();
    });

    body.on('click', '.exit-submit ', function () {
        jpreloader('hide');
    });

    /**
     * Публикация контента
     */
    body.on('click', '#content_publish_button', function (e) {
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
                    if (data.message) {
                        system_dialog(data.message);
                    }
                    if (data.url) {
                        window.location = data.url;
                        return false;
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }

    });
});

/**
 * Переключает тип списка (ul / ol)
 *
 * @param item
 * @param id
 * @param type
 */
function changeListType(item, id, type) {

    var form_spisok = $('#' + id + ' .form-spisok'),
        spisok_sp = $('#' + id + ' .content-title-spisok .spisok-sp'),
        btn_spisok = $('#' + id + ' .spisok-btn .btn-spisok');

    switch (item) {
        case 'point':
            form_spisok.addClass('spisok-point');
            btn_spisok.removeClass('active');
            $('#' + id + ' .spisok-btn .btn-spisok.point-bl').addClass('active');
            spisok_sp.addClass('spisok-point');
            break;
        case 'number':
            form_spisok.removeClass('spisok-point');
            btn_spisok.removeClass('active');
            $('#' + id + ' .spisok-btn .btn-spisok.number-bl').addClass('active');
            spisok_sp.removeClass('spisok-point');
            break;
    }
    // устанавливаем тип списка в скрытый инпут
    $('#' + id + ' .content-text-type').val(type);
}

/**
 * Добавляет новый элемент списка
 */
function addListItem(id) {

    var size = $('#' + id + ' .form-spisok div.input-lines').length + 1;

    $('#' + id + ' .form-spisok')
        .append($('<div>', {class: 'input-lines'})
            .append($('<label>', {for: 'list_item_' + size})
                .append(size))
            .append($('<div>', {class: 'input-bl'})
                .append($('<input>', {
                    type: 'text',
                    class: 'list_item_input',
                    id: 'list_item_' + size,
                    name: 'ContentText[text][]'
                }))
        )
    );

    $('#' + id + ' .total-items-in-list').val(size);
}

/**
 * Скрывает/отображает форму редактирования/контент блока
 *
 * @param id
 * @returns {boolean}
 */
function contentToggleBlock(id) {
    resetAllCreateForms();
    //hideAllForms();
    $('#' + id + '_view').slideToggle();
    $('#' + id + '_form').slideToggle();
}

/**
 * nl2br
 *
 * @param str
 * @param is_xhtml
 * @returns {string}
 */
function nl2br(str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

/**
 * Сбрасывает формы создания контента
 */
function resetAllCreateForms() {
    var formsBlock = $('#content_create_forms');
    formsBlock.find('input[type="text"]').val('');
    formsBlock.find('input[type="text"]').prop('disabled', false).css('background', '#ccc').removeClass('video-not-editable');
    formsBlock.find('textarea').val('');
    formsBlock.find('img').attr('src', '');
    formsBlock.find('.content-preview').text('');
    formsBlock.find('.content-video-step2-form').hide();
    formsBlock.find('.input-video').removeClass('next2');
    $('#content_block_sortable').sortable('refresh');
    AddDopFields();
}

/**
 * Срывает все формы
 */
function hideAllForms() {
    var contentUpdateBlock = $('#content_update_block');
    contentUpdateBlock.find('form').slideUp(500);
    contentUpdateBlock.find('.add-text-sp').slideUp(500);
    $('#content_block_sortable > div').slideDown(600).css('opacity', 1);
    $('#content_title_view').slideDown(600).css('opacity', 1);
    $('#content_block_sortable form').slideUp(600);
    $('#content_block_sortable .content-title').slideDown(600).css('opacity', 1);
    AddDopFields();

}

function registerFormKeys(id) {
    $(id + ' input[type="text"]').on("keyup keypress", function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            $(this).closest('form').find('button').click();
            return false;
        }
    });

    $(id + ' textarea').on("keyup keypress", function (e) {
        var code = e.keyCode || e.which;
        if (e.ctrlKey && code == 13) {
            e.preventDefault();
            $(this).closest('form').find('button').click();
            return false;
        }
    });
}

// Показывает доп поля
function AddDopFields(){
    $('#content_dop_polya_form').show();
    $('#dop_polya_form').css('display','block');

}


