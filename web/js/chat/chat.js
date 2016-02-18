var Chat = {
    id_button: "",
    count_top_scroll: 0, // для определения координаты позиции скрулла
    message_new_preloader: false, // для определения координаты позиции скрулла
    //Поиск по друзьям
    FindSomeUsersFromFriend: function (el) {
        $('#dialog_search_freands_list .serch-target').html('');
        var expresion = el.val();
        console.log('FindSomeUsersToFriend' + expresion);
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/search-friends',
            type: 'POST',
            dataType: 'json',
            data: {
                expresion: expresion,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                if (data && data.length > 0) {
                    $('#dialog_search_freands_list').addClass('found');
                    $('#dialog_search_freands_list .serch-target').html(data);
                    //активировать окно
                    $('#dialog_search_freands_list .dialog_box_show').click(function () {
                        var id_button = $(this);
                        var user_id = id_button.attr('data-userid');
                        dragable_all_destroy();
                        Chat.ButtonClick(id_button, user_id);
                    });
                } else {
                    $('#dialog_search_freands_list').removeClass('found');
                    $('#dialog_search_freands_list .serch-target').html('');
                }
            }
        });
    },
    //Поиск по всем пользователям
    FindSomeUsersAddContact: function (el) {
        $('#dialog_search_add_contact_list .serch-target').html('');
        var expresion = el.val();
        console.log('FindSomeUsersAddContact' + expresion);
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/search-users',
            type: 'POST',
            dataType: 'json',
            data: {
                expresion: expresion,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                if (data && data.length > 0) {
                    $('#dialog_search_freands_list').addClass('found');
                    $('#dialog_search_freands_list .serch-target').html(data);
                    //активировать окно
                    $('#dialog_search_freands_list .dialog_box_show').click(function () {
                        var id_button = $(this);
                        var user_id = id_button.attr('data-userid');
                        Chat.ButtonClick(id_button, user_id);
                    });
                } else {
                    $('#dialog_search_freands_list').removeClass('found');
                    $('#dialog_search_freands_list .serch-target').html('');
                }
            }
        });
    },
    //смена видимости пользователя
    ChangeVisible: function (el) {
        console.log('ChangeVisible');
        if (el.hasClass('active')) {
            var color = 1;
            el.removeClass('active');
        } else {
            var color = 0;
            el.addClass('active');
        }
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/change-color',
            type: 'POST',
            dataType: 'json',
            data: {
                color: color,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function () {
            }
        });
    },
    // Отрендеривает список друзей или последих с кем
    // data.freand = {user_id,status,user_name,favorit,img}
    // data.block_id - Куда рендерить во Все или Последние
    // data.refresh{true,false} - перезагружает данные
    GetRenderFreand: function (data) {
        if (data.refresh) {
            $(data.block_id).html('');
        }
        for (var key in data.freand) {
            var status = 'offline off';
            var user_id = data.freand[key].id;
            if (data.freand[key].status) {
                var status = 'online on';
            }
            var count_new_message = data.freand[key].count_new_message;
            var user_name = data.freand[key].user_name;
            var favorit = data.freand[key].favorit;
            var img = data.freand[key].img;

            // Есть ли такая кнопка. Если нет то добавлять
            if ($(data.block_id + ' .dialog_box_show[data-user = "' + user_id + '"]').attr('data-user')) {
                if (count_new_message > 0) {
                    $('.num-' + user_id).addClass('active');
                    $('.num-' + user_id).html(count_new_message);
                    $('.num-' + user_id).show();
                }
                if (favorit == 'active') {
                    $('.dialog_user_active_' + user_id + ' .dialog-box-icon.star').addClass('active');
                } else {
                    $('.dialog_user_active_' + user_id + ' .dialog-box-icon.star').removeClass('active');
                }
            } else {
                $(data.block_id)
                    .append($('<div>', {'class': 'dialog-box-user-list-item dialog_user_active_' + user_id})
                        .append($('<div>', {'class': 'dialog-box-main-avatar-block'})
                            .append($('<div>', {'class': 'num num-' + user_id})
                                .append($('<div>', {'class': 'num num-' + user_id}).append(count_new_message))
                        )
                            .append($('<img>', {'src': img, 'width': 30, 'height': 30}))
                            .append($('<div>', {'class': 'dialog-box-user-status'})
                                .append($('<div>', {'class': status}))
                        )
                    )
                        .append($('<div>', {'class': 'dialog-box-user-list-name'})
                            .append('<span>' + user_name + '</span>')
                    )
                        .append($('<div>', {'class': 'dialog-box-user-choosen-block'})
                            .append('<i class="dialog-box-icon star ' + favorit + '" onclick="Chat.star($(this)); "></i> ')
                    )
                        .append($('<div>', {
                            'class': 'dialog_box_show dialog-box-show posible-dublicate',
                            'data-userid': user_id,
                            'data-user': user_id
                        }))
                );

                if (count_new_message > 0) {
                    $('.num-' + user_id).addClass('active');
                    $('.num-' + user_id).html(count_new_message);
                    $('.num-' + user_id).show();
                }
                $(data.block_id + ' .dialog_box_show[data-user = "' + user_id + '"]').click(function () {
                    var id_button = $(this);
                    var user_id = id_button.attr('data-userid');
                    Chat.ButtonClick(id_button, user_id);
                });
            }
        }
    },
    // вывести последние диалоги
    GetLastDialogs: function (item) {
        //console.log('GetLastDialogs');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/get-last-dialog',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                if (data.freand) {
                    if (item == 'refresh') {
                        data.refresh = true;
                    }
                    data.block_id = '#dialog-box-contenttab-last';
                    Chat.GetRenderFreand(data);
                }
                if (data.status) {
                    $('#online').text(data.status);
                }
            }
        });

    },
    // Спрятать тех кто не онлайн
    OnlyOnline: function (el) {
        if (el.hasClass('active')) {
            $('div.off').parent().parent().parent().show();
            $('.dialog-box-onclick-activated').removeClass('active');
            Chat.closeAllWindows();
        } else {
            $('.dialog-box-onclick-activated').removeClass('active');
            $('.dialog_box_serch_show_bl').hide();
            $('#dialog_box_serch_show_group').hide();
            $(el).addClass('active');
            $('div.on').parent().parent().parent().show();
            $('div.off').parent().parent().parent().hide();
        }
    },
    // Сделать друга избранным
    star: function (el) {
        //console.log('star');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        if (el.hasClass('active')) {
            el.removeClass('active');
            var user_id = el.parent().next().attr('data-user');
            sendIdForMakeFriendBest(user_id, 'no');
        } else {
            el.addClass('active');
            var user_id = el.parent().next().attr('data-user');
            sendIdForMakeFriendBest(user_id, 'yes');
        }
        function sendIdForMakeFriendBest(id, val) {
            $.ajax({
                url: '/chat/make-friend-best',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    val: val,
                    _csrf: csrf_token
                },
                cache: false,
                async: false,
                complete: function (data) {
                    if (data.responseJSON.a == 'yes') {
                        $('.star-' + id).addClass('active')
                    } else {
                        $('.star-' + id).removeClass('active')
                    }
                }
            });
        }
    },
    // Вывести только избранных
    OnlyFavorite: function (el) {
        if (el.hasClass('active')) {
            $('.dialog-box-onclick-activated').removeClass('active');
            $('.star').parent().parent().show();
            $('.star').each(function () {
                if ($(this).hasClass('active')) {
                    //$(this).parent().parent().hide();
                }
            });
            Chat.closeAllWindows();
        } else {
            $('.dialog_box_serch_show_bl').hide();
            $('#dialog_box_serch_show_group').hide();
            $('.dialog-box-onclick-activated').removeClass('active');
            $(el).addClass('active');
            $('.star').parent().parent().show();
            $('.star').each(function () {
                if (!$(this).hasClass('active')) {
                    $(this).parent().parent().hide();
                }
            });
        }
    },
    // Вывести диалог с пользователем и аксом подставить в #dialog_main_chat
    getDialogWithUser: function (user_id, text) {


        $('#dialog_main_common_chat').removeClass('active');
        //console.log('getDialogWithUser id=' + user_id);
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        id_button = this.id_button;
        $.ajax({
            url: '/chat/get-dialog-with-user',
            type: 'POST',
            dataType: 'json',
            data: {
                id: user_id,
                _csrf: csrf_token
            },
            cache: false,
            async: true,
            success: function (data) {
                $('#dialog_groups_chat').removeClass('active');
                $('#dialog_main_chat').html(data);
                $('#dialog_main_chat .dialog-massage-history-block').scrollTop(6000000);
                $('#message-area').text(text);
                $('#message-area').focus();
                if (id_button) {
                    // Вычесление позиции  стрелочки
                    arrow_offset(id_button);
                }else{
                    arrow_hideoffset();
                }
                // Если пользователь проскрулил вверх
                $("#dialog_main_chat .dialog-massage-history-block").scroll(function (item) {
                    if ($(this).scrollTop() < 1) {
                        Chat.count_top_scroll = $(this).scrollTop();
                        Scroll.start();
                    } else {
                        Chat.count_top_scroll = $(this).scrollTop();
                    }
                })
            }
        });
    },
    // Отправка сообщения пользователю на user id
    sendMessageToUser: function (id) {
        var message = $('#message-area').val();
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/send-form',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                message: message,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('.dialog-massage-history-block').append(data);
                $('#message-area').val('');
                $('.dialog-massage-history-block').scrollTop(60000000);
            }
        });
    },
    //Прятать див с запросом добавить в друзья
    HideGrayArea: function (el) {
        el.parent().parent().remove();
    },
    // Добавление пользователя в друзья
    AddUserToFriend: function (id) {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/add-user-to-friend',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
            },
            complete: function (data) {
                $('#dialog_main_chat .dialog-massage-add-users').hide();
                Chat.refreshAll();
            }
        });
    },
    //делаю сообщения просмотренными
    makeMessagesOfUserRead: function (id) {
        $('.num-' + id).hide();
    },
    // Удаление диалога с пользователем старт
    deleteDialogToUser: function () {
        open_dialog('okno_chat_info');

    },
    // Удаление диалога с пользователем финиш
    deleteDialogToUserFinishOK: function () {
        var id = $('.user-id').val();
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/delete-dialog',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('.dialog_user_active_' + id).remove();
                Chat.refreshAll();
                close_dialog('okno_chat_info');
                $('#dialog_main_chat').removeClass('active');
            }
        });
    },
    // Блокировка пользователя
    blockUser: function (id) {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/block-user',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                Chat.RefreshDialog();
            }
        });

    },
    // Рзблокировать пользователя
    UnblockUser: function (id) {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/unblock-user',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                Chat.RefreshDialog();
            }
        });
    },
    // Нажатие на кнопку для пользователей
    ButtonClick: function (id_button, user_id) {
        if (id_button == 'button_default') {
            Chat.Show_Dialog_Chat(user_id);
            arrow_hideoffset();
        } else {
            this.id_button = id_button;
            if (id_button.hasClass('active')) {
                Chat.Hide_Dialog_Chat();
                id_button.removeClass('active');
            } else {
                $('.dialog_box_show').removeClass('active');
                Chat.Show_Dialog_Chat(user_id);
                id_button.addClass('active');
            }
        }
    },

    // Скрытие чата
    Hide_Dialog_Chat: function (user_id) {
        $('#dialog_main_chat').removeClass('active');
        $('.dialog_box_show[data-userid="' + user_id + '"]').removeClass('active');
    },
    // Открытие чата
    Show_Dialog_Chat: function (user_id) {
        Chat.closeLeftWindows();
        //делаю сообщения просмотренными
        Chat.makeMessagesOfUserRead(user_id); //
        $('#dialog_main_chat').attr('data-userid', user_id);
        Chat.getDialogWithUser(user_id);
        $('#dialog_main_chat').addClass('active');
    },
    // Закрытие поиска по всем (Добавление нового пользователя)
    SerchCloseAddContact: function () {
        $("#search_add_contact").animate({
            width: 1
        }, 250, function () {
            $("#search_add_contact").hide();
            $("#search_add_freands").hide();
            $('.dialog_box_serch_show_bl').hide();
            $('#dialog_search_add_contact_list').hide();
            $('#dialog-box-section-navy-list').show();
            $('.user_freand_spisok .dialog-box-user-list-item').show();
            $('.dialog-box-content.active').attr('style', '');
            $('.dialog-box-serch-results').hide();

        });
    },
    // Закрытие поиска по друзьям
    SerchCloseFreands: function () {
        $("#search_add_freands").animate({
            width: 1
        }, 250, function () {
            $("#search_add_contact").hide();
            $("#search_add_freands").hide();
            $('#dialog_search_freands_list').hide();
            $('#dialog-box-section-navy-list').show();
            $('.user_freand_spisok .dialog-box-user-list-item').show();
            $('.dialog-box-content.active').attr('style', '');
            $('.dialog-box-serch-results').hide();
            $(".dialog_box_serch_show_bl").hide();
        });
    },
    // Закрытие поиск
    SerchCloseALL: function () {
        $('.dialog-box-content.active').hide();
        $('.dialog_box_serch_show').hide();
        $("#search_add_contact").hide();
        $("#search_add_freands").hide();
        $(".dialog_box_serch_show_bl").hide();
        $("#dialog-box-contenttab-all").show();
    },
    // Открытие поиска по всем (Добавление нового пользователя)
    SerchOpenAddContact: function (el) {
        // Скрываем
        if (el.hasClass('active')) {
            $('.dialog-box-onclick-activated').removeClass('active');
            Chat.SerchCloseAddContact()
        } else {
            $('.dialog-box-onclick-activated').removeClass('active');
            $(el).addClass('active');
            $('.dialog-box-content.active').hide();
            $('.dialog_box_serch_show').hide();
            $('#dialog_search_add_contact_list').show();
            $('.dialog_box_serch_show_bl').show();
            $('#search_add_contact').show();
            $("#search_add_contact").css('width', 1);
            $("#search_add_contact").animate({
                width: 210
            }, 250, function () {
                $(document).keyup(function (e) {
                    if (e.which == 27) {
                        Chat.SerchCloseAddContact();
                    }
                });
            });
        }
    },
    // Открытие поиска по друзьям
    serchOpenFreands: function (el) {
        if (el.hasClass('active')) {
            $('.dialog-box-onclick-activated').removeClass('active');
            Chat.SerchCloseFreands()
            Chat.closeAllWindows();
        } else {
            $('.dialog-box-onclick-activated').removeClass('active');
            $(el).addClass('active');
            $('#dialog_box_serch_show_group').hide();
            $('.dialog_box_serch_show').hide();
            $('.dialog-box-content.active').hide();
            $('.dialog_box_serch_show_bl').show();
            $('#dialog_search_freands_list').show();

            $('#search_add_freands').show();
            $("#search_add_freands").css('width', 1);
            $("#search_add_freands").animate({
                width: 210
            }, 250, function () {
                $(document).keyup(function (e) {
                    if (e.which == 27) {
                        Chat.SerchCloseFreands();
                    }
                });
            });

            $('#search_add_contact').show();
            $("#search_add_contact").css('width', 1);
            $("#search_add_contact").animate({
                width: 210
            }, 250, function () {
                $(document).keyup(function (e) {
                    if (e.which == 27) {
                        Chat.SerchCloseAddContact();
                    }
                });
            });
        }
    },
    // Открытие группы
    GroupOpen: function (el) {
        if (el.hasClass('active')) {
            $('.dialog-box-onclick-activated').removeClass('active');
            $('.user_freand_spisok .dialog-box-user-list-item').show();
            Chat.GroupClose();
            Chat.closeAllWindows();
        } else {
            $('.user_freand_spisok .dialog-box-user-list-item').show();
            $('.dialog-box-onclick-activated').removeClass('active');
            $(el).addClass('active');
            $('.dialog_box_serch_show_bl').hide();
            $("#search_add_contact").hide();
            $("#search_add_freands").hide();
            $('#dialog_search_freands_list').hide();
            $('.dialog_box_serch_show').hide();
            $('#dialog-box-contenttab-all').show();
            $('#dialog_group').show();
            $('#dialog_box_serch_show_group').show();
            $('#dialog_group_list').show();
            $("#dialog_group").css('width', 1);
            $("#dialog_group").animate({
                width: 210
            }, 250, function () {
            });
        }
    },
    // Закрытие группы
    GroupClose: function () {
        $("#dialog_group").animate({
            width: 1
        }, 250, function () {
            $('#dialog_group').hide();
            $('#dialog_group_list').hide();
            $(".dialog_box_serch_show_bl").hide();
        });
    },
    //Рефреш all
    refreshAll: function (refresh) {
        //console.log('refreshAll');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        var active_chat_user = 0;
        if ($('.dialog_main_chat.active').attr('data-userid')) {
            active_chat_user = $('dialog_main_chat.active').attr('data-userid');
        }
        $.ajax({
            url: '/chat/get-all-dialog',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token,
                user_active: active_chat_user
            },
            cache: false,
            async: false,
            success: function (data) {
                if (data.freand) {
                    if (refresh == 'refresh') {
                        data.refresh = true;
                    }
                    data.block_id = '#dialog-box-contenttab-all .user_freand_spisok';
                    Chat.GetRenderFreand(data);
                }
                if (data.status) {
                    $('#online').text(data.status);
                }
            }
        });
    },
    //убрать повторяющихся пользователей
    ClearDublicate: function () { // Отключил
        var supervise = {};
        $('.posible-dublicate').each(function () {
            var id = $(this).attr('data-user');
            //console.log(id);
            if (supervise[id]) {
                $(this).parent().remove();
            }
            else {
                supervise[id] = true;
            }
        });
    },
    RefreshDialog: function (text) {
        // Обновляю далог все
        //var user_id = $('#dialog_main_chat.active').attr('data-userid'); //TODO this user is not defined
        var user_id = 113;
        if (user_id) {
            Chat.getDialogWithUser(user_id, text);
        }
    },
    //  Открытие окна создание группы
    activeGroupEditor: function () {
        //закрыть другие диалоги
        $('#dialog_main_chat').removeClass('active');
        $('#dialog_groups_chat').removeClass('active');
        $('#dialog_main_common_chat').removeClass('active');
        $('#dialog_groups_chat_new').removeClass('active');
        $('dialog_groups_spisok_new').removeClass('active');
        Chat.clearGroupWindow();

        // Создать в бд группу
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/add-new-group',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('#switcher-all').click(); // Нажимает на кнопку Все
                //Chat.GroupClose(); // Закрывает кнопку создать
                $('.group-name').text(data.name);
                $('#dialog-box-contenttab-all .dialog-box-group-list').append(data.append);
                $('#dialog_groups_chat_new .dialog-selector-arrow').css('top', 199);
                $('#dialog_groups_chat_new').css('top', 0);
                $('#dialog_groups_chat_new').addClass('active');

                // для присоединения пользователя к группе
                $('#dialog_groups_chat_new').attr('data-grop-id', data.group_id);   // передаем параметр группы

                // Dragable begin
                var id = '.user_freand_spisok .dialog-box-user-list-item';
                var sortable_id = '#dialog_groups_spisok_new';
                var hide = false;
                dragable_all_list(id, sortable_id);

                $('#dialog_groups_spisok_new').append('<div class="background-bl"></div>');
            }
        });
    },
    // Открыть диалог группы
    openGroupId: function (id, el) {
        //Chat.closeLeftWindows();
        if (el && el.hasClass('active')) {
            $('#dialog_groups_chat').removeClass('active');
            el.removeClass('active');
        } else {
            $('.dialog_group_show').removeClass('active');
            $('.dialog_box_show').removeClass('active');
            $('#dialog_main_common_chat').removeClass('active');
            $('#dialog_main_chat').removeClass('active');
            $('#dialog_groups_chat').addClass('active');
            $('#dialog_groups_chat').attr('data-userid', id);

            $('#dialog-box-contenttab-all').addClass('active');

            if(el){
                el.addClass('active');
                var id_button = el;
                arrow_offset(id_button);
            }else{
                arrow_hideoffset();
            }
            // Получить содержимое диалога
            var csrf_token = $("meta[name=csrf-token]").attr("content");
            $.ajax({
                url: '/chat/get-dialog-by-group',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    _csrf: csrf_token
                },
                cache: false,
                async: true,
                success: function (data) {
                    $('#dialog_groups_chat .dialog-massage-history-block').html(data.dialog);
                    $('#dialog_groups_chat .dialog-massage-history-block').scrollTop(60000000);
                    $('.group-name').text(data.name);

                    //Выводит список членов группы
                    $('#dialog_groups_spisok').html(data.groups_spisok).addClass('active');
                    $('#dialog_groups_chat textarea').val('');

                    // Если это чужая группа то прятать кнопку удалить группу по id
                    if (data.ismygroups) {
                        $('#dialog_groups_chat .dialog-massage-actions-block').show();
                    } else {
                        $('#dialog_groups_chat .dialog-massage-actions-block').hide();

                    }

                    // Если пользователь проскрулил вверх
                    $("#dialog_groups_chat .dialog-massage-history-block").scroll(function (item) {
                        if ($(this).scrollTop() < 1) {
                            Group.count_top_scroll = $(this).scrollTop();
                            ScrollGroup.start();
                        } else {
                            Group.count_top_scroll = $(this).scrollTop();
                        }
                    })
                }
            });
            if(el) {
                el.prev().prev().prev().children().removeClass('active');
            }

            //Dragable begin для группы
            $('#dialog_groups_chat_new').attr('data-grop-id', id);   // передаем параметр группы
            var draggable_id = '.user_freand_spisok .dialog-box-user-list-item';
            var sortable_id = '#dialog_groups_spisok';
            dragable_all_list(draggable_id, sortable_id);
        }
    },
    // Закрытие всех окон
    closeAllWindows: function () {
        //console.log('closeAllWindows');
        $("#search_add_contact").hide();
        $("#search_add_freands").hide();
        $('.dialog_box_serch_show_bl').hide();
        $('#dialog_box_serch_show_group').hide();
        $('#dialog_search_add_contact_list').hide();
        $('#dialog-box-section-navy-list').show();
        $('.user_freand_spisok .dialog-box-user-list-item').show();
        $('.dialog-box-content.active').attr('style', '');
        $('.dialog-box-serch-results').hide();
        $('.dialog-box-onclick-activated').removeClass('active');
        dragable_all_destroy();
        $('.filter-online-chat').addClass('active');

    },
    // Закрытие окон слева
    closeLeftWindows: function () {
        //console.log('closeLeftWindows');
        $('#dialog_main_chat').removeClass('active');
        $('#dialog_groups_chat').removeClass('active');
        $('#dialog_main_common_chat').removeClass('active');
        $('#dialog_groups_chat_new').removeClass('active');
        $('.dialog_group_show').removeClass('active');
        $('.dialog_box_show').removeClass('active');
        dragable_all_destroy();
    },
    // Закрыть текущее окно
    closeThisWindowById: function (id) {
        //console.log('closeThisWindowById ' + id);
        $('#' + id).removeClass('active');
        dragable_all_destroy();
    },
    // Добавление пользователя в группу
    addUsertoGroup: function (id, group_id) {
        //(id+ ' | ' + group_id);
        //console.log('addUsertoGroup');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/add-user-to-group',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                group_id: group_id,
                _csrf: csrf_token
            },
            cache: false,
            async: true,
            success: function (data) {
                if (data.status == 'bad') {
                    alert('Пользователь уже в группе!');
                    $('#dialog_groups_spisok_new .dialog_box_show[data-userid=' + id + ']:last').parent().remove();
                }
            }
        });
    },
    // Очистка окна группы
    clearGroupWindow: function () {
        $('#dialog_groups_spisok_new .dialog-box-user-list-item').remove();
        $('#dialog_groups_spisok_new').removeClass('active');
        $('.dialog-massage-history-block').html('');
    },
    // Удаление пользователя из группы
    DeleteMemberFromGrop: function (id, el) {
        var group_id = $('#group_id').val();
        if (group_id == undefined) {
            group_id = $('#dialog_groups_chat_new').attr('data-grop-id')
        }
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/delete-user-from-group',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                group_id: group_id,
                _csrf: csrf_token
            },
            cache: false,
            async: true,
            success: function (data) {
                el.parent().remove();
                Group.refreshGroups();
            }
        });
    }

};


