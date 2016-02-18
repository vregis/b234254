function TeamSort() {

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
        url: '/team/sort',
        type: 'POST',
        dataType: 'json',
        data: {
            sort: sort,
            _csrf: csrf_token
        },
        cache: false,
        success: function (data) {
            $('.command-games-played').html(data);
        },
        complete: function (data) {
            //alert(2);
            //$('.command-tournament-sp').html(data);

        }
    });
}
