$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
            csrf_token = $("meta[name=csrf-token]").attr("content"),
            loadingFlag = false;

    /**
     * Голосование
     */
    body.on('click', '.content-rating-button', function (e) {
        e.preventDefault();

        if (!loadingFlag) {
            loadingFlag = true;

            var self = $(this);
            // если есть клас non , то не разрешать голосовать
            if (self.hasClass("non")) {                
                return false;
            }

            $.ajax({
                type: 'GET',
                url: self.attr('data-url'),
                dataType: 'json',
                cache: false,
                error: function (data) {
                    loadingFlag = false;
                    system_dialog(data.responseJSON.message);
                },
                success: function (data) {
                    if (data.message) {
                        system_dialog(data.message);
                    }
                    if (data.status) {
                        var parent_block = self.parent();
                        parent_block.find('.content-rating-count-likes').text(data.count_likes);
                        parent_block.find('.content-rating-count-dislikes').text(data.count_dislikes);
                        parent_block.find('.content-rating-button').removeClass('active');
                        self.addClass('active');
                    }
                    loadingFlag = false;
                }
            });
        }
    });
});