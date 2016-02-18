/*
 * 
 kostya's functions:

 showChat(id),
 otvet() ,
 find_dialog(),
 sendMessageToCurrentUser(id, name),
 SendMessageToUser(),
 getFileNames(),
 getFileNames2(),
 deleteIcon(el),

 + document ready
 */

//показ чат-диалога с пользователем по его id
function showChat(id) {
    $('.spisok-block').removeClass('active');
    $("#" + id).addClass('active');
    console.log('showChat' + id);
    var chatwindow = $('.mail-review-block').show();
    var targetwindow = $('.mail-review-title');
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/message/showdialog',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            _csrf: csrf_token
        },
        cache: false,
        async: true,
        success: function (data) {
            targetwindow.html(data);
            //открытие картинок в нов окне
            $('.small-pics').click(function () {
                var src = this.src;
                var image = new Image();
                image.src = src;
                var width = image.width;
                var height = image.height;
                window.open(src, "Image", "width=" + width + ",height=" + height);
            });
            var speed = 300, originalHeight = 50, hoverHeight = 150, originalWidth = 50, hoverWidth = 150;
            $('.small-pics').mouseover(function () {
                //ПРи наведение курсора на картинку увеличить ее
                //targetwindow.scrollTop(60000000);
                $(this).parent().css("height", 180);
                $(this).css({"border": "1px solid red", "cursor": "pointer"});
                $(this).stop().animate({height: hoverHeight, width: hoverWidth}, speed);
            });
            $('.small-pics').mouseleave(function () {
                //targetwindow.scrollTop(60000000);
                $(this).css({"border": ""});
                //ПРи наведение курсора на картинку увеличить ее
                $(this).stop().animate({height: originalHeight, width: originalWidth}, speed);
            });
            $('.form-message-answer').append('<input type="hidden" id="" name="id" value="' + id + '">');
            var a = $("#" + id).children().find('.temp-message').remove();
            //если есть письмо от систем то убрать див с кнопкой ответить
            var name = $("#" + id).children().find('span.name').text();
            if (name === 'system') {
                $('.mail-message-form').hide();
            } else {
                $('.mail-message-form').show();
            }
        }
    });
}

//отправляю сообщение на добавление  + фотки с двойным (вложенным аяксом)
function otvet(e) {
    $('.keyEnter').prop("disabled", true);

    var id_active = $('div.active').attr('id');
    var textarea = $('#message').val();
    $('#message').val('');
    var files = $('.Img');
    // если поле сообщения пустое
    if (textarea == '' && files.length == 0) {
        $('#message').css('border', '1px solid red');
        $('#message').focus(function () {
            $('#message').css('border', '0px solid red');
        });
        // Звук отправки сообщения
        var beepTwo = $("#beep-three")[0];
        beepTwo.play();
        $('.keyEnter').prop("disabled", false);
        return;

    }

//если есть фотки
    if (files.length > 0) {

        var csrf_token = $("meta[name=csrf-token]").attr("content");
        var id = $('.receiver_user').val();
        $('#resiver_id').val(id);
        var form = document.forms.form_message_answer;
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/message/otvet");
        xhr.send(formData);

        xhr.onreadystatechange = function (oEvent) {
            if (xhr.status == 200 && xhr.readyState == 2) {
                //обновляю левый блок через аякс
                refreshLeft(id);
                refreshRight(id);
                $('#' + id_active).addClass('active');
                // Звук отправки сообщения
                var beepTwo = $("#beep-two")[0];
                beepTwo.play();
                // обновляю форму ответа - чищу
                $('#message').val('');
                $('.img-preview-small').html('');
                $('.spisok-block').removeClass('active');
                $("#" + id).addClass('active');
                $('#message').focus();
            }
        };
    } else {
        // отправка только сообщения без фоток
        // alert('no fotos');        
        var id = $('div.active').attr('id');

        $.ajax({
            url: '/message/send-only-message',
            type: 'POST',
            dataType: 'json',
            cache: false,
            data: {
                _csrf: csrf_token,
                message: textarea,
                id: id
            },
            success: function (data) {
                // Звук отправки сообщения
                var beepTwo = $("#beep-two")[0];
                beepTwo.play();

                refreshRight(id);
                refreshLeft(id);

                $('#message').val('');
            }
        });
    }
    $('.keyEnter').prop("disabled", false);
}
function find_dialog() {
    formData = null;
    console.log('find_dialog');
    var pattern = $('#i_looking_for').val();
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/message/lookfor',
        type: 'POST',
        dataType: 'json',
        data: {
            pattern: pattern,
            _csrf: csrf_token
        },
        cache: false,
        complete: function (xhr) {
        },
        success: function (data) {
            $('.mail-spisok-form-block-bg ').html(data);
        },
        error: function () {
            window.location.reload();
        }
    });
}
//подготавливаю отправку сообщения 
function sendMessageToCurrentUser(id, name) {
    console.log('sendMessageToCurrentUser' + id + name);
    open_dialog('kabinet_mail_napisat');
    $('span.target').html(' ' + name);
    $('.user-name-name').val(name);
    $('#form_review').focus();
}

