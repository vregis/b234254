var $ = jQuery.noConflict();

/* Возвращает  высоту и ширину видимой области страницы */
function screenHeight() {
    return $.browser.opera ? window.innerHeight : $(window).height();
}
function screenWidth() {
    return $.browser.opera ? window.innerWidth : $(window).width();
}
/* Возвращает  высоту и ширину видимой области страницы END */
/* Для открытия диалогового окна */
function open_dialog(id) {


    /**
     * При нажатии esc - закрываем окно
     */
    $(document).keyup(function (e) {
        // esc
        if (e.keyCode == 27) {
            close_dialog(id);
        }
    });

    /* центрует окно по середине */
    var margin_top = 0;
    var hight = parseInt($('.dialog-box#' + id).height());
    var win_hide = parseInt(screenHeight());
    if (hight > win_hide) {
        margin_top = pageYOffset;
    } else {
        margin_top = (win_hide - hight) / 2;
        margin_top = pageYOffset + margin_top -335;
    }

    if (hight < win_hide) {
        $("body").addClass("modal-open");
    }


    $('.dialog-box#' + id).css('margin-top', margin_top);
    /* центрует окно по середине end */

    var z_index = parseInt($('.dialog-box#' + id).attr('data-index'));
    $('.dialog-box#' + id).addClass('open');
    $('.dialog-box#' + id).css('z-index', z_index + 1);
    $('.dialog-box#' + id).after('<div class="back_background" style="z-index: ' + z_index + ';"></div>');
    $('.dialog-box#' + id + ' .dialog-close').attr('onclick', 'close_dialog("' + id + '");');
    $('.dialog-box#' + id + ' + .back_background').attr('onclick', 'close_dialog("' + id + '");');

    $('#form_review').focus();
}
function close_dialog(id) {
    $("body").removeClass("modal-open");

    $('.dialog-box#' + id + ' .dialog-close').attr('onclick', '');
    $('.dialog-box#' + id).css('z-index', 0);
    $('.dialog-box#' + id).removeClass('open');
    $('.dialog-box#' + id + ' + .back_background').remove();
}
/* Для открытия диалогового окна End */
/* HEADER Войти */
function open_enter_btn() {
    $(".enter-btn-open").animate({
        top: "+=285"
    }, 'slow', function () {
        $('.enter-btn-open').after('<div class="enter-btn-background" onclick="close_enter_btn();"></div>');
    });
}

function close_enter_btn() {
    $(".enter-btn-open").animate({
        top: "-=285"
    }, 'slow', function () {
        $('.enter-btn-open + .enter-btn-background').remove();
    });
}

/* HEADER Войти */

/* Показать скрыть список */
/* <a href="javascript:void(0);" class="" id="show_participato_spisok"  onclick="show_block_spisok('.game-participator .no_show',$(this),'Скрыть');">Показать всех</a>*/
function show_block_spisok(id, data, title) {
    var text = data.text();
    var button_id = data.attr('id');
    data.css('opacity', 0);
    $(id + '.no_show').css('display', 'inline-block');
    $(id + '.no_show').animate({
        opacity: 1
    }, 600, function () {
        $('#' + button_id).html(title);
        data.attr('onclick', 'hide_block_spisok(".game-participator .no_show",$(this),"' + text + '");');
        data.css('opacity', 1);
    });
}
function hide_block_spisok(id, data, title) {
    var text = data.text();
    var button_id = data.attr('id');
    data.css('opacity', 0);
    $(id + '.no_show').animate({
        opacity: 0
    }, 500, function () {
        $('#' + button_id).html(title);
        data.attr('onclick', 'show_block_spisok(".game-participator .no_show",$(this),"' + text + '");');
        $(id + '.no_show').css('display', 'none');
        data.css('opacity', 1);
    });
}
/* Показать скрыть список end */
/* Показать скрыть выпадающее меню с изображением */
function select_menu_img(item, title) {
    if (title == 'show') {
        $(item).addClass('active');
        $(item).after('<div class="back_background"></div>');
        $(item + ' + .back_background').attr('onclick', 'select_menu_img("' + item + '","hide");');
    } else {
        $(item).removeClass('active');
        $(item + ' + .back_background').remove();
    }
}
/* Показать скрыть выпадающее меню с изображением */

