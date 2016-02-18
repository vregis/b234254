/*
 =============================================================================
 jQuery плагин для стилизации файл инпутов
 =============================================================================
 Автор: 			Олег Савватеев
 Версия:			1.0.0
 Описание:		http://savvateev.org/blog/38
 Демо:			http://savvateev.org/demo/jInputFile/index.html
 Лицензия:		MIT

 ==============================================================================
 Плагин сделан на основе замечательной статьи:
 http://vremenno.net/design/file-inputs-styling/
 */


(function ($) {
    $.fn.jInputFile = function (options) {

        return this.each(function () {
            var title = $(this).attr('data-title');
            if (!title) {
                title = "Обзор";
            }
            $(this).val('');
            $(this).wrap('<div class="jInputFile-block"></div>');
            $(this).parent().css('height', $(this).height());
            $(this).after('<div class="jInputFile-fakeButton">' + title + '</div><div class="jInputFile-blocker"></div><div class="jInputFile-activeBrowseButton jInputFile-fakeButton">' + title + '</div><div class="jInputFile-fileName"></div>');
            $(this).addClass('jInputFile-customFile');

            $(this).hover(
                function () {
                    $(this).parent().children('.jInputFile-activeBrowseButton').css('display', 'block');
                },
                function () {
                    $(this).parent().children('.jInputFile-activeBrowseButton').css('display', 'none');
                }
            );

            /*$(this).change(function () {
             console.log(this.files[0]);
             var file = $(this).val();

             //Находим название файла и его расширение
             var reWin = /.*\\(.*)/;
             var fileName = file.replace(reWin, '$1');
             var reUnix = /.*\/(.*)/;
             fileName = fileName.replace(reUnix, '$1');
             var regExExt = /.*\.(.*)/;
             var ext = fileName.replace(regExExt, '$1');
             var _csrf = $("#profile-form input[name=_csrf]").val();
             });*/
        });
    }
})(jQuery);