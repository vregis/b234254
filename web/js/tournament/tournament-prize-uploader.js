$(document).ready(function(){
    $('.send-file-prize').change(function(){
        SendFormPrize();
    });
});

function SendFormPrize() {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var fd = new FormData(document.getElementById("form-send-file-prize"));
    fd.append("button_id", $('#ava').val());
var btn_num = $('#ava').val();
   // alert(btn_num);
    fd.clicks =
            $.ajax({
                url: '/tournament/upload-prize',
                type: "POST",
                data: fd,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function (data) {
                    if(data.error ){
                        open_dialog('system-dialog');
                        $('#system-dialog .body-dialog p').html(data.error);
                    }

                    if(data.preview ){
               $('.prize-image').html('<img src=" ' + data.preview + ' " width="200px" height="200px" alt="logo-team">' );
               $('.nagrada_'+$('#ava').val()).html('<img src=" ' + data.preview + ' " width="50px" height="50px" alt="logo-team">' );
               $('#tournament-prize_image_'+$('#ava').val()).val(data.avatar);
               $('.del_'+ btn_num ).css('display','block');

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
function deleteTeam(){
  if (confirm("Вы подтверждаете удаление команды?")) {
        return true;
       
    } else {
       event.preventDefault();
        return false;
    }

}

function deleteTournamentImagePrize($num_img){
    //alert($num_img+ ' | ' + tour_id);
    $('#tournament-prize_image_'+$num_img).val('');
    $('.nagrada_'+$num_img).html('AVA');
    $('.del_'+$num_img).hide();
}
