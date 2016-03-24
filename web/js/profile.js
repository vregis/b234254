$(document).ready(function() {
    $(document).on('change',function(){
        $('.services .service input.form-control[data-key="rate"]').inputmask({
            "mask": "9",
            "repeat": 3,
            "greedy": false,
        }); // 
        setTimeout(function(){
            $.each($('.dropdown-menu.inner'),function(){
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });
        },400);
    });
    $(document).on('click', '.spec', function(){
            console.log("asdasdasd");
            var __this = $(this);
            if($(this).next('.dropdown-content').is(":visible")){
                $(this).next('.dropdown-content').hide();
                $(this).find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
            }else{
            renderMulti($(this));
            $('.sel2').selectpicker({});
            $('input[type=checkbox]').uniform();
            $(document).on("click", function(event){
                var $trigger = $(".caret, .services .service .multiselect .dropdown-content ul li *");
                if($trigger !== event.target && !$trigger.has(event.target).length){
                    if(__this.next('.dropdown-content').is(":visible")){
                        $trigger.find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
                        __this.next('.dropdown-content').hide(1,function(){
                            if(__this.hasClass('task')){ console.log(__this);
                                renderNewTask(__this);
                                setTimeout(function(){
                                    $('.services .service input.form-control[data-key="rate"]').inputmask({
                                        "mask": "9",
                                        "repeat": 3,
                                        "greedy": false,
                                    }); // 
                                },500);
                            }else{
                                renderNewField(__this);
                                setTimeout(function(){
                                    $('.services .service input.form-control[data-key="rate"]').inputmask({
                                        "mask": "9",
                                        "repeat": 3,
                                        "greedy": false,
                                    }); // 
                                },500);
                            }
                        });
                    }
                }
            });
            $(document).on('click', ".services .service .multiselect .dropdown-content ul li .spec-name",function(){
                if($(this).closest('.multiselect').hasClass('add')){
                    var type = 'add';
                }else{
                    var type = 'update';
                }

                var data = {
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    spec_id: $(this).attr('data-id'),
                    tu_id: $(this).closest('.dynamic-block').attr('data-id'),
                    dep: $(this).closest('.panel-group').attr('data-department'),
                    type: type
                };
                var that = $(this);
                $.ajax({
                    url: '/core/update-specialization',
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    success: function(response){
                        that.closest('.panel-collapse').find('.service').html(response.html);
                    }
                })
            });
        }

    });



      $.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
          this.trigger(ev);
          return el.apply(this, arguments);
        };
      });
});
$(function(){
    $('.collapse').collapse({
        // toggle:false
    }).on('shown.bs.collapse',function(e){
        setTimeout(function(){
            $.each($('.dropdown-menu.inner'),function(){
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });
        },400);
        var targ = $(this);
        /*App.blockUI({
            target: targ,
            animate: true
        });*/
        var dep = $(this).closest('.panel-group').attr('data-department');
        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content")
        };
        var that = $(this);
        $.ajax({
            url: '/core/set-department-session',
            type: 'post',
            dataType: 'json',
            data: {dep:dep},
            success: function(response){
                that.closest('.panel-collapse').find('.service').html(response.html);
                $('.sel2').selectpicker({});
                $('input[type=checkbox]').uniform();
                $('.services .service input.form-control[data-key="rate"]').inputmask({
                    "mask": "9",
                    "repeat": 3,
                    "greedy": false,
                }); //
                //App.unblockUI(targ);
            }
        });
        console.log(dep);
    }).on('hidden.bs.collapse', function(){
    });
    $("[data-toggle='collapse']").click(function(e){

        if(!$(this).attr('href')){
            var collapseEl = $(this).attr('data-target');
        }else{
            var collapseEl = $(this).attr('href');
        }
        $(collapseEl).collapse('toggle');
    });
    $(".services .accordion .panel .panel-title .check").click(function(e){

        if($(this).hasClass('sell_department')){
            checkSell($(this));
            checkShow($(this));
        }
        if($(this).hasClass('do_department')){
            checkDo($(this));
        }

                    e.preventDefault();
            e.stopPropagation();
        $(this).toggleClass('active');
    });
    $.each($(".services .accordion .panel .panel-title .sell .check"),function(e){
        var that = $(this);
        if(that.hasClass('active')){
            that.closest('.accordion-toggle')
            .attr('data-toggle','collapse')
            .attr('data-target',that.attr('href'))
            .attr('aria-expanded','true')
            .css({'cursor':"pointer"});
            that.removeAttr('data-toggle').removeAttr('aria-expanded').removeAttr('href');
            console.log(that.closest('.accordion-toggle').attr('data-target'));
            $(that.closest('.accordion-toggle').attr('data-target')).collapse('toggle');
        }else{
            $(that.closest('.accordion-toggle').attr('data-target')).collapse('hide');
            that
            .attr('data-toggle','collapse')
            .attr('href',that.closest('.accordion-toggle').attr('data-target'))
            .attr('aria-expanded','true');
            that.closest('.accordion-toggle').removeAttr('data-toggle').removeAttr('data-target').removeAttr('aria-expanded').css({'cursor':"default"});
        }
    });
    $(".services .accordion .panel .panel-title .sell .check").click(function(e){
        var that = $(this);

        if(that.hasClass('active')){
            that.closest('.accordion-toggle')
            .attr('data-toggle','collapse')
            .attr('data-target',that.attr('href'))
            .attr('aria-expanded','true')
            .css({'cursor':"pointer"});
            that.removeAttr('data-toggle').removeAttr('aria-expanded').removeAttr('href');
            console.log(that);
            console.log("active");

        }else{
            console.log("none");
            e.preventDefault();
            e.stopPropagation();
            that
            .attr('data-toggle','collapse')
            .attr('href',that.closest('.accordion-toggle').attr('data-target'))
            .attr('aria-expanded','true');
            that.closest('.accordion-toggle').removeAttr('data-toggle').removeAttr('data-target').removeAttr('aria-expanded').css({'cursor':"default"});

            $(that.attr('href')).collapse('hide');
        }
    });
    $(document).on('click', '.plused', function(){
        var id = $('.plused').data('c');
        $(this).hide();
        $(this).closest('.form-group').append('<i class="fa fa-times del_edu" style="color:red; margin-top:8px;  margin-left:19px"></i>');
        $(this).closest('.col-md-1').remove();
        $.ajax({
            url: '/core/addeducation',
            method: 'post',
            dataType: 'json',
            data: {id:id},
            success: function(response){
                if(response.error == false){
                    $('.educations').append(response.html);
                    $('.plused').each(function(){
                        $(this).data('c', id+1);
                    })
                }else{
                    alert('Something wrong, please try again');
                }
                setTimeout(function(){
                    $('.services .service input.form-control[data-key="rate"]').inputmask({
                        "mask": "9",
                        "repeat": 3,
                        "greedy": false,
                    }); // 
                },500);
                setTimeout(function(){
                    $.each($('.dropdown-menu.inner'),function(){
                        var els = $(this).find('li');
                        console.log(els.length);
                        if(els.length > 8){
                            $(this).mCustomScrollbar({
                                setHeight: 252,
                                theme:"dark",
                                scrollbarPosition:"outside"
                            });  
                        }else{
                            $(this).mCustomScrollbar({
                                theme:"dark",
                                scrollbarPosition:"outside"
                            });  
                        }
                    });
                },400);
                console.log("hui");
            }
        })
    })

    $('.save').on('click', function(e){
        e.preventDefault();
        var fname = $('input[name="ProfileForm[first_name]"]').val();
        var lname = $('input[name="ProfileForm[last_name]"]').val();
        var status = $('input[name="ProfileForm[status]"]').val();
        var rate = $('input[name="ProfileForm[rate]"]').val();
        var country = $('select[name="ProfileForm[country_id]"]').val();
        var city = $('input[name="ProfileForm[city_title]"]').val();
        var about = $('textarea[name="ProfileForm[about]"]').val();
        var tw = $('input[name="ProfileForm[social_tw]"]').val();
        var fb = $('input[name="ProfileForm[social_fb]"]').val();
        var ln = $('input[name="ProfileForm[social_ln]"]').val();
        var inst = $('input[name="ProfileForm[social_in]"]').val();
        var gg = $('input[name="ProfileForm[social_gg]"]').val();
        var email = $('input[name="ProfileForm[email]"]').val();
        var skype = $('input[name="ProfileForm[skype]"]').val();
        var phone = $('input[name="ProfileForm[phone]"]').val();
        var zip = $('input[name="ProfileForm[zip]"]').val();
        var is_first = $('input[name="is_first"]').val();
        // var money = $('input[data-key="rate"]').val();
        if(country == 0){
            $("#alert-modal .modal-body").text("Choose the country");
            $("#alert-modal").modal('show');
            $("#alert-modal").on('shown.bs.modal',function(){
                $("#alert-modal .modal-dialog").css({
                    'margin-top':$(window).height() / 2 - $("#alert-modal .modal-dialog").height() / 2
                });
                setTimeout(function(){
                    $("#alert-modal").modal('hide');
                }, 2000);
            });
            return false;
        }
        $.each($('.collapse.in input[data-key="rate"]'),function (e) {
            if($(this).val() == ''){
                $("#alert-modal .modal-body").text("Rate / h can't be blank");
                $("#alert-modal").modal('show');
                $("#alert-modal").on('shown.bs.modal',function(){
                    $("#alert-modal .modal-dialog").css({
                        'margin-top':$(window).height() / 2 - $("#alert-modal .modal-dialog").height() / 2
                    });
                    setTimeout(function(){
                        $("#alert-modal").modal('hide');
                    }, 2000);
                });
                e.preventDefault();
                return false;
            }
        });
        // if(money == ''){
        //     $("#alert-modal .modal-body").text("Input cost");
        //     $("#alert-modal").modal('show');
        //     $("#alert-modal").on('shown.bs.modal',function(){
        //         $("#alert-modal .modal-dialog").css({
        //             'margin-top':$(window).height() / 2 - $("#alert-modal .modal-dialog").height() / 2
        //         });
        //         setTimeout(function(){
        //             $("#alert-modal").modal('hide');
        //         }, 2000);
        //     });
        //     return false;
        // }
        indstr = $(document).find('.change-industry').val();
        if(typeof(indstr) == 'undefined'){
            $("#alert-modal .modal-body").text("Industry cannot be blank");
            $("#alert-modal").modal('show');
            $("#alert-modal").on('shown.bs.modal',function(){
                $("#alert-modal .modal-dialog").css({
                    'margin-top':$(window).height() / 2 - $("#alert-modal .modal-dialog").height() / 2
                });
                setTimeout(function(){
                    $("#alert-modal").modal('hide');
                }, 2000);
            });
            return false;
        }

        var input_count_money = $('input[name="ProfileForm[count_money]"]');
        var count_money = undefined;
        if(input_count_money.length > 0)
        {
            count_money = input_count_money.val();
            count_money = count_money.replace(/,/g, '');
        }
        var date = $('input[name="ProfileForm[date]"]').val();
        $.ajax({
            url: '/core/profile',
            method: 'post',
            dataType: 'json',
            data:{
                fname:fname,
                lname:lname,
                status:status,
                rate:rate,
                country:country,
                city:city,
                about:about,
                tw:tw,
                fb:fb,
                ln:ln,
                inst:inst,
                gg:gg,
                email:email,
                skype:skype,
                phone:phone,
                zip:zip,
                count_money:count_money,
                is_first:is_first,
                date:date
            },
            success: function(response){
                if(response.is_first == 1){
                    window.location.href = '/departments/business';
                }else{
                    window.open('/user/social/shared-profile?id='+response.id+'', '_blank');
                }
               // $('.form_saved').show();
              //  window.location.href = '/departments/business';
            }
        })
    })

    $(document).on('change', '.shows', function(){
        var name = $(this).attr('name');
        var value = $(this).prop('checked');
        $.ajax({
            url: '/core/show',
            dataType: 'json',
            type: 'post',
            data: {name:name, value:value},
            success:function(){
                if(name == 'show_test_result'){
                    if(value == false){
                        $('.result_btn').removeClass('btn-primary');
                    }else{
                        $('.result_btn').addClass('btn-primary');
                    }
                }else if(name == 'show_contacts'){
                    if(value == false){
                        $('.contact_show').hide();
                        $('.contact_not_show').show();
                    }else{
                        $('.contact_show').show();
                        $('.contact_not_show').hide();
                    }
                }else if(name == 'show_socials'){
                    if(value == false){
                        $('.socials_show').hide();
                        $('.socials_not_show').show();
                    }else{
                        $('.socials_show').show();
                        $('.socials_not_show').hide();
                    }
                }
            }
        })
    });

    $('#edit-goal').on('click', function(){
        if(!$(this).hasClass('disabled')) {
            var goal_count_money = $('.goal-count_money');
            var count_money = goal_count_money.find('.form-control').attr('data-value');
            goal_count_money.html('<input type="text" name="ProfileForm[count_money]" class="form-control" value="' + count_money + '">')
            $('input[name="ProfileForm[count_money]"]').mask('000,000,000,000,000', {reverse: true});
            var goal_date = $('.goal-date');
            var date = goal_date.find('.form-control').attr('data-value');
            goal_date.html('<input type="text" name="ProfileForm[date]" class="form-control" value="' + date + '">');
            $(this).addClass('disabled');
        }
    });

    $(document).on('click', '.change_pass', function(){

        var oldpass = $('input.old_pass').val();
        var newpass = $('input.new_pass').val();
        var confpass = $('input.conf_pass').val();

        if(newpass != confpass){
            alert('Passwords is not match');
        }else {
            $.ajax({
                url: '/core/changepass',
                type: 'post',
                dataType: 'json',
                data: {oldpass: oldpass, newpass:newpass},
                success: function (response) {
                    if (response.error == false) {
                        alert('Password changed');
                    }else{
                        alert('Enter a valid password');
                    }
                }
            })
        }

    })

    $('.share_social').on('click', function(e){
        e.preventDefault();
    })


    $('.result_btn').on('click', function(e){
        e.preventDefault();
        document.location.href = '/tests/result'
    })

    $(document).on('click', '.mail_check', function(){
        if(confirm('You login will changed')){
            $(this).removeClass('mail_check');
        }else{
            return false;
        }
    })


    $('.sel2').selectpicker({

    });

    $('div.sel2').css('width', '100%');


    $('select.lang_name').on('change', function(){
        $(this).closest('div.lang_name').find('.start').hide();
    })
    $('select.skill_year').on('change', function(){
        $(this).closest('div.skill_year').find('.start').hide();
    })
    $('select.lang_skill').on('change', function(){
        $(this).closest('div.lang_skill').find('.start').hide();
    })
    $('select.country').on('change', function(){
        $(this).closest('div.country').find('.start').hide();
        $(this).children('.start').hide();

    })

    $(document).on('change', '.servises select.specialization', function(){
        $(this).closest('div.specialization').find('.start').hide();
        var id = $(this).val();
        var parent = $(this);
        $.ajax({
            url: '/core/gettaskfromspec',
            type: 'post',
            dataType: 'json',
            data:{id:id},
            success: function(response){
                if(response.error == false){
                    var select_task = parent.closest('.form-group').find('.select_task');
                    select_task.html(response.html);
                    parent.closest('.form-group').find('div.select_task').children('button').addClass('disabled');
                }

            }
        })
    })

    $(document).on('change', 'select.lang_name', function(){
        $(this).closest('div.form-group').find('.disabled').removeClass('disabled');
        $(this).closest('div.form-group').find('select.lang_skill').attr('disabled', false);
    })

    $(document).on('click', '.change_status', function(e){
        var new_status = $('input.status').val();
        if(new_status != '') {
            $.ajax({
                url: '/core/updstatus',
                data: {status: new_status},
                type: 'post',
                dataType: 'json',
                success: function () {
                    $('div.status a').text(new_status);
                }
            });
        }
    });
    $(document).on('click', '.change_rate', function(e){
        var new_rate = $('input.rate').val();
        if(new_rate != '') {
            $.ajax({
                url: '/core/updrate',
                data: {rate: new_rate},
                type: 'post',
                dataType: 'json',
                success: function () {
                    $('div.rate-h a').text('Rate/h: ' + new_rate);
                }
            });
        }
    });


    $(document).on("focusout", "input.skill_name", function () {
        if($(this).val() == '') {
            $(this).closest('.form-group').find('select.skill_year').attr('disabled', true);
            $(this).closest('.form-group').find('div.skill_year').children('button').addClass('disabled');
        }else{
            $(this).closest('.form-group').find('select.skill_year').attr('disabled', false);
            $(this).closest('.form-group').find('div.skill_year').children('button').removeClass('disabled');
        }
    });

    function renderMulti(el){


        $(".dropdown-content").hide();
        // $trigger.parents('.dropdown-toggle').next('.dropdown-content').hide();
        $('.caret .fa').removeClass('fa-angle-up').addClass('fa-angle-down');
        if(el.next('.dropdown-content').is(":visible")){
            if(el.hasClass('task')){
                renderNewTask(el);
            }else{
                renderNewField(el);
            }

            el.next('.dropdown-content').hide();
            el.find('.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
        }else{
            el.find('.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
            el.next('.dropdown-content').show();
            $(".services .service .multiselect .btn.info").popover({
                placement:"top"
            });
        }
        setTimeout(function(){
            $('.services .service input.form-control[data-key="rate"]').inputmask({
                "mask": "9",
                "repeat": 3,
                "greedy": false,
            }); // 
        },500);
                setTimeout(function(){
            $.each($('.dropdown-menu.inner'),function(){
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });
        },400);
    }

    function renderNewField(_this){
        var specialization = [];
        var i = 0;
        that = null;
        dep = null;
        _this.closest('.multiselect').find('input[type=checkbox]').each(function(){
            if($(this).prop('checked') == true && !$(this).closest('li').hasClass('spec-selected')){
                specialization[i] = $(this).attr('data-specid');
                that = $(this);
                i++;
                dep = $(this).closest('.panel-group').attr('data-department');
            }
        })

        $.ajax({
            url: '/core/add-multi-specialization',
            data: {spec:specialization, dep:dep},
            dataType: 'json',
            type: 'post',
            success: function(response){
                if(that != null && dep != null) {
                    that.closest('.service').html(response.html);
                }
                $('.sel2').selectpicker({});
                $('input[type=checkbox]').uniform();
                setTimeout(function(){
                    $('.services .service input.form-control[data-key="rate"]').inputmask({
                        "mask": "9",
                        "repeat": 3,
                        "greedy": false,
                    }); // 
                },500);
                        setTimeout(function(){
            $.each($('.dropdown-menu.inner'),function(){
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });
        },400);
            }
        })
    }

    function renderNewTask(_this){
        var tasks = [];
        that2 = null;
        dep2 = null;
        sspec = null;
        _this.closest('.multiselect').find('input[type=checkbox]').each(function(){
            if($(this).prop('checked') == true && !$(this).closest('li').hasClass('task-selected')){
                tasks[i] = $(this).attr('data-task_id');
                that2 = $(this);
                i++;
                dep2 = $(this).closest('.panel-group').attr('data-department');
                sspec = $(this).closest('.dynamic-block').find('.selected-specialization-name').attr('data-id');
            }
        })

        $.ajax({
            url: '/core/add-multi-task',
            data: {tasks:tasks, dep:dep2, spec:sspec},
            dataType: 'json',
            type: 'post',
            success: function(response){
                if(that2 != null && dep2 != null && sspec != null) {
                    that2.closest('.service').html(response.html);
                }
                $('.sel2').selectpicker({});
                $('input[type=checkbox]').uniform();
                setTimeout(function(){
                    $('.services .service input.form-control[data-key="rate"]').inputmask({
                        "mask": "9",
                        "repeat": 3,
                        "greedy": false,
                    }); // 
                },500);
                        setTimeout(function(){
            $.each($('.dropdown-menu.inner'),function(){
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });
        },400);
            }
        })

    }

    function checkDo(_this_){
        var dep = _this_.closest('.panel-group').attr('data-department');
        if(_this_.hasClass('active')){
            var check = 0;
        }else{
            var check = 1;
        }
        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content"),
            check: check,
            dep: dep
        }
        $.ajax({
            url: '/core/change-do-department',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(response){

            }
        })
    }

    function checkShow(_this_){
        var dep = _this_.closest('.panel-group').attr('data-department');
        if(_this_.closest('.panel-group').find('.panel-collapse').hasClass('in') || _this_.hasClass('in')){
            var show = 0;
        }else{
            var show = 1;
        }

        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content"),
            show: show,
            dep: dep
        }

        $.ajax({
            url: '/core/change-show-department',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(response){

            }
        })
    }


    function checkSell(_this_){
        var dep = _this_.closest('.panel-group').attr('data-department');
        if(_this_.hasClass('active')){
            var check = 0;
        }else{
            var check = 1;
        }
        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content"),
            check: check,
            dep: dep
        }
        $.ajax({
            url: '/core/change-sell-department',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(response){

            }
        })
    }
    $(".services .accordion .panel .panel-title .accordion-toggle").click(function(e){
        var target = $(e.target);
        if (target.is("a.check"))
            return;
       checkShow($(this));
    });

    $(document).on('click', '.service-wrapper .delete-ajax-serv', function(e){
        e.preventDefault();
        var id = $(this).closest('div.dynamic-block').data('id');
        var __this__ = $(this);
        var dep = $(this).closest('.panel-group').attr('data-department');
        var data = {
            command : 'delete',
            id:id,
            dep: dep
        };
        $.ajax({
            url: '/core/service-ajax',
            data: data,
            dataType: 'json',
            type: 'post',
            async: 'false',
            success: function(response){
                __this__.closest('.panel-group').find('.service').html(response.html2);
                $('.sel2').selectpicker({});
                setTimeout(function(){
                    $('.services .service input.form-control[data-key="rate"]').inputmask({
                        "mask": "9",
                        "repeat": 3,
                        "greedy": false,
                    }); // 
                },500);
                        setTimeout(function(){
            $.each($('.dropdown-menu.inner'),function(){
                var els = $(this).find('li');
                console.log(els.length);
                if(els.length > 8){
                    $(this).mCustomScrollbar({
                        setHeight: 252,
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }else{
                    $(this).mCustomScrollbar({
                        theme:"dark",
                        scrollbarPosition:"outside"
                    });  
                }
            });
        },400);
            }
        });
    });


})