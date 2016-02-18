$(document).ready(function(){
    $('.send-file').change(function(){

        SendForm();
    });
});

// Загрузка аватарки для команды
function SendForm() {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var fd = new FormData(document.getElementById("form-send-file"));
    fd.clicks =
            $.ajax({
                url: '/team/upload-avatar',
                type: "POST",
                data: fd,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
//                   beforeSend: function (xhr) {
//                        jpreloader('show');
//            },
                success: function (data) {
                    if(data.error){
                        open_dialog('system-dialog');
                        $('#system-dialog  .body-dialog p').html(data.error);
                      }
                    //jpreloader('hide');
                    if(data.preview ){
               $('.command-img-bl').html('<img src=" ' + data.preview + ' " width="200px" height="200px" alt="logo-team">' );
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