// отправку сообщения конкретному пользователю 
function SendMessageToUser() {
    console.log('SendMessageToUser');
    var name = $('span.targetuser').text();
    if (name == '') {
        var name = $('span.target').text();
    }
    var message = $('#form_review').val();
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/message/sendmessage',
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            message: message,
            _csrf: csrf_token
        },
        cache: false,
        complete: function (xhr) {
            window.location.reload();
        }
    });
}
//Прикреплять имя файла для отправки
function getFileNames() {
    var files = document.getElementById('file').files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;
            var src = e.target.result;
            $('.img-preview').append('<img class="Img" style="margin-left:10px" src="' + src + '" height="50" alt="Image preview...">');
        };
        reader.readAsDataURL(file);
    }
}
function getFileNames2() {
    console.log('get');
    var files = document.getElementById('file-otvet').files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;
            var src = e.target.result;
            $('.img-preview-small').append('<img class="Img" style="margin-left:5px" src="' + src + '" height="30" alt="Image preview...">');
            //$('.img-preview').append("<div class='file-name' id='d1'><a  href='javascript: void(0);' class='title'><img class='Img' style='margin-left:10px;float:left' src='"+ src +"' height='50' alt='Image preview...'></a><a href='#' class='button-close-small' onclick='deleteIcon(this)'><i class='icon-close-small'></i></a></div>");
        };
        reader.readAsDataURL(file);
    }
}

// удаление прикрепленной картинки
function deleteIcon(el) {
    console.log('delete Icon');
    var elem = $(el).parent('div');
    $(elem).remove();
}

//////////////////////////////////////////////////////////////////////////////
$(document).ready(function () {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        //удалить повторяющиеся елементы
        var supervise = {};
        $('span.name').each(function () {
            var txt = $(this).text();
            if (supervise[txt])
                $(this).parent().parent().parent().parent().remove();
            else
                supervise[txt] = true;
        });
        //Нажатие клавиши ентер
        $('body').on('keypress', '#form_message_answer', function (e) {
            if (e.keyCode == 13) {
                console.log('enter');
                otvet();
            }
        });
        // убираю лишние буквы в выпадающем списке при написании письма
        $('div.select-menu-button').click(function () {
            $('div.m-block-main').each(function () {
                console.log($(this).next());
                if ($(this).next().attr('class') == 'm-block-main') {
                    $(this).hide();
                }
            })
        });
        //если есть сообщения выводить звук


    }
);

function refreshLeft(id) {
    //обновляю левый блок через аякс
    console.log('refreshLeft');
    $.ajax({
        url: '/message/leftblock',
        type: 'POST',
        dataType: 'json',
        cache: false,
        success: function (data) {
            //console.log(data)
            //обновить список диалогов                   
            $('.mail-spisok-form-block-bg ').html(data);
            $('#' + id).addClass('active');
            console.log('заменил лев блок')
            var supervise = {};
            $('span.name').each(function () {
                var txt = $(this).text();
                if (supervise[txt])
                    $(this).parent().parent().parent().parent().remove();
                else
                    supervise[txt] = true;
            });
        }
    });
}
//обновляю прав  блок через аякс
function refreshRight(id) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    console.log('refreshRight id:' + id);
    $.ajax({
        url: '/message/showdialog-lastmessage',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            $('.mail-review-title').html(data);

        }
    });
}

/**
 * Обновляет сообщения
 */
function loadMessages() {

    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;

        var csrf_token = $("meta[name=csrf-token]").attr("content");

        $.ajax({
            url: '/message/checkout',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token
            },
            cache: false,
            async: true,
            success: function (data) {
                //console.log(data);
                if (data.quantityMessage > 0) {
                    $('.message-items').remove();
                    $('.m-common').prepend('<div class=\"message-items\">' + data.quantityMessage + '</div>');
                    //если в шапке есть письма и открыт диалог чата, то обновить чат
                    var result = $('.message-items').text();
                    //если писем > 0 то аяксом дернуть гетлист
                    var id = $('div.active').attr('id');
                    if ($('.mail-review-block').is(':visible')) {
                        refreshRight(id);
                        refreshLeft(id);
                    }
                } else {
                    var id = $('div.active').attr('id');
                    //refreshLeft(id);
                    $('.message-items').remove();
                    //console.log('no messages');
                }
                //если есть системные сообщения
                if (data.quantityMessageSystem > 0) {

                    //Полезть в бд и сделать сообщение просмотренным

                    //alert(data.is_sounded );
                    if (data.is_sounded == 1) {
                        var beepTwo = $("#beep-system")[0];
                        beepTwo.play();
                        MakeSystemMessagesSounded();
                    }

                    $('.m-system').prepend('<div class=\"message-items two\">' + data.quantityMessageSystem + '</div>');
                } else {
                    $('.two').remove();
                }
                loadingFlag = false;
            }
        });
    }
}
// вывод списка системных уведомлений в шапке сайта 
function ShowSystemAlert(id) {

    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/message/get-system-message',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token,
                id: id
            },
            cache: false,
            complete: function () {
                loadingFlag = false;
            },
            success: function (data) {
                $('#message_alert .dialog-info').html(data);
                $('#message_alert').addClass('active');
                $('#message_alert').after('<div class="on_click_hide"  style="position:fixed;  width:100%;height:100%;background:none;top:0;left:0;" onclick=\'$(".on_click_hide").remove();$(".btn_active").removeClass("active");\'></div>');

            }
        });
    }
}
function deleteSystemMessage(el, id) {
    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/message/delete-by-id',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token,
                id: id
            },
            cache: false,
            async: true,
            complete: function () {
                el.parent('.dialog-notice-bl').remove();
                loadingFlag = false;
                //alert(data.result);
            },

            success: function (data) {
                el.parents('.dialog-notice-bl').remove();
                loadingFlag = false;
                //alert(data.result);
            }

        });
    }
}

function MakeSystemMessagesSounded() {
    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/message/make-system-messages-sounded',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token
            },
            cache: false,
            complete: function () {
                loadingFlag = false;
            }
        });
    }

}