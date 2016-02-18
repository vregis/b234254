function SendForm(game_id) {

    var winner = $('#team_side').val();
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    if (winner == 0) return false;

    $.ajax({
        url: '/tournament/change-winner',
        method: 'POST',
        dataType: 'json',
        data: {
            game_id: game_id,
            winner: winner,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            window.location.reload();
        }
    });
}