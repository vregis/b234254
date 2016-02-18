$(document).ready(function () {

    // глобальные переменные
    var body = $('body');

    /**
     * Для действия требуется авторизация
     */
    body.on('click', '.onlyUser', function (e) {
        e.preventDefault();
        system_dialog($('#onlyUserMessage').html());
    });
});

/**
 * Открывает диалог с сообщением об ошибке/успехе
 *
 * @param message
 */
function system_dialog(message) {
    $('#system-dialog .body-dialog p').html(message);
    open_dialog('system-dialog');
}