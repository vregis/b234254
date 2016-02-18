var Finance = {
    SubmitCard: function() {

        console.log('Finance.Submit');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        var login = $('#login').val();
        var card_number = $('#number').val();
        var code = $('#code').val();
        var summa = $('#count').val();
        var month = $('#month option:selected').val();
        var year = $('#year option:selected').val();
        var exp = month + year;

        console.log('login: ' + login);
        console.log('card_number: ' + card_number);
        console.log('code: ' + code);
        console.log('summa: ' + summa);
        console.log('month: ' + month);
        console.log('year: ' + year);
        console.log('exp: ' + exp);

        //alert(3);
        $.ajax({
            url: '/finance/submit',
            method: 'POST',
            dataType: 'json',
            data: {
                login: login,
                card_number: card_number,
                code: code,
                summa: summa,
                exp: exp,
                _csrf: csrf_token
            },
            cache: false,
            complete: function(response) {
                //console.log(response);
                //$('.payment-rezult').show().text(response);
            },
            success: function(response) {
                //alert('ok');
                window.location.href = ('/finance/history');
                //$('.payment-rezult').show().css('color','magenta').append(response);

            },
            error: function(response) {
                window.location.href('/finance/history');
                //$('.payment-rezult').show().text(response);

            }
        });
    },
    Show: function(name) {
        console.log('Finance.Show ' + name);
        Finance.HideAll();
        $('#' + name).show();
    },
    HideAll: function() {
        console.log('Finance.HideAll');
        $('.form-income').hide();

    },
    SubmitWebmoney: function() {
        console.log('Finance.SubmitWebmoney');
        var csrf_token = $("meta[name=csrf-token]").attr("content");
        var login = $('#login_wm').val();
        var card_number = $('#card-number-wm').val();
        var descr = $('#descriptio-wm').val();
        var summa = $('#summ-wm').val();
        var pay_nomber = $('#payment_num-wm').val();

        console.log('login: ' + login);
        console.log('card_number: ' + card_number);
        console.log('descr: ' + descr);
        console.log('summa: ' + summa);
        console.log('pay_nomber: ' + pay_nomber);

        $.ajax({
            type: "POST",
            url: "/finance/submit-webmoney",
            method: 'POST',
            dataType: 'json',
            data: {
                login: login,
                card_number: card_number,
                descr: descr,
                summa: summa,
                pay_nomber: pay_nomber,
                _csrf: csrf_token
            }
        });
    }
};
$('document').ready(function(){
   //изменяю значение скрытого поля SignatureValue отправля данные на акшен md5
   var csrf_token = $("meta[name=csrf-token]").attr("content");
   $('.robokassa-money').keyup(function(){
     
       var OutSum = $('.robokassa-money').val();
        $.ajax({
            type: "POST",
            url: "/finance/md5",
            method: 'POST',
            dataType: 'json',
            data: {
                OutSum: OutSum,
                _csrf: csrf_token
            },
            success: function(data) {
                $('#SignatureValue').val(data);
                //alert(data);
            }
        });
   });
});


