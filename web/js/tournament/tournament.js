var Tournament = {


    //  Запрос к членам свой команды на подтверждение участия в турнире
    askTeamForAccept: function (tour_id) {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/tournament/ask-team-for-accept',
            type: 'POST',
            dataType: 'json',
            data: {
                tour_id: tour_id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                open_dialog('system-dialog');
                $('#system-dialog .body-dialog p').html(data);
            }
        });
    },


       //  Запрос к членам свой команды на подтверждение участия в турнире
    DeleteTeam: function (tour_id,team_id) {
         var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/tournament/delete-team-from-tournament',
            type: 'POST',
            dataType: 'json',
            data: {
                tour_id: tour_id,
                team_id: team_id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('#team-'+team_id).remove();
                open_dialog('system-dialog');
                $('#system-dialog .body-dialog p').html(data.message);
            }
        });
    }
}

