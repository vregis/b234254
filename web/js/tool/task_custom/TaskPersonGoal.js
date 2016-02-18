/**
 * Created by toozzapc2 on 03.02.2016.
 */
function TaskPersonGoal() {
    $("#mask_currency").mask('000,000,000,000,000', {reverse: true});

    $(".task-title button.btn-success").click(function(e){
        var money = $('.task-custom .personal-fields .form-control[name="Goal[count_money]"]').val();
        var date = $('.task-custom .personal-fields .form-control[name="Goal[date]"]').val();
        if(money && money != '' && date != ''){
            $(this).removeClass('static');
            money = money.replace(/,/g, '');
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                "Goal[count_money]": money,
                "Goal[date]": date
            };
            $.ajax({
                url: '/departments/person-goal-save',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(response){
                    if(!response.error) {
                        document.location.href='/departments';
                    }else {
                        if(response.message) {
                            toastr.warning(response.message, "Attention");
                        }
                    }
                }
            });
        }else{
            e.preventDefault();
            $(this).addClass('static');
            toastr.warning("Please, fill all fields", "Attention");
        }
    });
}