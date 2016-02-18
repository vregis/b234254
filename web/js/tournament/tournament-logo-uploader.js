$(document).ready(function(){
    $('.send-file').change(function(){

        SendForm();
    });
});

function SendForm() {
    //alert(arrDeletedPlayers + ' | ' + Team_id);
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var fd = new FormData(document.getElementById("form-send-file"));
    //alert(fd);
    fd.clicks =
            $.ajax({
                url: '/tournament/upload-avatar',
                type: "POST",
                data: fd,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
//                   beforeSend: function (xhr) {
//                        jpreloader('show');
//            },
                success: function (data) {
                    //jpreloader('hide');
                    if(data.preview ){
               $('.ava-image').html('<img src=" ' + data.preview + ' " width="200px" height="200px" alt="logo-team">' );
                    }
               //alert(data.avatar);
               $('#team-file').val(data.avatar);
               $('.temp').val(data.avatar);
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
function deleteTeam(){
  if (confirm("Вы подтверждаете удаление команды?")) {
        return true;
       
    } else {
       event.preventDefault();
        return false;
    }

}