//////////////////////////////////////////////////////////////////////////////
$(document).ready(function () {

    //Нажатие клавиши ентер
    $('body').on('keypress', '#message-area', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            //console.log('enter');
            var id = $('.user-id').val();
            //alert(id);
            Chat.sendMessageToUser(id);
        }
    });
    //Нажатие клавиши ентер группы
    $('body').on('keypress', '#dialog_groups_chat .message-area-group', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            //console.log('enter');
            Group.sendMessageToGroup();
        }
    });
    $('body').on('keypress', '#dialog_groups_chat_new .message-area-group', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            Group.sendMessageToNewGroup();
        }
    });
    //Нажатие клавиши ентер общий чат
    $('body').on('keypress', '.textarea-common', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            MainChat.SendMessage();
        }
    });

    /*** Живой чат ***/
    setInterval(function () {
        var messageQuantity = $('#message-quantity').val();
        var messageGroupQuantity = $('#message-group-quantity').val();
        var messageCommonQuantity = $('#message-common-quantity').val();
        var totalMembersQuantity = $('#total-members-quantity').val();
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        var csrf_token = $("meta[name=csrf-token]").attr("content");

        console.log(messageGroupQuantity);


        $.ajax({
            url: '/chat/get-message-quantity',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (date) {
                $('#message-group-quantity').val(date.messageGroupQuantity);
                Group.refreshGroupDialogByName($('#group_id').val());

                //результат запроса:
                if (date.messageQuantity != messageQuantity) {
                    // Обычный чат
                    var text = $('#message-area').val();
                    Chat.refreshAll();
                    Chat.RefreshDialog(text);
                    $('#message-quantity').val(date.messageQuantity);
                }

                if (date.messageGroupQuantity != messageGroupQuantity) {
                    // Новое сообщение в чате групп dialog_groups_chat
                    if ($('#dialog_groups_chat.active').hasClass('active')) {
                        var group_id = $('#group_id').val();
                        if (group_id) {
                            $('#message-group-quantity').val(date.messageGroupQuantity);
                            Group.refreshGroupDialogByName(group_id);
                        }
                    }
                    Group.refreshGroups();
                }



                if (date.messageСommon != messageCommonQuantity) {
                    //Новое сообщение в общем чате
                    if ($('#dialog_main_common_chat.active').hasClass('active')) {
                        MainChat.Chat();
                        $('#message-common-quantity').val(date.messageСommon);
                    }
                }
                if (date.totalMembersQuantity != totalMembersQuantity) {
                    //Изменилось количчество членов груп
                    //обновить членов групп !!!!!!!!!
                    Group.refreshGroups();
                    Group.refreshCurrerntMembers();
                    $('#total-members-quantity').val(date.totalMembersQuantity);
                }

            }
        });
    }, 6000);

    /*** Живой чат конец***/

});

