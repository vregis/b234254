function AddMemberToTeam(user_id, team_id) {
    //jpreloader('show');
    //alert(user_id + ' | ' + team_id);
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/team/add-member-to-team',
        type: 'POST',
        dataType: 'json',
        data: {
            user_id: user_id,
            team_id: team_id,
            _csrf: csrf_token
        },
        cache: false,
        async: false,
        success: function (data) {
             if(data.error){
             open_dialog('system-dialog');
                $('#system-dialog .body-dialog p').html(data.error);
            }else{
                $('#' + user_id).remove();
                if (!$('#okno_make_a_bet .make_bet_player_nav .make_bet_player').length) {
                    close_dialog('okno_make_a_bet');
                    window.location.reload();
                }
            }
        }
    });
}
/* Preloader */
function jpreloader(item) {
    if (item == 'show') {
        $(document.body).append('<div class="back_background jpreloader" style="z-index: 90000;"></div>');
    } else {
        $('.jpreloader').remove();
    }
}


function RemoveMemberFromResponse(user_id, team_id) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/team/remove-user-from-team-request',
        type: 'POST',
        dataType: 'json',
        data: {
            user_id: user_id,
            team_id: team_id,
            _csrf: csrf_token
        },
        cache: false,
        async: false,
        success: function (data) {
            window.location.reload();
        }
    });
}