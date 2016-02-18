function publicThis(id,modName) {

    csrf_token = $("meta[name=csrf-token]").attr("content"),
            loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            type: 'GET',
            url: '/'+ modName +'/admin-content-publish/' + id,
            dataType: 'json',
            cache: false,
            success: function (data) {
                 open_dialog('system-dialog');
                 $('.public-button').remove();
                $('.body-dialog p').html(data.message);
                $('.body-dialog p').append(data.success_message);
                window.location.reload();
            }
        });
    }
}
function noPublicThis(id) {
    csrf_token = $("meta[name=csrf-token]").attr("content"),
            loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            type: 'GET',
            url: '/admin-content-cancel',
            dataType: 'json',
            cache: false,
            success: function (data) {
                 open_dialog('system-dialog');
                //alert(data.success_message);
                $('.body-dialog p').html(data.success_message);
                $('.body-dialog p').apppend(data.message);
            }
        });
    }
}
// редактировать контент
function updateThis(id) {

    csrf_token = $("meta[name=csrf-token]").attr("content"),
            loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            type: 'GET',
            url: '/user_media/content-update/' + id,
            dataType: 'json',
            cache: false,
            success: function (data) {
              
            }
        });
    }
}

function beforSendMessageCancel(cont_id) {
    
    var id = $('#mail_message_sent').children().val();
    open_dialog("okno_ask_questions");
    $('#form_ask_questions .user_terget').val(id);
    $('#form_ask_questions .content_terget').val(cont_id);
}
function beforSendMessageByModerator(user_id,cont_id) {
  
    var id = $('#mail_message_sent').children().val();
    open_dialog("okno_ask_questions");
    $('#form_ask_questions .user_terget').val(user_id);
    $('#form_ask_questions .content_terget').val(cont_id);
}

//
function AjactContent(moduleName){

    var message = $('#form_ask_questions_review').val();
    var id = $('#form_ask_questions .content_terget').val();

    csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            type: 'POST',
            url: '/'+moduleName + '/admin-content-cancel',
            dataType: 'json',
            data: {
                _csrf: csrf_token,
                id: id,
                message: message
            },
            cache: false,
            beforeSend: function () {
                jpreloader('show');
            },
            success: function (data) {
                
                if (data.content_id) {
                    if (data.count_contents == 0) {
                        window.location.reload();
                    }
                    system_dialog(data.success_message);
                    jpreloader('hide');
                    window.location.reload();
                }else {
                    if (data.message) {
                        system_dialog(data.message);
                    }
                    jpreloader('hide');
                }
            }
        });
    close_dialog('okno_ask_questions');
}


// жалоба на контент
function AjactContentClaim(moduleName){

    var message = $('#form_ask_questions_review_claim').val();
    var id = $('#content_id').val();
    csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            type: 'POST',
            url: '/'+moduleName + '/admin-content-claim',
            dataType: 'json',
            data: {
                _csrf: csrf_token,
                id: id,
                message: message
            },
            cache: false,
            beforeSend: function () {
                jpreloader('show');
            },
            success: function (data) {

                if (data.content_id) {
                    if (data.count_contents == 0) {
                        window.location.reload();
                    }
                    system_dialog(data.success_message);
                    jpreloader('hide');
                    window.location.reload();
                }else {
                    if (data.message) {
                        system_dialog(data.message);
                    }
                    jpreloader('hide');
                }
            }
        });
    close_dialog('okno_ask_questions');
}