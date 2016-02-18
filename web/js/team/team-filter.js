var Team = {
    Filter: function (item) {
        var name = $('#name').val();
        var country = $('#country').val();
        var page = item.attr('data-page');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        $.ajax({
            url: '/team/filter',
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                country: country,
                page: page,
                _csrf: csrf_token
            },
            cache: false,
            async: false,
            success: function (data) {
                if(data.error){

                }else{
                    if(data.page_count && data.page_count == 'hide'){
                        $('#command_list_page').hide();
                    }else{
                        item.attr('data-page',data.page_count);
                    }
                    $('#temp-result-window').remove();
                    $('.command-spisok-all-sp').append(data.html);
                    $('.command-spisok-all-sp .command-spisok-all-tbl').animate({
                        opacity: 1
                    }, 1000, function () {

                    });

                }
                
            }
        });
    }

};