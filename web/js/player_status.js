
/*
 * Перемсещение игрока из запасного в основной состав
 */
function MakePlayerUp(id, game_id) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    $.ajax({
        url: '/tournament/player-up',
        type: 'POST',
        dataType: 'json',
        cache: false,
        data: {
            _csrf: csrf_token,
            id: id,
            game_id: game_id
        },
        success: function () {
            //отрисовывается все
            getTeamView(game_id);
        }
    });
}
/*
 * Перемсещение игрока из запасного в запас состав
 */
function MakePlayerDown(id, game_id) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    $.ajax({
        url: '/tournament/player-down',
        type: 'POST',
        dataType: 'json',
        cache: false,
        data: {
            _csrf: csrf_token,
            id: id,
            game_id: game_id
        },
        success: function () {
            //отрисовывается все
              getTeamView(game_id);
        }
    });
}

$(document).ready(function () {
    var game_id = $('#dota_game_id').val();

    //Внимание засераю сервер запросом!!!!!!!!!!!!!
    //Аяксом каждые 2 сек отправлять запрос на подсчет кол игроков со статусом 0
    setInterval(function () {
        getRealQuantityNew(game_id);
    }, 5000);

        // проверяет есть ли изменения и рефрешит страницу
    function getRealQuantityNew(game_id) {

        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/dota/get-game-change',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                _csrf: csrf_token,
                game_id: game_id
            },
            success: function (is_changed_new) {
                var is_changed = $('#game_is_changed').val();                             
                //если количество отличается от quantity , то аяксом рефрешить страницу
                if (is_changed != is_changed_new) {
                    getTeamView(game_id);
                }
            }
        });
    }   
});

//отрисовывается вcе
function getTeamView(game_id) {

    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/dota/get-team-view',
        type: 'POST',
        dataType: 'json',
        cache: false,
        data: {
            _csrf: csrf_token,
            game_id: game_id
        },
        success: function (data) {  
            $('#tar').html(data.up.data);
            $('#down').html(data.down.data);
            is_changed_new = data.is_changed;

            // изменяю статус что изменилась конфигурация команды
            $('#game_is_changed').val(is_changed_new);

        }
    });
}


