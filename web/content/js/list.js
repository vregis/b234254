$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
        csrf_token = $("meta[name=csrf-token]").attr("content"),
        loadingFlag = false;

    /**
     * Показать еще для модераторов (пейджер)
     */
    body.on('click', '#content_show_more', function () {
        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            var self = $(this),
                page = parseInt(self.attr('data-page')),
                total = parseInt(self.attr('data-total'));

            $.ajax({
                type: 'POST',
                url: self.attr('data-url'),
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
                    self.attr('data-page', page);

                    // вставляем полученные записи после имеющихся в наш блок
                    $('#content_spisok').append(data);
                    sortableContent('#content_spisok .content-spisok-sp');

                    // если достигли максимальной страницы, то прячем кнопку
                    if (page >= total) {
                        self.hide();
                    }
                    jpreloader('hide');
                    loadingFlag = false;
                }
            });
        }
    });

    /**
     * Показать еще для пользователей без сортировки контента
     */
    body.on('click', '#content_show_more_user', function () {
        // защита от повторных нажатий
        if (!loadingFlag) {
            // выставляем блокировку
            loadingFlag = true;

            var self = $(this),
                page = parseInt(self.attr('data-page')),
                total = parseInt(self.attr('data-total'));

            $.ajax({
                type: 'POST',
                url: self.attr('data-url'),
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
                    self.attr('data-page', page);

                    // вставляем полученные записи после имеющихся в наш блок
                    $('#content_spisok_user').append(data);

                    // если достигли максимальной страницы, то прячем кнопку
                    if (page >= total) {
                        self.hide();
                    }
                    jpreloader('hide');
                    loadingFlag = false;
                }
            });
        }
    });

    sortableContent('#content_spisok .content-spisok-sp');
});

/**
 * Сохраняет сортировку контента
 *
 * @param url
 * @param showPreloader
 * @returns {*}
 */
function saveContentSorting(url, showPreloader) {

    if (typeof showPreloader == 'undefined') {
        showPreloader = true;
    }

    var sortArr = getContentSortArray(),
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
 * Сортировка контента
 *
 * @param id
 */
function sortableContent(id) {

    var content_spisok_sp = $('#content_spisok .content-spisok-sp');

    $(id).sortable({
        connectWith: ".content-spisok-sp",
        opacity: 0.8,
        cursor: 'move',
        distance: 10,
        start: function (event, ui) {
            sortable_id_start = event.target.id;
            content_spisok_sp.addClass('active');
        },
        stop: function (event, ui) {
            content_spisok_sp.removeClass('active');
            // сортировка
            var request = saveContentSorting($('#content_sort_url').attr('data-url'), false);
            request.success(function (dataSort) {
                /*console.log('success');*/
                $('#content_spisok .content-spisok-photo').removeAttr('data-new');
                jpreloader('hide');
            });
            refreshBlocks();
        },
        receive: function (event, ui) {
            var sortable_id_receive = '',
                sortable_count_receive = '',
                sortable_count_start = '';

            sortable_count_start = $('#' + sortable_id_start + ' div.content-spisok-bl').length;
            sortable_id_receive = event.target.id;
            sortable_count_receive = $('#' + sortable_id_receive + ' div.content-spisok-bl').length;
            /* Отмена если больше 4 изображений и меньше 1 */

            if (parseInt(sortable_count_receive) > 3) {
                $('#' + sortable_id_start + ', #' + sortable_id_receive).sortable("cancel");
            } else if (!parseInt(sortable_count_start)) {
                $('#' + sortable_id_start).remove();
            } else if (parseInt(sortable_count_start) == 2) {

            }

            /* Подставляет класс чтоб не ехала верстка */
            $('#' + sortable_id_start).attr('class', 'content-spisok-sp count-img-' + parseInt($('#' + sortable_id_start + ' div.content-spisok-bl').length));
            $('#' + sortable_id_receive).attr('class', 'content-spisok-sp count-img-' + parseInt($('#' + sortable_id_receive + ' div.content-spisok-bl').length));
            $('#' + sortable_id_start + ' div.content-spisok-bl').attr('style', '');
            $('#' + sortable_id_receive + ' div.content-spisok-bl').attr('style', '');


            /* Вставка нового элемента если вставили в самый верх */
            if ($('#' + sortable_id_receive).attr('data-item') == 'begin') {
                var count_bl = $(id).length;
                var data_new = parseInt($('#' + sortable_id_receive).attr('data-new')) + 1;
                $('#' + sortable_id_receive).addClass('content-spisok-photo');

                $('#' + sortable_id_receive).attr('data-item', '');
                $('#content_spisok').prepend('<div class="content-spisok-sp count-img-0" id="sortable_new' + data_new + '" data-item="begin" data-new="' + data_new + '"></div>');
                sortableContent('#sortable_new' + data_new);
            }

        }
    });
    //$(id).sortable("option", "delay", 150);
    //$(id ).sortable( "option", "placeholder", "sortable-placeholder");
}

/**
 *
 */
function refreshBlocks() {
    var block = '#content_spisok .content-spisok-sp',
        count_img = 0,
        count_bl = $(block).length,
        content_id = 0,
        content_id_prev = 0;

    for (var i = 1; i <= count_bl; i++) {
        count_img = $(block + ':nth-child(' + i + ') .content-spisok-bl').length;
        if (count_img > 0) {
            for (var j = 1; j <= count_img; j++) {
                content_id = $(block + ':nth-child(' + i + ') .content-spisok-bl:nth-child(' + j + ')').attr('data-content_id');
                /*if (count_img == 2 && j == 1) {
                 $('#content_' + content_id).addClass('small');
                 content_id_prev = content_id;
                 } else if (count_img == 2 && j == 2) {
                 if (content_id_prev > content_id) {
                 $('#content_' + content_id_prev).removeClass('small');
                 $('#content_' + content_id).addClass('small');
                 } else {
                 $('#content_' + content_id).removeClass('small');
                 }
                 }*/
            }
        }
    }
}

/**
 * Возвращает массив с позициями контента (матрица)
 *
 * @returns {*}
 */
function getContentSortArray() {
    var block = '#content_spisok .content-spisok-sp',
        count_img = 0,
        count_bl = $(block).length,
        content_id = 0,
        pos_x = 0,
        pos_y = 0,
        pos_x_new = 0,
        pos_y_new = 0,
        obj = {},
        obj_new = 0,
        data_new_count = 0;

    /*console.log(count_bl);*/
    for (var i = 1; i <= count_bl; i++) {
        count_img = $(block + ':nth-child(' + i + ') .content-spisok-bl').length;
        if (count_img > 0) {
            if ($(block + ':nth-child(' + i + ')').attr('data-new')) {
                for (var j = 1; j <= count_img; j++) {
                    content_id = $(block + ':nth-child(' + i + ') .content-spisok-bl:nth-child(' + j + ')').attr('data-content_id');
                    pos_x_new = j - 1;
                    obj_new = parseInt(content_id);
                }
                pos_y_new = pos_y_new + 1;
            } else {
                obj[pos_y] = {};
                for (var j = 1; j <= count_img; j++) {
                    content_id = $(block + ':nth-child(' + i + ') .content-spisok-bl:nth-child(' + j + ')').attr('data-content_id');
                    pos_x = j - 1;
                    obj[pos_y][pos_x] = parseInt(content_id);
                }
                pos_y = pos_y + 1;
            }

        }
    }
    obj['new'] = obj_new;
    /*console.log(JSON.stringify(obj));*/

    return JSON.stringify(obj);
}