/* Выпадающий список с изображением для отправки письма */
$(document).ready(function () {
    $('.drop_menu_down .select-menu-button').click(function () {
        $(' + .select-menu-img', this).show();
        $(' + .select-menu-img', this).after('<div class="back_background"></div>');
        $(' + .select-menu-img + .back_background', this).click(function () {
            $('.select-menu-img').hide();
            $(this).remove();
        })
    })

    $('.drop_menu_down .m-block-title').click(function () {
        var data_id = $(this).attr('data-id');
        var data_value = $(this).attr('data-value');
        var data_img = $(this).attr('data-img');
        $('#' + data_id + ' .m-block-title').removeClass('active')
        $(this).addClass('active');
        $('#' + data_id + ' .select-menu-button span').html(data_value);
        $('#' + data_id + ' .select-menu-button .mail-ava-img img').attr('src', data_img);
        $('#' + data_id + ' .select-menu-button input').val(data_value);
        $('.select-menu-img').hide();
        $('#' + data_id + ' .back_background').remove();
    })
})
/* Выпадающий список с изображением для отправки письма END */



/* Показать скрыть выпадающее меню с изображением END */
$(document).ready(function () {



    /* Select */
    $('select:not(.not-selectize)').selectize();
    /* Select end */
    /* checkbox */
    $('.checkbox').prettyCheckboxes({checkboxWidth: 20, checkboxHeight: 20});
    $('.radio').prettyCheckboxes({checkboxWidth: 20, checkboxHeight: 20, className: 'new-filter-radio'});
    /* checkbox end */
    /* datepicker */
    $(".form-datepicker").datepicker();
    $(".form-datepicker").datepicker("option", "dateFormat", "dd.mm.yy");
    /* datepicker end */
    /* tabs */
    // $(".content-tabs").tabs();
    $("#guest_book").tabs();
    /* tabs end*/
    /* file */
    $('input:file').jInputFile();

    /* file end */
    /* spinner */
    $(".input-spinner-h").spinner({
        min: 1,
        max: 24,
        numberFormat: "C"
    });

    $(".input-spinner-m").spinner({
        min: 1,
        max: 60,
        numberFormat: "C"
    });
    /* spinner end */
});

/* Add Comment */
function add_comment_new(option) {
    $('.comments-block.content-comment-bl.remove_blog').remove();
    $('.comments-block.content-comment-bl.add-comment .form_add_comments').css('border','none');
    if (option == 'show') {
        $('.form_comments_block').show();
        $('.form_comments_block').animate({
            opacity: 1
        }, 1200, function () {
        });
    } else {
        $('.form_comments_block').animate({
            opacity: 0
        }, 500, function () {
            $('.form_comments_block').hide();
        });
    }
}
/* Add Comment END */

/* Answer Comment */
function answer_comment(data) {
    var id = data.attr('data-url');
    var data_item = data.attr('data-item');
    var form_width = parseInt($('.' + id + ' .comment_user table[data-item = "' + data_item + '"]').width());
    $('.comment_user form.form_add_comments').remove();
    if (!$('#form_add_comments_' + data_item).hasClass('form_add_comments')) {
        form_width = 610 - form_width;
        $('.' + id + ' .comment_user table[data-item = "' + data_item + '"]').after('<form id="form_add_comments_' + data_item + '" class="form_add_comments"  method="post" action="#" style="margin-left:-' + form_width + 'px;width:610px;"></form>');
        $('#form_add_comments_' + data_item)
            .append($('<div>', {class: 'head-form-dialog'})
                .append($('<div>', {class: 'title'})
                    .append('Добавить отзыв или предложение')
                )
                .append($('<p>', {})
                    .append('Разрешено комментировать только на русском языке. Запрещено использовать мат, транслит.')
                )
            )
            .append($('<div>', {class: 'input-lines form-textarea'})
                .append($('<label>', {for: 'form_add_comments' + data_item})
                    .append('ТЕКСТ')
                )
                .append($('<textarea>', {name: 'review', id: 'form_add_comments' + data_item}))
            )
            .append($('<div>', {class: 'form-submit'})
                .append($('<a>', {href: 'javascript:void(0);', class: 'form-submit-close', onclick: 'answer_comment_remove("form_add_comments_' + data_item + '")'})
                    .append('Отмена')
                )
                .append($('<button>', {type: 'submit', class: 'button-green'})
                    .append('добавить комментарий')
                )
            )
        $('#form_add_comments_' + data_item).validate({
            errorClass: 'error',
            success: '',
            errorElement: "span",
            rules: {
                review: {
                    required: true
                }
            },
            submitHandler: function (form) {
                form.submit();
            }
        })
    }
}

