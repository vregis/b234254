var Filter = {
    getlist: function () {

        //console.log('Filter.getlist');
        $('.empty').hide();

        var login = $('.valid').val();
        var sex;
        if ($('input#form_search_man').prop("checked")) {
            sex = 2;
        }
        else if ($('input#form_search_female').prop("checked")) {
            sex = 1;
        } else {
            sex = 0;
        }
        var country = $('#messages-country_id').val();
        var city = $('#messages-city_id').val();//ошибка
        //alert(city);
        var csrf_token = $("meta[name=csrf-token]").attr("content");

        console.log('login: ' + login);
        console.log('sex: ' + sex);
        console.log('country: ' + country);
        console.log('city: ' + city);

        $.ajax({
            url: '/contact/filter2',
            method: 'POST',
            dataType: 'json',
            data: {
                login: login,
                sex: sex,
                country: country,
                city: city,
                _csrf: csrf_token
            },
            cache: false,
            success: function (data) {
                //console.log(data);
                $('.list-users').html(data);
            }
        });
    }

};


