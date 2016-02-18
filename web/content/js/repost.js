function RepostContent(modname,content_id){
    //alert(moduleName + ' | ' + content_id);
        var csrf_token = $("meta[name=csrf-token]").attr("content");
    $.ajax({
        type: 'POST',
        url: '/user_repost/add',
        dataType: 'json',
        data: {
            content_id: content_id,
            modname: modname,
            _csrf: csrf_token
        },
        cache: false,
        asinc: false,
        success: function (data) {
            alert('ok');
        }
    });
    
}