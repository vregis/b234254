$(document).ready(function () {

    /**
     * Глобальные переменные
     */
    var body = $('body'),
            csrf_token = $("meta[name=csrf-token]").attr("content"),
            loadingFlag = false;


    /**
     * Удаление контента
     */
    body.on('click', '.delete_content_btn', function (e) {
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
                    if (data.contend_id) {
                            $('#content_' + data.contend_id).parent('.content-spisok-photo').slideUp('slow', function () {
                            $(this).remove();
                            loadingFlag = false;
                            jpreloader('hide');
                        });
                    } else {
                        loadingFlag = false;
                        jpreloader('hide');
                    }

                }
            });
        }

    });
});
/**
 * Удаление контента
 */
function Del(url){
    message ='Вы действительно хотите удалить?';

    x = confirm(message);
    if (x == true)
    {
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                jpreloader('show');
            },
            success: function (data) {

                    loadingFlag = false;
                    jpreloader('hide');
             window.location.href="/core/index";

            }
        });
    }
    else {
      return false;
    }

}