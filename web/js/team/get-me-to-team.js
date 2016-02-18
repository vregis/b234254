function getMeToTeam() {
    var team_id = $('#request_team_id').val();
    //alert(team_id);
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/team/request-to-team',
        type: 'POST',
        dataType: 'json',
        data: {

            team_id: team_id,
            _csrf: csrf_token
        },
        cache: false,
        async: false,
        success: function (data) {
         //alert('ok');
        }
    });

}