function answer_comment_remove(id) {
    $('#' + id).remove();
}
/* Answer Comment END */

/*
 data-url где    находятся no_show
 data-last_show  последний открытый элемент
 data-count_all  сколько всего элементов
 data-count_show сколько показывать
 *
 */
function catalog_show_item(data) {
    var count_show = 3; // сколько показывать
    var data_url = data.attr('data-url'); // где находятся no_show
    var last_show = parseInt(data.attr('data-last_show')); // последний открытый элемент  
    var count_all = parseInt(data.attr('data-count_all')); // всего элементов    
    count_show = data.attr('data-count_show'); // сколько показывать    
    if (count_show == 'all') {
        count_show = 1000;
    } else {
        count_show = parseInt(count_show);
    }
    if (count_all <= parseInt(count_show + last_show)) {
        count_show = count_show + last_show;
        data.hide();
    }
    for (var i = 0; i < count_show; i++) {
        var j = i + last_show + 1;
        $(data_url + '.no_show[data-item = "' + j + '"]').css('display:inline-block');
        $(data_url + '.no_show[data-item = "' + j + '"]').animate({opacity: 1}, 1500);
        $(data_url + '.no_show[data-item = "' + j + '"]').removeClass('no_show');
        data.attr('data-last_show', j);
    }
}
/* Финансы */
$(document).ready(function () {
    $('.financi-resources-spisok .title').click(function () {
        var data_id = $(this).attr('data-id');
        $('.financi-resources-spisok .title').removeClass('active');
        $(this).addClass('active');
        $('.open-input-means-spisok').removeClass('active');
        $('#' + data_id).addClass('active');
    })
})
/* Финансы END */

/*  mail answer */
function mail_answer_show(item) {
    if (item == 'show') {
        $('#message_head_block').hide();
        $('#form_message_answer').show();
        $('#form_message_answer').animate({opacity: 1}, 600, function () {
        });
    } else {
        $('#form_message_answer').animate({opacity: 0}, 600, function () {
            $('#form_message_answer').hide();
            $('#message_head_block').show();
        });
    }
}
/*  mail answer END */

/* Preloader */
function jpreloader(item) {
    if (item == 'show') {
        $(document.body).append('<div class="back_background jpreloader" style="z-index: 5000;"></div>');
    } else {
        $('.jpreloader').remove();
    }
}
/* Preloader END */

/* * * * * *  * * * * * * * * * * * * * * *  * * * * * * * * * * * * * */


