$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
        csrf_token = $("meta[name=csrf-token]").attr("content"),
        loadingFlag = false;

    /**
     * Показать еще (пейджер)
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
             
                success: function (data) {
                    // увеличиваем номер текущей страницы и снимаем блокировку
                    page++;
                    self.attr('data-page', page);

                    // вставляем полученные записи после имеющихся в наш блок
                    $('#content_spisok').append(data);
                    //sortableContent('#content_spisok .content-spisok-sp');

                    // если достигли максимальной страницы, то прячем кнопку
                    if (page >= total) {
                        self.hide();
                    }
              
                    loadingFlag = false;
                }
            });
        }
    });

    //sortableContent('#content_spisok .content-spisok-sp');
});