//*************************************************** Общий чат ******************************//


var MainChat = {
    OpenMainDialog: function () {
        count_top_scroll:false,
            // Закрытие
            dragable_all_destroy();
        $('#dialog_main_chat').removeClass('active');
        $('#dialog_groups_chat').removeClass('active');
        if ($('#dialog_main_common_chat').hasClass('active')) {
            $('#dialog_main_common_chat').removeClass('active');
            $('#dialog_main_common_chat').hide();
        } else {
            //Открытие
            $('#dialog_main_chat').removeClass('active');
            $('#dialog_groups_chat').removeClass('active');
            $('#dialog_groups_chat_new').removeClass('active');
            MainChat.Chat();
            $('#dialog_main_common_chat').addClass('active');
            $('#dialog_main_common_chat .dialog-massage-history-block').scrollTop(600000);
            $('#dialog_main_common_chat').show();
        }

    },
    // Выведет все сообщения общего чата
    Chat: function () {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/common-chat',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            complete: function (data) {

            },
            success: function (data) {
                $('#dialog_main_common_chat .dialog-massage-history-block').html(data);


                // Если пользователь проскрулил вверх
                $("#dialog_main_common_chat .dialog-massage-history-block").scroll(function (item) {
                    if ($(this).scrollTop() < 1) {
                        MainChat.count_top_scroll = $(this).scrollTop();
                        ScrollMainChat.start();
                    } else {
                        MainChat.count_top_scroll = $(this).scrollTop();
                    }
                })
            }
        });
    },
    // Отправка сообщения в общий чат
    SendMessage: function () {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        var message = $('.textarea-common').val();
        if (message == '') {
            return false;
        }
        $.ajax({
            url: '/chat/send-message-to-common-chat',
            type: 'POST',
            dataType: 'json',
            data: {
                message: message,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('.history-chat').append(data);
                $('.history-chat').scrollTop(60000000);
                $('.textarea-common').val('');
                $('.textarea-common').focus();
            }
        });
    }
};
var Group = {
    message_new_preloader: false,  // для определения координаты позиции скрулла
    // Отрендеривает список групп
    // data.group = {count_new_message,img,group_name}
    // data.block_id - Куда рендерить во Все или Последние
    // data.refresh{true,false} - перезагружает данные
    GetRenderGroops: function (data) {
        if (data.refresh) {
            $(data.block_id).html('');
        }



        for (var key in data.group) {
            var group_id = key;
            var count_new_message = data.group[key].count_new_message;
            var group_name = data.group[key].group_name;
            var img = data.group[key].img;

            // Есть ли такая кнопка. Если нет то добавлять
            if ($(data.block_id + ' .dialog_group_show[data-userid = "' + group_id + '"]').attr('data-userid')) {
                if (count_new_message > 0) {
                    $('.num_group_' + group_id).addClass('active');
                    $('.num_group_' + group_id).html(count_new_message);
                    $('.num_group_' + group_id).show();
                }
            } else {
                $(data.block_id)
                    .append($('<form>', {'class': 'dialog-box-user-list-item', 'id': 'edit_group_id_' + group_id})
                        .append($('<div>', {'class': 'dialog-box-main-avatar-block'})
                            .append($('<div>', {'class': 'num num_group_' + group_id}).append(count_new_message))
                            .append($('<img>', {'src': img, 'width': 30, 'height': 30}))
                    )
                        .append($('<div>', {'class': 'dialog-box-user-list-name'})
                            .append('<span>' + group_name + '</span>')
                            .append($('<input>', {
                                'class': 'new_name_' + group_id,
                                'name': 'text',
                                'value': group_name,
                                'data_id': group_id
                            }))
                    )
                        .append($('<div>', {'class': 'dialog-box-user-choosen-block', 'style': 'z-index: 10;'})
                            .append('<button type="button" class="dialog-box-icon edit" onclick="show_dialog_group_form(\'edit_group_id_' + group_id + '\')"></button>')
                            .append('<button type="button" class="dialog-box-icon save" onclick="Group.SaveGroupName(\'edit_group_id_' + group_id + '\', \'' + group_id + '\')"></button>')
                    )
                        .append($('<div>', {
                            'class': 'dialog_group_show dialog-box-show ',
                            'data-userid': group_id,
                            'onclick': 'Chat.openGroupId(' + group_id + ', $(this))'
                        }))
                );
                $('body').on('keypress', '.new_name_' + group_id, function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        Group.SaveGroupName('edit_group_id_' + $(this).attr('data_id'), $(this).attr('data_id'));
                    }
                    if (e.keyCode == 27) {
                        $('#edit_group_id_' + $(this).attr('data_id')).removeClass('active')

                    }
                });

/*
                if (count_new_message > 0) {
                    $('.num_group_' + user_id).addClass('active');
                    $('.num_group_' + user_id).html(count_new_message);
                    $('.num_group_' + user_id).show();
                }*/
            }
        }

        $(data.block_id).show();

    },
    // Отправка сообщения в группу
    sendMessageToGroup: function () {
        //console.log('Group.sendMessageToGroup');
        var message = $('.message-area-group').val();
        if (message == '') {
            return false;
        }
        var group_id = $('#group_id').val();
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/send-message-to-group',
            type: 'POST',
            dataType: 'json',
            data: {
                group_id: group_id,
                message: message,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('.dialog-massage-history-block').append(data);
                $('.message-area-group').val('');
                $('.dialog-massage-history-block').scrollTop(60000000);
            }
        });
    },
    // Отправка сообщения новой группе
    sendMessageToNewGroup: function () {
        var message = $('#dialog_groups_chat_new .message-area-group').val();
        if (message == '') {
            return false;
        }
        var group_id = $('#dialog_groups_chat_new').attr('data-grop-id');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/send-message-to-group',
            type: 'POST',
            dataType: 'json',
            data: {
                group_id: group_id,
                message: message,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('.dialog-massage-history-block').append(data);
                $('.message-area-group').val('');
                $('.dialog-massage-history-block').scrollTop(60000000);
            }
        });
    },
    // обновить группы
    refreshGroups: function () {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/refresh-group',
            type: 'POST',
            dataType: 'json',
            data: {
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                if (data) {
                    data.block_id = '#dialog-box-contenttab-all .dialog-box-group-list';
                    Group.GetRenderGroops(data);
                }
            }
        });

    },
    // Обновить диалог группы по имени группы
    refreshGroupDialogByName: function (group_id) {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        console.log(group_id);
        $.ajax({
            url: '/chat/refresh-group-dialog-by-gropname',
            type: 'POST',
            dataType: 'json',
            data: {
                group: group_id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                $('.dialog-massage-history-block').html(data.code);
                $('.dialog-massage-history-block').scrollTop(60000000);
                var id = $('#group_id').val();
                if ($('#dialog_groups_chat').hasClass('active') && id == data.group_id) {
                    $('.dialog-massage-history-block').html(data.code);
                    $('.dialog-massage-history-block').scrollTop(60000000);
                }
            }
        });
    },
    // Удаление диалога с пользователем старт
    DeleteGropById: function () {
        open_dialog('okno_chat_group_info');
    },
    //Удаление группы
    DeleteGropByIdFinish: function () {
        dragable_all_destroy();
        var group_id = $('#group_id').val();
        var name = $('#dialog_groups_chat .group-name').text();
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/delete-group-name',
            type: 'POST',
            dataType: 'json',
            data: {
                id: group_id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            complete: function (data) {
                $('#dialog_groups_chat').removeClass('active');
                $('#dialog_groups_chat_new').removeClass('active');
                if (data.status) {
                    $('#edit_group_id_' + group_id).remove();
                }
                Group.refreshGroups();
            }
        });
        close_dialog('okno_chat_group_info')
    },
    // Удалить кнопку удаление группы если чужая группа
    removeDeleteButton: function (id) {
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/chat/is-my-group',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                if (data.result == false) {
                    $('#dialog_groups_chat .dialog-massage-actions-block').hide();
                } else {
                    $('#dialog_groups_chat .dialog-massage-actions-block').show();
                }
            }
        });
    },
    // Обновить членов группы в всплывающем окне
    refreshCurrerntMembers: function () {
        var group_id = $('#group_id').val();
        var csrf_token = $("meta[name=csrf-token]").attr("content");

        $.ajax({
            url: '/chat/get-members-of-group',
            type: 'POST',
            dataType: 'json',
            data: {
                id: group_id,
                _csrf: csrf_token
            },
            cache: false,
            async: true,
            success: function (date) {
                $('#dialog_groups_chat #dialog_groups_spisok').html(date).addClass('active');
            }
        });
    },
    // Сохранение имени группы
    SaveGroupName: function (id, group_id) {
        console.log('SaveGroupName');
        //Chat.closeAllWindows();
        var id_form = $('#' + id);
        if ($('#' + id).hasClass('active')) {
            $('#' + id).removeClass('active')
        } else {
            $('#' + id).addClass('active')
        }
        var name = $('.new_name_' + group_id).val();
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        if (name) {
            $.ajax({
                url: '/chat/edit-group-name',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: group_id,
                    name: name,
                    _csrf: csrf_token
                },
                cache: false,
                async: false,
                success: function (data) {
                    $('.new_name_' + group_id).prev().text(data.name);
                    $('.group-name').text(data.name);
                    if (data.error) {
                        alert('Такая группа уже существует');
                    } else {
                        $('.new_name_' + group_id).prev().text(data.name);
                        $('.group-name').text(data.name);
                    }
                }
            });
        }
    }
};

