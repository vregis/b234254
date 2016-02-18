var arrDeletedPlayers = Array();
var Team_id;
function OpenEditor()
{
    $('#structure_commands_name').addClass('active');
    $('#structure_commands_tbl').addClass('active');
    $('.editor-button-gamer-status').show();
    $('.default-button-gamer-status').hide();
}
function CloseEditor()
{
    $('#structure_commands_name').removeClass('active');
    $('#structure_commands_tbl').removeClass('active');
    $('.editor-button-gamer-status').hide();
    $('.default-button-gamer-status').show();
}
function SendEditForm() {
    //alert(arrDeletedPlayers + ' | ' + Team_id);
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var fd = new FormData(document.getElementById("form-team-editor-new"));
    fd.clicks =
            $.ajax({
                url: '/team/edit-team',
                type: "POST",
                data: fd,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    //jpreloader('hide');
                    //$('.mce-combobox.mce-last.mce-abs-layout-item input').val(data);
                    //alert(data);
                    //window.location.reload();
                },
                complete: function(){
                     //window.location.reload();
                }


            });

}
function deletePlayerFromTeam(el, user_id, team_id) {

    var line = el.parent().parent().parent();
    line.animate({  
        opacity: 0
    }, 500, function () {
       line.hide();
    });
    // дОБАВЛЯТЬ ПАРАМЕТР для удаления
    $('#form-team-editor-new').prepend('  <input type="hidden" name="deleted[]" value="'+ user_id +'">');
}

function deletePlayerFromTeamButtonSidebar( user_id, team_id) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/team/remove-member-from-team-button-from-sidebar',
        type: "POST",
        dataType: 'json',
        data: {
            user_id: user_id,
            team_id : team_id,
            _csrf: csrf_token
        },
        success: function (data) {
       //alert(data.error);
            //window.location.reload();
        }
      });

}


