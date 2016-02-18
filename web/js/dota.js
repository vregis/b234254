$(document).ready(function () {

    // глобальные переменные
    var body = $('body');
    var button = $('#discussion-show-more');
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var loadingFlag = false;

    /**
     * Создать игру
     */
    body.on('click', '#button_dota_create_game', function (e) {
        e.preventDefault();

        var form_dota_create_game = $('#form_dota_create_game');

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: form_dota_create_game.attr('action'),
                dataType: 'json',
                data: form_dota_create_game.serialize(),
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {
                    if (data.url) {
                        window.location = data.url;
                        return false;
                    }

                    if (!data.url && data) {
                        var message = '';
                        if (typeof data === 'object') {
                            for (var key in data) {
                                message += data[key] + '<br>';
                            }
                        } else {
                            message = data;
                        }
                        system_dialog(message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Спиннер
     */
    body.on('click', ".spinner button", function (e) {
        e.preventDefault();

        var type = $(this).attr('class');
        var input = $(this).parent().find('input');
        var cur_val = parseInt(input.val());
        if (type == 'down' && cur_val > 1) {
            input.val(cur_val - 1);
        } else if (type == 'up' && cur_val < 5) {
            input.val(cur_val + 1);
        }
    });

    /**
     * Занять место в игре
     */
    body.on('click', '.dota-game-join', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'GET',
                url: self.attr('data-url'),
                dataType: 'json',
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.status && data.url) {
                        window.location = data.url;
                        return false;
                    }

                    if (!data.status && data.message.length > 0) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Сменить команду
     */
    body.on('click', '.dota-game-change-command', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'GET',
                url: self.attr('data-url'),
                dataType: 'json',
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.status) {
                        reloadAll();
                    }

                    if (!data.status && data.message.length > 0) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Покинуть команду
     */
    body.on('click', '.dota-game-leave', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!confirm(self.attr('data-confirm_message'))) {
            return false;
        }

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: self.attr('data-url'),
                data: {
                    _csrf: csrf_token,
                    redirectUrl: $('#redirectUrl').val()
                },
                dataType: 'json',
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.url) {
                        window.location = redirectUrl;
                        return false;
                    }

                    if (data.status) {
                        window.location = data.redirectUrl;
                        return false;
                    }

                    if (data.message.length > 0) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Готов начать игру
     */
    body.on('click', '.dota-game-ready', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!confirm(self.attr('data-confirm_message'))) {
            return false;
        }

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: self.attr('data-url'),
                data: {
                    _csrf: csrf_token
                },
                dataType: 'json',
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.status) {
                        reloadAll();
                    }

                    if (data.message.length > 0) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Отмена игры
     */
    body.on('click', '#dota_game_cancel', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!confirm(self.attr('data-confirm_message'))) {
            return false;
        }

        if (!loadingFlag) {
            loadingFlag = true;
            $.ajax({
                type: 'GET',
                url: self.attr('data-url'),
                dataType: 'json',
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.url) {
                        window.location = data.url;
                        return false;
                    }

                    if (data.message.length > 0) {
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Редактирование описания
     */
    body.on('click', '#dota_game_update', function (e) {
        e.preventDefault();

        $('.jeditable').click();
    });

    /**
     * Кнопка "Создать игру"
     */
    body.on('click', '#dota-game-create-button', function (e) {
        e.preventDefault();

        var self = $(this);
        if (!loadingFlag) {
            loadingFlag = true;
            $.ajax({
                type: 'GET',
                url: self.attr('data-url'),
                dataType: 'json',
                cache: false,
                beforeSend: function (xhr) {
                    jpreloader('show');
                },
                success: function (data) {

                    if (data.message.length > 0) {
                        close_dialog('quick_game_create');
                        system_dialog(data.message);
                    }
                    loadingFlag = false;
                    jpreloader('hide');
                }
            });
        }
    });

    /**
     * Отправить сообщение в чат
     */
    body.on('click', '#chat-submit-message-button', function (e) {
        e.preventDefault();

        var form_dota_send_message = $('#form_dota_send_message');

        if (!loadingFlag) {
            loadingFlag = true;

            $.ajax({
                type: 'POST',
                url: form_dota_send_message.attr('action'),
                dataType: 'json',
                data: form_dota_send_message.serialize(),
                cache: false,
                beforeSend: function (xhr) {
                    //jpreloader('show');
                },
                success: function (data) {

                    if (data.status) {
                        $('#game-chat-textarea').val('');
                        loadChatMessages();
                    }

                    if (!data.status && data.message.length > 0) {
                        $('#game-chat-textarea').val(data.filteredMessage);
                        system_dialog(data.message);
                    }

                    loadingFlag = false;

                    //jpreloader('hide');
                }
            });
        }
    });

    /**
     * Обновляет блоки при подключении к игре
     */
    body.on('click', '#connect_to_game', function (e) {
        reloadAll();
    });

    body.on('click', '.tipe-of-game .btn-bl', function (e) {
        e.preventDefault();

        var value = $(this).attr('data-value');

        $('.tipe-of-game .btn-bl').removeClass('active');
        $(this).addClass('active');

        if (value == 'n') {
            $('#select_players_count').slideDown('normal');
            // selectize
            setSelectizeValue('select_count_one', 1);
            setSelectizeValue('select_count_two', 1);
        } else {
            $('#select_players_count').slideUp('normal');
            // selectize
            setSelectizeValue('select_count_one', value);
            setSelectizeValue('select_count_two', value);
        }
    });
});

/**
 * Подгружает блок "Составы комманд"
 */
function loadTeams() {
    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            url: '/dota/teams/' + $("#dota_game_id").val(),
            type: 'GET',
            dataType: 'json',
            cache: false,
            async: true,
            success: function (data) {
                if (data.url) {
                    window.location = data.url;
                    return false;
                }
                $("#dota_game_teams").html(data.html);
                loadingFlag = false;
            }
        });
    }
}

/**
 * Подгружает блок с параметрами игры (таблица)
 */
function reloadInfo() {
    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            url: '/dota/info/' + $("#dota_game_id").val(),
            type: 'GET',
            dataType: 'json',
            cache: false,
            async: true,
            success: function (data) {
                $("#dota_game_info").html(data);
                loadingFlag = false;
            }
        });
    }
}