var Scroll = {
    start: function () {
        //Если позиция скрола вверху то подгружать более ранние сообщения
        var user_id = $('#dialog_main_chat .user-id').val();
        var time = $('#dialog_main_chat .dialog-massage-history-block .dialog-box-massage:nth-child(1) .date').attr('data-time');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        if (!Chat.message_new_preloader) {
            Chat.message_new_preloader = true;
            $('#dialog_main_chat .dialog-massage-history-block').prepend('<div class="preload_message" style="padding: 15px 0;"><i class="jpreloader" style="width: 100%;height:20px;display: block;background-size: contain;"></i></div>');
            $.ajax({
                url: '/chat/get-dialog-with-user-from-archive',
                type: 'POST',
                dataType: 'json',
                data: {
                    user_id: user_id,
                    time: time,
                    _csrf: csrf_token
                },
                cache: false,
                async: false,
                success: function (data) {
                    $('#dialog_main_chat .dialog-massage-history-block').prepend(data.html);
                    if (data.count) {
                        var count_scrool = $('#dialog_main_chat .dialog-massage-history-block').scrollTop();
                        +150;
                        $('#dialog_main_chat .dialog-massage-history-block').scrollTop(count_scrool);
                        Chat.message_new_preloader = 0;
                        $('#dialog_main_chat .dialog-box-massage.inbox').animate({
                            opacity: 1
                        }, 3500, function () {

                        });
                    }
                    Chat.message_new_preloader = false;
                    $('.preload_message').remove();
                }
            });
        }
    }
};