/* Валидация форм */
$(document).ready(function () {

    /* Форма Кабинет финансы */
    $('#form-financi_history').validate({
        errorClass: 'error',
        success: '',
        errorElement: "span",
        rules: {
            from: {
                required: true
            },
            to: {
                required: true
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Кабинет финансы END */

    /* Форма Кабинет финансы */
    $('#input-means-webmoney').validate({
        errorClass: 'error',
        success: '',
        errorElement: "span",
        rules: {
            login: {required: true},
            nomer: {required: true},
            cvv2: {required: true},
            count: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Кабинет финансы END */

    /* Форма Кабинет финансы */
    $('#input-means-visa').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            login: {required: true},
            nomer: {required: true},
            cvv2: {required: true},
            count: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Кабинет финансы END */

    /* Форма Кабинет финансы */
    $('#form-financi_withdrawal').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            count: {required: true},
            iwant: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Кабинет финансы END */

    /* Форма Кабинет финансы */
    $('#form-financi_resources').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            nomer: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Кабинет финансы END */


    /* Форма Кабинет финансы */
    $('#form-search_group').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            search: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Кабинет финансы END */

    /* Форма Кабинет финансы */
    $('#form-search_friend').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            login: {required: false}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Кабинет финансы END */


    /* Форма Настроек акаунта */
    $('#form-my-options').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            name: {required: true},
            surname: {required: true},
            login: {required: true},
            data_d: {required: true},
            data_m: {required: true},
            data_y: {required: true},
            city: {required: true},
            tel: {required: true},
            review: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Настроек акаунта end */

    /* Форма Настроек акаунта */
    $('#form-my-options').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            name: {required: true},
            surname: {required: true},
            login: {required: true},
            data_d: {required: true},
            data_m: {required: true},
            data_y: {required: true},
            city: {required: true},
            tel: {required: true},
            review: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Настроек акаунта end */
    /* Форма Настроек акаунта email */
    $('#form-account-options-email').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Настроек акаунта email end */

    /* Форма Настроек акаунта pass */
    $('#form-account-options-pass').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            pass: {required: true},
            pass_new: {
                required: true,
                minlength: 5
            },
            pass_new2: {
                required: true,
                minlength: 5,
                equalTo: "#form-account-options_pass_new"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма Настроек акаунта pass end */

    /* Форма mil SEARCH */
    $('#mail-search-form').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            search: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма mil SEARCH end*/

    /* Форма mil SEARCH */
    $('#form_mail_napisat').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            user_name: {
                required: true,
                minlength: 2
            },
            review: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма mil SEARCH end*/

    /* Форма mil SEARCH */
    $('#form_discussion_search').validate({
        errorClass: 'error',
        success: '',
        errorElement: 'span',
        rules: {
            text: {required: true}
        },
        submitHandler: function (form) {
            form.submit();
        }
    })
    /* Форма mil SEARCH end*/
    /* сворачивает навигацию по странице начало @_pomosh.html */
    $('#help-nav-switcher').click(function () {
        var title = $(this).attr('data-title');
        var text = $(this).text();
        $(this).html(title);
        $(this).attr('data-title', text)
        if ($('#help-nav-switcher').hasClass('active')) {
            $('#help-nav-switcher').removeClass('active');
            $('#help-nav').hide();
        } else {
            $('#help-nav-switcher').addClass('active');
            $('#help-nav').show();
        }
    });
    /* сворачивает навигацию по странице конец @_pomosh.html */

    /* открывает вкладки с вопросами на странице faq начало @_pomosh.html */
    $('.faq-info-main-block').click(function () {
        if ($('.faq-info-main-block', this).hasClass('active')) {
            $('.explain').hide();
            $('.faq-info-main-block').removeClass('active');
        } else {
            $('.explain').hide();
            $('.faq-info-main-block').removeClass('active');
            $('.explain', this).show();
            $(this).addClass('active');
        }
    });
    /* открывает вкладки с вопросами на странице faq @_pomosh.html конец */
});
/* Валидация форм END */

/**
 * Закрывает все модальные окна
 */
function close_all_dialogs() {
    close_dialog('okno_forgot_password');
    close_dialog('okno_registration');
    close_dialog('okno_rega');
    close_dialog('kabinet_mail_napisat');
    $('#okno_login').css('top', 0);
}

/**
 * Удаляет контент из диалога, оставляет только полупрозрачный фон
 */
function clear_all_dialogs() {
    $('.dialog-box').html('');
}


/* проверка участников */
function vkusloviy(){
    if($('#vkuslovia_1').hasClass('checked') && $('#vkuslovia_2').hasClass('checked')){
        $('#vkuslovia_id').attr('href','/user/registration/vk?service=fb');
        $('#vkuslovia_id button').removeClass('default');
    }else{

        $('#vkuslovia_id').attr('href','javascript:void(0);');
        $('#vkuslovia_id button').addClass('default');
    }
}