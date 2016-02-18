$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
        csrf_token = $("meta[name=csrf-token]").attr("content"),
        loadingFlag = false;

    /**
     * Предпросмотр текста
     */
    $('.content-text-edit-form textarea, .content-text-edit-form input[type="text"]').on("keyup keypress focusout", function (e) {
        $(this).closest('form').find('.content-preview').html(nl2br($(this).val()));
    });

    /**
     * Сохранение текста
     */
    body.on('click', '.content-text-edit-form-submit', function (e) {
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

                    if (data.message) {
                        system_dialog(data.message);
                    }

                    if (data.status) {
                        if (data.isNew) {
                            $('#content_block_sortable').append(data.html);
                            $('#content_block_' + data.block_id).hide(1).slideDown('slow');
                            resetAllCreateForms();
                            $('#content_create_forms form').slideUp('normal');
                        } else {
                            $('#content_block_' + data.block_id).fadeOut(500, function () {
                                $(this).replaceWith(data.html);
                                $('#content_block_' + data.block_id).fadeIn(500);
                                registerFormKeys('#content_block_' + data.block_id);
                            });
                        }
                    }

                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Предпросмотр списка
     */
    body.on('keyup', '.content-list-text-inputs-block input', function (e) {
        var form_id = $(this).closest('form').attr('id'),
            inputs = $('#' + form_id + " .list_item_input:input"),
            total_items = $('#' + form_id + ' .total-items-in-list').val(),
            preview_block = $('#' + form_id + ' .content-list-text-preview .spisok-sp');

        preview_block.html('');
        var counter = 0;
        for (var i = 0; i < total_items; i++) {
            var value = inputs[i].value.trim();
            if (value.length > 0) {
                counter++;
                preview_block
                    .append($('<div>', {'class': 'spisok-bl'})
                        .append($('<div>', {'class': 'number-bl'})
                            .append(counter)
                    )
                        .append($('<div>', {'class': 'title-bl content-list-item-text'})
                            .append(value)
                    )
                );
            }
        }
    });
});