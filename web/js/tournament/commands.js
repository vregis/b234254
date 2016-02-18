$(document).ready(function () {


});
function command_tournament_info_show(id) {
    var that = $('#' + id);
    if (that.hasClass('active')) {
        that.removeClass('active')
    } else {
        that.addClass('active')
    }
}

function TournamentSort() {
    if ($('#structure_games_sort').hasClass('active')) {
        $('#structure_games_sort').removeClass('active');
        sort('DESC');
    } else {
        $('#structure_games_sort').addClass('active')
        sort('ASC');
    }
}
function sort(sort) {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        url: '/tournament/sort',
        type: 'POST',
        dataType: 'json',
        data: {
            sort: sort,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            //alert(1);
            $('.command-tournament-sp').html(data);

        },
        complete: function (data) {
            //alert(2);
            //$('.command-tournament-sp').html(data);

        }
    });
}
function addDataToForm(time, game_id) {
    //var time = el.attr('date-time');
    $('#datetimepicker').val(time);
    $('#game_id').val(game_id);
    //alert(time);
}
function SendForm() {
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    var game_id = $('#game_id').val();
    var time = $('#datetimepicker').val();
    // alert(game_id +' | '+ time);
    $.ajax({
        url: '/tournament/change-game-time',
        method: 'POST',
        dataType: 'json',
        data: {
            game_id: game_id,
            time: time,
            _csrf: csrf_token
        },
        cache: false,
        asinc: false,
        success: function (data) {
            $('#gameid-' + game_id).children('.dmY').html(data.dmY);
            $('#gameid-' + game_id).children('.min').html(data.min);
           // window.location.href="/dota/tournament/"+ game_id;
        },
        complete: function (data) {
            $('#gameid-' + game_id).children('.dmY').html(data.dmY);
            $('#gameid-' + game_id).children('.min').html(data.min);
            //window.location.href="/dota/tournament/"+ game_id;
        }
    });
}
// Вывод сеток
function GetAjaxNetWork(tour_id, network) {
    //alert(tour_id + ' | ' + network);
    var csrf_token = $("meta[name=csrf-token]").attr("content");

    $.ajax({
        url: '/tournament/get-network',
        method: 'POST',
        dataType: 'json',
        data: {
            tour_id: tour_id,
            network: network,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            //if(network == 5){
            //    //$('table.command-tournament-table').after(data);
            //    //$('table.command-tournament-table').hide();
            //    return false;
            //}



            $('table.command-tournament-table').animate({
                opacity: 0
            }, 300,
                function () {});

            $('table.command-tournament-table').html(data);
            $('table.command-tournament-table').animate({
                opacity: 1
            }, 800 );
            // изменить подсветку тек меню
            $('.command-menu-bl').removeClass('active');
            $('.network_'+network).addClass('active');
        }
    });

}