$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
        csrf_token = $("meta[name=csrf-token]").attr("content"),
        loadingFlag = false;

    /**
     * Удаление фотографии
     */
    body.on('click', '.content-delete-photo', function (e) {
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

                        var request = saveSorting(data.block_id, self.attr('data-sort_url'));
                        request.success(function (dataSort) {
                            /*console.log('Блок ' + dataSort.block_id + ' был успешно осортирован');*/
                            if (dataSort.message) {
                                system_dialog(dataSort.message);
                            }
                            var block = $('#content_block_' + dataSort.block_id);
                            block.fadeOut(500, function () {
                                block.replaceWith(dataSort.html).fadeIn(500);
                                $('#content_view_' + dataSort.block_id).hide().css('opacity', 0);
                                $('#content_form_' + dataSort.block_id).show().css('opacity', 1);
                            });
                            jpreloader('hide');
                        });
                    }

                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Нажатие кнопки "ОК" при редактировании фотографий
     */
    body.on('click', '.content-photo-edit-form-submit', function (e) {
        e.preventDefault();

        var request = saveSorting($(this).attr('data-block_id'), $(this).attr('data-url'));

        request.success(function (data) {
            if (data.message) {
                system_dialog(data.message);
            }
            var block = $('#content_block_' + data.block_id);
            block.fadeOut(500, function () {
                block.replaceWith(data.html).fadeIn(500);
            });
            jpreloader('hide');
        });
    });
});

/**
 * Сохраняет сортировку фотографий в блоке
 *
 * @param block_id
 * @param url
 * @param showPreloader
 * @returns {*}
 */
function saveSorting(block_id, url, showPreloader) {

    if (typeof showPreloader == 'undefined') {
        showPreloader = true;
    }

    var sortArr = getSortArray(block_id),
        loadingFlag = false;

    if (!loadingFlag) {
        loadingFlag = true;

        return $.ajax({
            type: 'POST',
            url: url,
            data: {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                sortArr: sortArr
            },
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                if (showPreloader) {
                    jpreloader('show');
                }
            },
            complete: function () {
                loadingFlag = false;
            }
        });
    }
}

var sortable_count_start = '',
    sortable_id_start = '';

/**
 * Сортировка изображений
 *
 * @param id
 * @param blockId
 */
function sortableImage(blockId, id) {

    if (blockId == 'none') {
        return false;
    }

    var block = '#content_block_' + blockId,
        sort_img_sp = $(block + ' .sort-img-main .sort-img-sp');

    if (id) {
        sort_img_sp = $('#' + id);
    }

    sort_img_sp.sortable({
        connectWith: block + ' .sort-img-sp',
        opacity: 0.8,
        cursor: 'move',
        distance: 10,
        start: function (event, ui) {
            sortable_id_start = event.target.id;
            sort_img_sp.addClass('active');
            /*console.log(sortable_id_start);*/
        },
        stop: function (event, ui) {
            sort_img_sp.removeClass('active');
        },
        receive: function (event, ui) {
            var sort_count_start = $(block + ' #' + sortable_id_start + ' div.sort-img-bl').length,
                sort_id_receive = event.target.id,
                sort_count_receive = $(block + ' #' + sort_id_receive + ' div.sort-img-bl').length;
            /* Отмена если больше 4 изображений и меньше 1 */

            if (parseInt(sort_count_receive) > 4) {
                $(block + ' #' + sortable_id_start + ', #' + sort_id_receive).sortable("cancel");
            } else if (!parseInt(sort_count_start)) {
                $(block + ' #' + sortable_id_start).remove();
            }

            /* Подставляет класс чтоб не ехала верстка */
            $(block + ' #' + sortable_id_start).attr('class', 'sort-img-sp sort-img-sp' + blockId + ' count-img-' + parseInt($('#' + sortable_id_start + ' div.sort-img-bl').length));
            $(block + ' #' + sort_id_receive).attr('class', 'sort-img-sp sort-img-sp' + blockId + ' count-img-' + parseInt($('#' + sort_id_receive + ' div.sort-img-bl').length));

            /*console.log($(block + ' #' + sort_id_receive).attr('data-item'));*/

            /* Вставка нового элемента если вставили в самый верх */
            var count_bl = $(block + ' .sort-img-main .sort-img-sp').length,
                data_item = $(block + ' #' + sort_id_receive).attr('data-item'),
                sort_id = 'sortable_img_' + count_bl + '_' + blockId + '_' + data_item;

            if (data_item == 'begin' || data_item == 'end') {
                $(block + ' #' + sort_id_receive).attr('data-item', '');
                var html = '<div class="sort-img-sp count-img-0" id="' + sort_id + '" data-item="' + data_item + '"></div>';
                if (data_item == 'begin') {
                    $(block + ' .sort-img-main').prepend(html);
                } else {
                    $(block + ' .sort-img-main').append(html);
                }
                sortableImage(blockId, sort_id);
            }
            // сортировка
            var request = saveSorting(blockId, $(block).find('.content-photo-edit-form-submit').attr('data-url'), false);
            request.success(function (dataSort) {
                jpreloader('hide');
            });
        }
    });
}

/**
 * Возвращает массив с позициями изображений (матрица)
 *
 * @param blockId
 * @returns {{}}
 */
function getSortArray(blockId) {

    var block = '#content_block_' + blockId + ' .sort-img-main .sort-img-sp',
        count_img = 0,
        count_bl = $(block).length,
        photo_id = 0,
        pos_x = 0,
        pos_y = 0,
        obj = {};

    for (var i = 1; i <= count_bl; i++) {
        count_img = $(block + ':nth-child(' + i + ') .sort-img-bl').length;
        if (count_img > 0) {
            obj[pos_y] = {};
            for (var j = 1; j <= count_img; j++) {
                photo_id = $(block + ':nth-child(' + i + ') .sort-img-bl:nth-child(' + j + ')').attr('data-photo_id');
                pos_x = j - 1;
                obj[pos_y][pos_x] = parseInt(photo_id);
            }
            pos_y = pos_y + 1;
        }
    }
    /*console.log(obj);*/
    return JSON.stringify(obj);
}