var ScrollGroup = {
    start: function () {
        var count_message = 0;
        //Если позиция скрола вверху то подгружать более ранние сообщения
        var group_id = $('#group_id').val();
        var time = $('#dialog_groups_chat .dialog-massage-history-block .dialog-box-massage:nth-child(1) .date').attr('data-time');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        if (!Group.message_new_preloader) {
            Group.message_new_preloader = true;
            $('#dialog_groups_chat .dialog-massage-history-block').prepend('<div class="preload_message" style="padding: 15px 0;"><i class="jpreloader" style="width: 100%;height:20px;display: block;background-size: contain;"></i></div>');
            $.ajax({
                url: '/chat/get-dialog-with-group-from-archive',
                type: 'POST',
                dataType: 'json',
                data: {
                    group_id: group_id,
                    time: time,
                    _csrf: csrf_token
                },
                cache: false,
                async: false,
                success: function (data) {
                    $('#dialog_groups_chat .dialog-massage-history-block').prepend(data.html);
                    if (data.count) {
                        var count_scrool = $('#dialog_groups_chat .dialog-massage-history-block').scrollTop() + 150;
                        $('#dialog_groups_chat .dialog-massage-history-block').scrollTop(count_scrool);
                    }
                    $('#dialog_groups_chat .dialog-box-massage.inbox').animate({
                        opacity: 1
                    }, 3500, function () {

                    });
                    Group.message_new_preloader = false;
                    $('.preload_message').remove();
                }
            });
        }
    }
};
var ScrollMainChat = {
    start: function () {
        var count_message = 0;
        //Если позиция скрола вверху то подгружать более ранние сообщения
        var time = $('#dialog_main_common_chat .dialog-massage-history-block .dialog-box-massage:nth-child(1) .date').attr('data-time');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        if (!MainChat.message_new_preloader) {
            MainChat.message_new_preloader = true;
            $('#dialog_main_common_chat .dialog-massage-history-block').prepend('<div class="preload_message" style="padding: 15px 0;"><i class="jpreloader" style="width: 100%;height:20px;display: block;background-size: contain;"></i></div>');
            $.ajax({
                url: '/chat/get-dialog-with-main-chat-archive',
                type: 'POST',
                dataType: 'json',
                data: {
                    time: time,
                    _csrf: csrf_token
                },
                cache: false,
                async: false,
                success: function (data) {
                    $('#dialog_main_common_chat .dialog-massage-history-block').prepend(data.html);
                    if (data.count) {
                        var count_scrool = $('#dialog_main_common_chat .dialog-massage-history-block').scrollTop() + 150;
                        $('#dialog_main_common_chat .dialog-massage-history-block').scrollTop(count_scrool);
                    }
                    $('#dialog_main_common_chat .dialog-box-massage.inbox').animate({
                        opacity: 1
                    }, 3500, function () {

                    });
                    MainChat.message_new_preloader = false;
                    $('.preload_message').remove();
                }
            });
        }
    }
};

$(document).ready(function () {
    //Group.refreshGroups();
    Chat.refreshAll();
})