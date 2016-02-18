function DeletFriendDialog(id, name){
    $('#del_friend_users').attr('href', '/user_profile/' + id);
    $('#del_friend_users').html(name);
    $('#del_friend_users').attr('href', '/user_profile/' + id);
    $('#del_frends button').attr('onclick','DeleteFriendById('+id+')');
    open_dialog('del_frends');
}


function DeleteFriendById(id) {
    //console.log('DeleteFriendById id= ' + id);
    //console.log('Element:  ' + el);
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    //alert(csrf_token);
    //1 отправить id в контроллер на удаление
    $.ajax({
        url: '/contact/delete-friend',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            _csrf: csrf_token
        },
        cache: false,
        async: true,
        success: function () {
            $('.user_friend_id_'+ id +' .close-block').remove();
            $('.user_friend_id_'+ id +' .button-green.left-group-bl').after('<a class="button-green add-group right-group-bl two-line-text" href="/contact/add?id='+id+'">Пригласить в<br> друзья</a>');
            close_dialog('del_frends');
        },
        complete: function () {
            //el.after('<a href="/contact/recovery?id='+ id +' " class="close-block" style="font-size:12px!important">Востановить</a>');

            //$('a.add-group').after('<a href="/contact/recovery?id=' + id + ' " class="button-green add-group friend" style="">Вернуть<br>друга</a>');

        }
    });
}

/*function showInput() {
    //console.log('showInput');
    //$('#22').css({'width': '150px', 'height': '30px', 'border': '2px solid blue'}).show();
    var csrf_token = $("meta[name=csrf-token]").attr("content");
    //подрузить ajaksom в дроп даун город  массив городов по id country
    var id_country = $('#select-country').val();
    //console.log(id_country);
    //alert(id_country);
    $.ajax({
        url: '/contact/get-arr-citys',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id_country,
            _csrf: csrf_token
        },
        cache: false,
        async: true,
        success: function (data) {
            
            $('.target').html(data);
            
        }
    });

}*/






