// Отправить коментарий
function SendFormComment(modname) {
    //alert(Modname);
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var cont_id = $('#con_id').val();
    var message = $('#add_comments').val();
    if (message.length == 0) {
        return false;
    }
    //alert(cont_id + ' | ' + message);
    $.ajax({
        type: 'POST',
        url: '/'+ modname +'/content-commentadd',
        dataType: 'json',
        data: {
            cont_id: cont_id,
            message: message,
            _csrf: csrf_token
        },
        cache: false,
        asinc: false,
        success: function (data) {
            RefreshQuantityComments(cont_id,modname);
            //alert(data.status);
            add_comment_new('hide');
            $('.target').prepend(data.html);
            $('.html').animate({opacity: 1}, 3000);
        }
    });
}
// Отправить ответ на коментарий 
function SendFormOtvet(modname) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var cont_id = $('#otvet_cont_id').val();
    var parent_user_id = $('#otvet_user_id').val();
    var message = $('#otvet_add_comments').val();    
    if (message.length == 0) {
        return false;
    }
    var from = $('#from').val();
    var identf = $('#identf').val();
    //alert ( cont_id + ' | ' + message + ' | ' + user_id + ' | ' + from + ' | '+ identf);
    $.ajax({
        type: 'POST',
        url: '/'+ modname +'/content-otvetadd',
        dataType: 'json',
        data: {
            cont_id: cont_id,
            message: message,
            user_id: parent_user_id,
            from: from,
            identf: identf,
            _csrf: csrf_token
        },
        cache: false,
        asinc: false,
        success: function (data) {
            RefreshQuantityComments(cont_id, modname);
            if (data.html) {
                $('#' + identf).after('<div class="hide_befor_show_'+parent_user_id+'">'+data.html+'</div>');
                $('#editor').remove();
            }
            $('.html').animate({opacity: 1}, 3000);
        }
    });
}

// Открыть форму отправки коментария
function openSendform(el, cont_id, user_id, from, identf,modName) {
    var add_main_blog = $('.add-comment .form_comments_block').css('display');
    if (add_main_blog == 'block') {
        $('.comments-block.content-comment-bl.add-comment .form_add_comments').css('border', '1px solid red');
        return false;
    }
    
    $('.comments-block.content-comment-bl.remove_blog').remove();
    var okno = '<div id="editor" class="comments-block content-comment-bl remove_blog" >'
            + '<input id="otvet_cont_id" type="hidden" value="' + cont_id + '">'
            + '<input id="otvet_user_id" type="hidden" value="' + user_id + '">'
            + '<input id="from" type="hidden" value="' + from + '">'
            + '<input id="identf" type="hidden" value="' + identf + '">'
            + '<input id="modName" type="hidden" value="' + modName + '">'
            + '<div class="form_comments_block" style="opacity: 1; display: block;"><form id="form_add_comments" class="form_add_comments">'
            + '<div class="head-form-dialog"><div class="title">добавить ответ</div>'
            + '<p>Разрешено комментировать только на русском языке. Запрещено использовать мат, транслит. </p></div>'
            + '<div class="input-lines form-textarea" style="width: 620px;"><label for="form_add_comments_small">ТЕКСТ</label>'
            + '<textarea id="otvet_add_comments" name="message"></textarea></div><div class="form-submit" style="width: 620px;margin-top: 20px">'
            + '<a href="javascript:void(0);" class="form-submit-close" onclick="closeSendform($(this))">Отмена</a>'
            + '<button href="javascript:void(0);" type="button" class="button-green" onclick="SendFormOtvet(\''+modName+'\')">добавить ответ</button>'
            + '</div></form></div><div class="gamer_comments question-detail-comments"></div></div>';
    // Если нет дубликатов модальных окон
    if (from == 2) {
        $('#' + identf).after(okno);
    } else {
        $('#' + identf).after(okno);
    }

}

// Закрыть форму отправки коментария
function closeSendform(el) {
    el.parents('.comments-block').remove();
}

// Проголосовать за коментарии +
function addliketoContentComment(el) {
    //alert('ok');
    $.ajax({
        type: 'GET',
        url: el.attr('data-url'),
        dataType: 'json',
        cache: false,
        success: function (data) {
            el.children('.like').text(data.like);
            el.children('.dislike').text(data.dislike);
            if (data.message) {
                open_dialog('system-dialog');
                $('.body-dialog p').html(data.message);
                //alert(data.message);
            }
        }
    });
}
// Вывести все коментарии
function showAllComment(id,name) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    // alert(id);
    $.ajax({
        type: 'GET',
        url: '/'+name+'/content-show-all-comment',
        dataType: 'json',
        data: {
            id: id,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            //alert(data.status);
            $('.target').html(data.html);
        }
    });

}
// Вывести все ответы
function showAllOtvet(id, model_name) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    //alert(id);
    $.ajax({
        type: 'GET',
        url: '/'+model_name+'/content-show-all-otvet',
        dataType: 'json',
        data: {
            id: id,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            //alert(data.html);
            $('.comment-main-content-answer-bl').remove();
            $('.target-otvet-best').after(data.html);
            $('.target-otvet-best').remove();
        }
    });

}
// Вывести все ответы для обычных коментариев
/*
function showAllOtvetCommon(el, id, identf) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    //alert(id);
    $.ajax({
        type: 'GET',
        url: '/user_media/content-show-all-otvet',
        dataType: 'json',
        data: {
            id: id,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            //alert(data.html);
            $('#' + identf).prev().remove();
            $('#' + identf).prev().remove();
            $('#' + identf).prev().remove();
            $('#' + identf).prev().remove();
            $('#' + identf).html(data.html);
            el.parents('.bnt-long-grey').remove();
        }
    });
}
*/
//Обновление количества коментариев
function RefreshQuantityComments(cont_id,modname) {
    //alert(cont_id);
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        type: 'POST',
        url: '/'+modname+'/content-get-quantity-message',
        dataType: 'json',
        data: {
            cont_id: cont_id,
            _csrf: csrf_token
        },
        cache: false,
        asinc: false,
        success: function (data) {
            $('.quant-target').html('(' + data.quantity + ')');
        }
    });
}

function ShowOtvetById(el, id) {   
    if(el.hasClass('active')){
        $('.hide_befor_show_' + id).animate({
            opacity: 0,
        }, 800, function(){
            $('.hide_befor_show_' + id).hide();
            el.removeClass('active');    
        });
        
    }else{
        $('.hide_befor_show_' + id).show();
        $('.hide_befor_show_' + id).animate({
            opacity: 1,
        }, 800, function(){
         el.addClass('active')
        });
        
    }   
}