/**
 * Подгружает сообщения в чат игры
 */
function loadChatMessages() {
    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            url: '/dota/chat/get?id=' + $("#dota_game_id").val() + '&chat_id=' + $('#last_message_id').val(),
            type: 'GET',
            dataType: 'json',
            cache: false,
            async: true,
            success: function (data) {
                /** нет новых сообщений */
                if (data.noUpdate) {
                    loadingFlag = false;
                    return false;
                }
                $(".chat-messages").html(data.html);
                $(".chat-messages").scrollTop($('.chat-messages')[0].scrollHeight);
                if (data.lastMessageId) {
                    $('#last_message_id').val(data.lastMessageId);
                }
                loadingFlag = false;
            }
        });
    }
}

/**
 * Подгружает или убирает чат
 */
function reloadChat() {
    var loadingFlag = false;
    if (!loadingFlag) {
        loadingFlag = true;
        $.ajax({
            url: '/dota/chat/getchat?id=' + $("#dota_game_id").val(),
            type: 'GET',
            dataType: 'json',
            cache: false,
            async: true,
            success: function (data) {
                $("#dota-game-chat-block").html(data);
                $(".chat-messages").scrollTop(10000);
                loadingFlag = false;
            }
        });
    }
}

/**
 * Обновляет все блоки
 */
function reloadAll() {
    loadTeams();
    reloadInfo();
    reloadChat();
}

/**
 * Горячие клавиши для чата
 */
function registerChatKeys() {
    $('#form_dota_send_message').keydown(function (e) {

        switch (e.which) {
            case (13): // enter
                e.preventDefault();
                $('#chat-submit-message-button').click();
                break;
        }
    });
}

/**
 * Выбирает элемент из селекта (selectize)
 *
 * @param select_id
 * @param value
 */
function setSelectizeValue(select_id, value) {
    var el = $('#' + select_id);
    el.val(value); // initialize the selectize control
    var $select = el.selectize(); // fetch the instance
    var selectize = $select[0].selectize;
    selectize.setValue(value);
}