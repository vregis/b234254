/**
 * Created by toozzapc2 on 18.01.2016.
 */

var staticTask = null;
function initTimeParse(){
    // $(".counter_users").on('shown.bs.collapse',function(){
    //     console.log("show counter");
    //     $("#btn-delegate, #btn-delegate+button.btn-success").addClass('static disabled');
    //     $("#btn-delegate+button.btn-success").removeClass('active');
    // }).on('hide.bs.collapse',function(){
    //     $("#btn-delegate, #btn-delegate+button.btn-success").removeClass('static disabled');
    //     $("#btn-delegate+button.btn-success").addClass('active');
    //     console.log("hide counter");
    // });
    $("#task .gant_avatar").popover({
        container: $("#task"),
        placement: "bottom",
        html:true,
        trigger:"hover",
        template:'<div class="popover gant_av" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
    }); 
    // var text = $("#input-time").val();
    // console.log(text.indexOf('h'));
    // if(text.indexOf('h') == -1){
    //    $("#input-time").val($("#input-time").val()+"h");
    // }
    console.log($("#input-time").val());
    $("#input-time").on('keypress',function(event){
       // Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57 ) {
                event.preventDefault(); 
            }   
        }
        console.log($("#input-time").val());
    }).on('focus',function(){
        text = $("#input-time").val();
        text = text.replace('h','');
        $("#input-time").val(text);
    }).on('blur',function(){
        text = $("#input-time").val();
        if(text.indexOf('h') == -1){
            $("#input-time").val(text+"h");
            console.log("FUCK YEAH " + text.indexOf('h'));
        }
    });
}
function Task(task_user_id, is_my, is_custom) {
    var thisTask = this;
    if(staticTask == null) {
        staticTask = thisTask;
    }
    set_handler_confirn();
    $("#delegate_active_users a img").click(function(){
        $("#active-user-info").show();
        var usrHtml = $(this).parent().attr('data-name') +", "+$(this).parent().attr('data-location') +"<br/> "+$(this).parent().attr('data-date') +", "+$(this).parent().attr('data-rate');
        // alert(usrHtml);
        $("#active-user-info").html(usrHtml);
    });
    $("#active-user-info").on('click',function(){
        $("#delegate").collapse('toggle');
    });
    $('input[type="radio"][disabled]').click(function(e){
        e.preventDefault();
    });
    $('.task-body .block.desc .content').mCustomScrollbar({
        theme:"dark",
        axis:"y",
        setHeight:285,
        scrollbarPosition: "outside"
    });
    initTimeParse();
    // var offerall_btn = $('.offerall-btn');
    // offerall_btn.off();
    // offerall_btn.on('click', function(){
    //     $('.delegate-select').each(function() {
    //         $(this).addClass("active");
    //         $(".make-offer").addClass('active');
    //     });
        // set_cancel_delegate_users($('#cancel_delegate_users'), response.html_cancel_users);
        // set_handler_confirn();
    // });


    // var cancelall_btn = $('.cancelall-btn');
    // cancelall_btn.off();
    // cancelall_btn.on('click', function(){
    //     $('.cancel-delegate-select').each(function() {
    //         $(this).addClass("active");
    //         $(".cancel-offer").addClass('active');
    //     });
    // });
    function set_log(_this,html) {
        if(_this != undefined) {
            _this.html(html);
        }
        $('.task-body .block.chat .scroller').mCustomScrollbar({
            theme:"dark",
            axis:"y",
            setHeight:255
        });
        $(".page-content") .mCustomScrollbar("destroy");
        setTimeout(function(){
            $('.page-content').mCustomScrollbar({
                setHeight: $('.page-content').css('minHeight'),
                theme:"dark"
            });
            initTimeParse();
        },300);
    }

    function getTime() {
        var input_time = '';
        if($('input#input-time').length > 0) {
            input_time = $('input#input-time').val();
        }
        else {
            input_time = parseInt($('#input-time').html());
        }
        return input_time;
    }
    function getPrice() {
        var input_price = '';
        if($('input#input-price').length > 0) {
            input_price = $('input#input-price').val();
        }
        else {
            input_price = parseInt($('#input-price').html());
        }
        return input_price;
    }

    function getRate() {
        var input_time = getTime();
        var input_price = getPrice();
        input_price = parseInt(input_price);
        var rate = 0;
        if(input_time > 0 && input_price > 0) {
            rate = input_price/input_time;
        }
        return rate;
    }

    function set_delegate_users(_this, html) {
        _this.html(html);
        // var delegate_delegate = $('.delegate-select');
        // delegate_delegate.off();
        // delegate_delegate.on('click', function(){
        //     $(this).toggleClass("active");

        //     $(".make-offer").addClass('active');
        //     if($('.delegate-select.active').length == 0){
        //         $(".make-offer").removeClass('active');
        //     }
        // });
        initTimeParse();
    }
    function set_cancel_delegate_users(_this, html) {
        if(_this != undefined) {
            _this.html(html);
            if(html == 'none') {
                _this.html('');
            }
        }
        // var cancel_delegate_delegate = $('.cancel-delegate-select');
        // cancel_delegate_delegate.off();
        // cancel_delegate_delegate.on('click', function(){
        //     $(this).toggleClass("active");

        //     $(".cancel-offer").addClass('active');
        //     if($('.cancel-delegate-select.active').length == 0){
        //         $(".cancel-offer").removeClass('active');
        //     }
        // });
var cancel_offer = $('.cancel-delegate-select');
    cancel_offer.off();
    cancel_offer.on('click', function(){
        // alert('sadasda');
        var ids = [];
        var names = "";
        var i=0;
        // $('.cancel-delegate-select').each(function() {
        //     if($(this).hasClass("active")) {
                ids.push($(this).attr('data-id'));
                // if(i != 0) {
                //     names += ", ";
                // }
                names += $(this).closest('.user-row').find('.field-name').html();
                // i++;
        //     }
        // });

        if(ids.length > 0) {
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command: 'cancel_delegate',
                task_user_id: task_user_id,
                cancel_delegate_user_ids: ids,
            };
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (!response.error) {
                        // toastr["success"]("Cancel offers: " + names, "Success");
                        set_delegate_users($('#delegate_users'), response.html_users);
                        set_cancel_delegate_users($('#cancel_delegate_users'), response.html_cancel_users);
                        set_delegate_active_users($('#delegate_active_users'), response.html_active_users);
                        set_log($('#taskUserLogs'), response.html_task_user_logs);
                        // set_handler_confirn();
                        // if(response.html_active_users == 'none' || response.html_user_request == "undefined"){
                        //     // Сюда впили переход на серч
                        //     $("#offered-block").removeClass('active');
                        //     $("#search-block").addClass('active');
                        //     $(".dropmenu1.status").popover('show').on('shown.bs.popover',function(){
                        //         // $("#status-menu").show();
                        //         $("#btn-offered-block .label").remove();
                        //         $("a[href='#search-block']").tab('show');
                        //         showLi(0);
                        //         // $(".dropmenu1.status").popover('destroy');
                        //     }).popover('hide');
                        // }
                    }
                }
            });
            // $(this).removeClass('active');
        }
    });
    }

    getus(task_user_id);

    function set_delegate_active_users(_this, html) {
        if(html != undefined) {
            _this.html(html);
            if(html == 'none') {
                _this.html('');
            }
        }

        var btn_message = $('#btn-tab-message');
        if($('#delegate_active_users').html() == 0) {
            if($('#portlet_tab2').hasClass('active')) {
                $('#btn-tab-note').click();
            }
            btn_message.addClass('disabled');
            btn_message.addClass('static');
        }else {
            btn_message.removeClass('disabled');
            btn_message.removeClass('static');
        }
        if(is_my) {
            var select_delegate = $('.select-delegate');
            select_delegate.off();
            select_delegate.on('click', function () {
                var data = {
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    command: 'select_delegate',
                    task_user_id: task_user_id,
                    delegate_task_id: $(this).attr('data-delegate_task_id'),
                    is_my: is_my
                };
                $.ajax({
                    url: '/departments/tool-ajax',
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function (response) {
                        if (!response.error) {

                            handleRequestMessage(response.html);
                            if (response.html_active_users) {
                                set_delegate_active_users($('#delegate_active_users'), response.html_active_users);
                                set_log($('#taskUserLogs'), response.html_task_user_logs);
                            }
                            if (response.all_new_message) {
                                $('#badge-chat').html(response.all_new_message.count);
                            } else {
                                $('#badge-chat').html('');
                            }
                            $("#btn-tab-message").click();
                            initTimeParse();
                            $("#delegate_active_users a img").click(function(){
                                $("#active-user-info").show();
                                var usrHtml = $(this).parent().attr('data-name') +", "+$(this).parent().attr('data-location') +"<br/> "+$(this).parent().attr('data-date') +", "+$(this).parent().attr('data-rate');
                                // alert(usrHtml);
                                $("#active-user-info").html(usrHtml);
                            });
                        }
                    }
                });
            });
        }
    }
    if(!is_my) {
        var select_delegate = $('.select-delegate');
        select_delegate.off();
        select_delegate.on('click',function() {
            $("#btn-tab-message").click();
        });
    }
    set_delegate_active_users($('#delegate_active_users'));
    
    function set_handler_confirn() {
        var confirn = $('.confirn');
        confirn.off();
        confirn.on('click', function(e){
            if(confirn.hasClass('confirn-btn')){
                console.log("click to cancel");
                if($(this).hasClass('restrt')){
                    var title = 'Are you sure you want to restart task?';
                }else{
                    var title = 'Are you sure you want to cancel the delegated task?';
                }
                confirn.confirmation({
                    title: title,
                    placement: "bottom",
                    btnOkClass: "btn btn-success",
                    btnCancelClass: "btn btn-danger",
                    btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Yes',
                    onConfirm: function (event) {
                        var name = confirn.closest('.user-row').find('.field-name').html();
                        var data = {
                            _csrf: $("meta[name=csrf-token]").attr("content"),
                            command : 'confirn',
                            delegate_task_id: confirn.attr('data-delegate_task_id'),
                            status: confirn.attr('data-status')
                        };
                        $.ajax({
                            url: '/departments/tool-ajax',
                            type: 'post',
                            dataType: 'json',
                            data: data,
                            success: function(response){
                                if(!response.error) {
                                    var counter = $('.counter_users');
                                    set_counter_offer(counter, response.html);
                                    set_cancel_delegate_users($('#cancel_delegate_users'), response.html_cancel_users);
                                    set_delegate_active_users($('#delegate_active_users'), response.html_active_users);

                                    if(response.html_action_panel) {
                                        // counter.removeClass('in');
                                        $('.counter-offer-row').each(function(){
                                            $(this).remove();
                                        });
                                        set_action_panel($('#action_panel'), response.html_action_panel);
                                        set_log($('#taskUserLogs'), response.html_task_user_logs);
                                        initTimeParse();
                                    }
                                    initTimeParse();
                                }
                            }
                        });
                        confirn.confirmation('destroy');
                    },
                    onCancel: function (event) {
                        confirn.confirmation('destroy');
                        return false;
                    }
                });
                $(this).confirmation('show');
                e.preventDefault();
                return false;
                initTimeParse();
                // if (!confirm("Approve cancel")){
                //     return false;
                // }
            }

            var name = $(this).closest('.user-row').find('.field-name').html();

            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command : 'confirn',
                delegate_task_id: $(this).attr('data-delegate_task_id'),
                status: $(this).attr('data-status')
            };
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(response){
                    if(!response.error) {
                        var counter = $('.counter_users');
                        set_counter_offer(counter, response.html);
                        set_cancel_delegate_users($('#cancel_delegate_users'), response.html_cancel_users);
                        set_delegate_active_users($('#delegate_active_users'), response.html_active_users);
                        initTimeParse();
                        if(response.html_action_panel) {
                            counter.removeClass('in');
                            $('.counter-offer-row').each(function(){
                                $(this).remove();
                            });
                            set_action_panel($('#action_panel'), response.html_action_panel);
                            set_log($('#taskUserLogs'), response.html_task_user_logs);
                        initTimeParse();
                        var payment_paypal = $('#payment-paypal');
                            if(payment_paypal.length) {
                                payment_paypal.popover({placement: 'bottom auto', content:"Please pay delegated task"});
                                payment_paypal.popover('show');

                                setTimeout(function() {payment_paypal.popover('destroy');payment_paypal.removeAttr('data-toggle').off();},3000);
                            }
                        }
                        initTimeParse();

                    }
                    alert("accept");
                    initTimeParse();
                }
            });
        });
    }
    function set_action_panel(_this,html) {
        if(html != undefined) {
            _this.html(html);
            initTimeParse();
        }
        var input_time = $('#input-time');
        input_time.off();
        input_time.on('change', function(){
            if(is_my) {
                get_delegate_users();
            }
        });
        var input_price = $('#input-price');
        input_price.off();
        input_price.on('change', function(){
            if(is_my) {
                get_delegate_users();
            }
        });

        var collapsed_btn_delegate = $('#btn-delegate');
        collapsed_btn_delegate.off();
        collapsed_btn_delegate.on('click', function(e){
            if(!$(this).hasClass('disabled')) {
                var this_confirmation = $(this);
                if (getPrice() == 0 && !$('#delegate').hasClass('in')) {
                    this_confirmation.confirmation({
                        title: "Are you trying to delegate a task without payment?",
                        placement: "bottom",
                        btnOkClass: "btn btn-success",
                        btnCancelClass: "btn btn-danger",
                        btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Yes',
                        onConfirm: function (event) {
                            // collapsed_btn_delegate.attr('data-toggle','collapse');
                            $("#delegate").collapse('toggle');
                            get_delegate_users();
                            this_confirmation.confirmation('destroy');
                            initTimeParse();
                        },
                        onCancel: function (event) {
                            this_confirmation.confirmation('destroy');
                            return false;
                        }
                    });
                    this_confirmation.confirmation('show');
                    e.preventDefault();
                } else {
                    this_confirmation.confirmation('destroy');
                    $("#delegate").collapse('toggle');
                    if (!$('#delegate').hasClass('in')) {
                        get_delegate_users();
                    }
                }
            }
        });

        var datepicker = $("#datepicker");
        datepicker.off();
        datepicker.on('show.bs.collapse',function(){
            $("#task .collapse").not($(this)).collapse('hide');
            $(".task-title .item.date .icon").addClass('active');
            $("#datepicker .arrow").css({'left':$(".task-title .item.date").position().left});
        });
        datepicker.on('hidden.bs.collapse',function(){
            $(".task-title .item.date .icon").removeClass('active');
        });
        var counter = $(".counter_users");
        counter.off();
        counter.on('show.bs.collapse',function(){
            // $(".counter_users_users").mCustomScrollbar({
            //     theme:"dark",
            //     axis:"y",
            //     setHeight:245
            // });
            $(".counter-offer-row td div[data-toggle='popover']").popover({
                trigger:"hover",
                html:true,
                placement:"top",
                template:'<div class="popover offer-name" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
            });
            $("#task .collapse").not($(this)).collapse('hide');
            $(".btn[aria-controls='counter']").addClass('active');
            $(".counter_users .arrow").css({'left':$(".btn[aria-controls='counter']").position().left + 25});
        });
        counter.on('hide.bs.collapse',function(){
            $(".btn[aria-controls='counter']").removeClass('active');
        });
        $('#get_money').off();
        // пока убрали
        if($("#input-price").text() != 0){
            $('#get_money[data-toggle="popover"]').popover({
                placement: 'bottom',
                html:true,
                trigger:"hover",
                content:"Payment has been reserved"
            });
        }
        // setTimeout(function(){$('#get_money[data-toggle="popover"]').popover('show');}, 500);
        
        $('#get_money_confirm').on('click', function(e){
            e.preventDefault();
            // if(getPrice() == '' || getPrice() == 0){
            //     return false;
            // }
            $('.money').text(getPrice());
            $(this).popover({
                placement:"bottom",
                html:true,
                trigger:"click",
                content:$("#payment-form")
            });
            $(this).popover('show');
            initTimeParse();
        });

        $('#get_money_confirm').on('show.bs.popover',function(e){
            $("#payment-form").show();
        });
        var delegate = $("#delegate");
        delegate.off();
        delegate.on('shown.bs.collapse',function(){
            $("#task .collapse").not($(this)).collapse('hide');
            $(".btn[aria-controls='delegate']").addClass('active');
            $("#delegate .arrow").css({'left':$(".btn[aria-controls='delegate']").position().left+25});
            $(".invite-by-email").popover({
                placement:"auto top",
                html:true,
                trigger:"click",
                content:$("#invite-form"),
                // container:$("#delegate"),
            });
            $("#btn-delegate").next().addClass('disabled');
            $("#btn-delegate").prev('.non-dis').addClass('disabled');
            
            $(".task-body .block.desc .footer .btn").on('shown.bs.tab',function(){
                $(".tab-content > .tab-pane .item").popover({
                    placement:"auto top",
                    html:true,
                    trigger:"click",
                });
            });
            $(".advanced-search-btn").popover({
                placement:"auto top",
                html:true,
                trigger:"click",
                content:$("#advanced-search-form"),
                // container:$("#delegate"),
            });
            $(document).on('click', '.to-chat', function(){
                delegate.collapse('toggle');
                $("#btn-delegate").removeClass('active');
                $("#active-user-info").show();
                $("#delegate_active_users a img").removeClass('active');
                $("#delegate_active_users a[data-delegate_task_id='"+$(this).attr('data-delegate_task_id')+"'] img").addClass('active');
                var usrHtml = $(this).attr('data-name') +", "+$(this).attr('data-location') +"<br/> "+$(this).attr('data-date') +", "+$(this).attr('data-rate');
                $("#active-user-info").html(usrHtml);
            });

            // $(".offerall-btn").click(function(){
            //     // $(this).toggleClass('active');
            //     if($(this).hasClass('active')){
            //         $(".offerall.delegate-task").addClass('active');
            //     }else{
            //         $(".offerall.delegate-task").removeClass('active');
            //     }
            //     $(".offerall.delegate-task").toggleClass('active');
            // });

            $(".invite-by-email").on('shown.bs.popover',function(){
                $(".advanced-search-btn").popover('hide');
                $("#invite-form").show();
               
            });
            $(".advanced-search-btn").on('shown.bs.popover',function(){
                $(".invite-by-email").popover('hide');
                $("#advanced-search-form").show();
                $('#advanced-search-form .selectpicker').selectpicker();
                $.each($('#advanced-search-form .dropdown-menu.inner'),function(){
                    var els = $(this).find('li');
                    if(els.length > 8){
                        $(this).mCustomScrollbar({
                            setHeight: 252,
                            theme:"dark",
                            scrollbarPosition:"outside",
                            live: true
                        });  
                    }else{
                        $(this).mCustomScrollbar({
                            theme:"dark",
                            scrollbarPosition:"outside",
                            live: true
                        });  
                    }
                    $(this).mCustomScrollbar('update');
                });
                $("body").on("click", function(e){
                    $('.invite-by-email, .advanced-search-btn').each(function () {
                        //the 'is' for buttons that trigger popups
                        //the 'has' for icons within a button that triggers a popup
                        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('#task .popover').has(e.target).length === 0) {
                            $(this).popover('hide');
                        }
                    });
                });
            });
            set_handler_confirn();
        });
        delegate.on('hide.bs.collapse',function(){
            $(".btn[aria-controls='delegate']").removeClass('active');
            $("#btn-delegate").next().removeClass('disabled');
            $("#btn-delegate").prev('.non-dis').removeClass('disabled');
        });

        function accept() {
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command : 'offer',
                task_user_id: task_user_id,
                start: $("#taskuser-start").val(),
                end: $("#taskuser-end").val(),
                time: getTime(),
                price: getPrice()
            };
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(response){
                    if(!response.error) {
                        if(response.html_action_panel) {
                            set_action_panel($('#action_panel'), response.html_action_panel);
                            set_log($('#taskUserLogs'), response.html_task_user_logs);
                            initTimeParse();
                        }
                    }
                }
            });
        }

        var btn_accept = $('#btn-accept');
        btn_accept.unbind();
        btn_accept.bind('click', function(e){

            if(getPrice() == 0) {
                $(this).confirmation({
                    title: "Are you trying to accept the task without payment?",
                    placement: "bottom",
                    btnOkClass: "btn btn-success huinya-1",
                    btnCancelClass: "btn btn-danger huinya-2",
                    btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Yes',
                    btnCancelLabel: '<i class="icon-times icon-white"></i> No',
                    onConfirm: function (event) {
                        // collapsed_btn_delegate.attr('data-toggle','collapse');
                        accept();
                        $(this).confirmation('destroy');
                    },
                    onCancel: function (event) {
                        return false;
                    }
                });
                $(this).confirmation('show');
            }else {
                accept();
                $(this).confirmation('destroy');
            }
            e.preventDefault();
        });

        if(is_my) {
            var payment_btn = $(".payment-btn");
            payment_btn.off();
            payment_btn.on('click', function () {
                if ($(this).hasClass('disabled')) {
                    return false;
                }
                var sum = getPrice();
                if (sum < 1) {
                    alert('0'); //TODO delete alert
                } else {
                    var name = $('.name').text();
                    $('input[name=name]').val(name);
                    $('input[name=sum]').val(sum);
                    $('form#paypal-form').submit();
                }
            });
        }

        var btn_pay = $('#btn-pay');
        btn_pay.off();
        btn_pay.on('click', function(){
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command: 'pay',
                task_user_id: task_user_id
            };
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(response){
                    if(!response.error) {
                        set_action_panel($('#action_panel'), response.html);
                        initTimeParse();
                    }
                }
            });
        });
        var btn_receive = $('#btn-receive');
        btn_receive.off();
        btn_receive.on('click', function(){


        var pp_login = $('input[name=paypal_login]').val();
        var pp_loginre = $('input[name=paypal_loginre]').val();
            if(pp_login != pp_loginre){
                alert('emails is not match');
                return false;
            }
            if(pp_login == ''){
                alert("cannot be empty");
                return false;
            }

            var sum = getPrice();

            $.ajax({
                url: '/tasks/paypal/createpayout',
                data: {login:pp_login, sum:sum},
                type: 'post',
                dataType: 'json',
                success: function(response){
                    btn_receive.popover({
                        placement: "bottom",
                        trigger:"click",
                        html:true,
                        content:response.msg
                    }).popover('show');
                    // setTimeout(function(){btn_receive.popover('destroy');},1000);
                    //alert(response.msg);
                    if(response.error == false) {
                        var data = {
                            _csrf: $("meta[name=csrf-token]").attr("content"),
                            command: 'receive',
                            task_user_id: task_user_id
                        };
                        $.ajax({
                            url: '/departments/tool-ajax',
                            type: 'post',
                            dataType: 'json',
                            data: data,
                            success: function (response) {
                                if (!response.error) {
                                    setTimeout(function () {
                                        location.reload();
                                        initTimeParse();
                                    }, 2000);
                                    
                                    //set_action_panel($('#action_panel'), response.html);
                                }
                            }
                        });
                    }
                }
            })
        });

        var restart = $('#restart');
        restart.off();
        restart.on('click', function(){
        console.log("click to restart");
        restart.confirmation({
            title: 'Are you sure you want to restart task?',
            placement: "bottom",
            btnOkClass: "btn btn-success",
            btnCancelClass: "btn btn-danger",
            btnOkLabel: '<i class="icon-ok-sign icon-white"></i> Yes',
            onConfirm: function (event) {
                var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command : 'restart',
                task_user_id: task_user_id
                };
                $.ajax({
                    url: '/departments/tool-ajax',
                    type: 'post',
                    dataType: 'json',
                    data: data,
                    success: function(response){
                        if(!response.error) {
                            set_action_panel($('#action_panel'), response.html);
                            set_log($('#taskUserLogs'), response.html_task_user_logs);
                            initTimeParse();
                        }
                    }
                });
                restart.confirmation('destroy');
            },
            onCancel: function (event) {
                restart.confirmation('destroy');
                return false;
            }
        });

            $(this).confirmation('show');
            e.preventDefault();
            return false;
            initTimeParse();
        });
        set_handler_confirn();

        $("#startDate").datepicker( "refresh" );
        $("#endDate").datepicker( "refresh" );

        var payment_paypal = $('#payment-paypal');
        if(payment_paypal.length) {
            payment_paypal.popover({placement: 'bottom auto', content:"Please pay delegated task"});
            payment_paypal.popover('show');
            var _del_id = $('.delegate-task-id').attr('data-delegate_task_id');
            $.ajax({
                url: '/departments/business/change-show',
                type: 'post',
                data: {del_id:_del_id},
                dataType: 'json',
                success: function(){

                }
            })
            setTimeout(function() {payment_paypal.popover('hide')},3000);
        }
        initTimeParse();
    }

    function set_counter_offer(_this,html) {
        if(html != undefined) {
            _this.html(html);

            if(html == 'none') {
                _this.html('');
                _this.removeClass('in');
                $('.counter-offer-row').each(function () {
                    $(this).remove();
                });
            }
        }
        set_handler_confirn();
    }

    var input_helpful = $('input[name=Helpful]');
    input_helpful.off();
    input_helpful.on('click',function() {
        if(!$(this).is('[disabled]')) {
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: {
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    command: 'set_helpful',
                    task_user_id: task_user_id,
                    helpful: $(this).val()
                },
                success: function (response) {
                    input_helpful.attr('disabled', 'disabled');
                    input_helpful.closest('.b-page-checkbox-wrap').addClass('disabled off');
                }
            });
        }
    });

    // var make_offer = $('.offerall');
    // make_offer.off();
    $(document).on('click','.offerall', function(){
        // alert('test');
        var ids = [];
        var names = "";
        var i=0;
        // $('.delegate-select').each(function() {
        //     if($(this).hasClass("active")) {
                ids.push($(this).attr('data-id'));
                // if(i != 0) {
                //     names += ", ";
                // }
                names += $(this).closest('.user-row').find('.field-name').html();
        //         i++;
        //     }
        // });

        if(ids.length > 0) {
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command: 'delegate',
                task_user_id: task_user_id,
                delegate_user_ids: ids,
                rate: getRate(),
                time: getTime(),
                price: getPrice(),
                start: $("#taskuser-start").val(),
                end: $("#taskuser-end").val()
            };
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (!response.error) {
                        // toastr["success"]("Make offers: " + names, "Success");
                        set_delegate_users($('#delegate_users'), response.html_users);
                        set_counter_offer($('.counter_users'), response.html);
                       
                        set_cancel_delegate_users($('#cancel_delegate_users'), response.html_cancel_users);
                        set_delegate_active_users($('#delegate_active_users'), response.html_active_users);
                        set_log($('#taskUserLogs'), response.html_task_user_logs);
                         set_handler_confirn();

                        console.log("make offer");
                    }
                }
            });
            $(this).removeClass('active');
        }
        initTimeParse();
    });
    var cancel_offer = $('.cancel-delegate-select');
    cancel_offer.off();
    cancel_offer.on('click', function(){
        // alert('sadasda');
        var ids = [];
        var names = "";
        var i=0;
        // $('.cancel-delegate-select').each(function() {
        //     if($(this).hasClass("active")) {
                ids.push($(this).attr('data-id'));
                // if(i != 0) {
                //     names += ", ";
                // }
                names += $(this).closest('.user-row').find('.field-name').html();
                // i++;
        //     }
        // });

        if(ids.length > 0) {
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command: 'cancel_delegate',
                task_user_id: task_user_id,
                cancel_delegate_user_ids: ids,
            };
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (!response.error) {
                        // toastr["success"]("Cancel offers: " + names, "Success");
                        set_delegate_users($('#delegate_users'), response.html_users);
                        set_cancel_delegate_users($('#cancel_delegate_users'), response.html_cancel_users);
                        set_delegate_active_users($('#delegate_active_users'), response.html_active_users);
                        set_log($('#taskUserLogs'), response.html_task_user_logs);
                        // set_handler_confirn();
                        // if(response.html_active_users == 'none' || response.html_user_request == "undefined"){
                        //     // Сюда впили переход на серч
                        //     $("#offered-block").removeClass('active');
                        //     $("#search-block").addClass('active');
                        //     $(".dropmenu1.status").popover('show').on('shown.bs.popover',function(){
                        //         // $("#status-menu").show();
                        //         $("#btn-offered-block .label").remove();
                        //         $("a[href='#search-block']").tab('show');
                        //         showLi(0);
                        //         // $(".dropmenu1.status").popover('destroy');
                        //     }).popover('hide');
                        // }
                    }
                }
            });
            // $(this).removeClass('active');
        }
    });

    function get_delegate_users() {
        var rate_start = 0;
        if($('#input-rate-start').length > 0) {
            rate_start = $('#input-rate-start').val();
        } else {
            rate_start = getRate() - 15;
            if(rate_start < 0) {
                rate_start = 0;
            }
        }
        var rate_end = 0;
        if($('#input-rate-end').length > 0) {
            rate_end = $('#input-rate-end').val();
        } else {
            rate_end = getRate() + 15;
        }
        var level = 0;
        if($('#select-level').length > 0) {
            level = $('#select-level').val();
        }
        var country = 0;
        if($('#select-country').length > 0) {
            country = $('#select-country').val();
        }
        var city = 0;
        if($('#input-city').length > 0) {
            city = $('#input-city').val();
        }
        var skills_ids = [];
        if($('#select-skills').length > 0) {
            skills_ids = $('#select-skills').val();
        }
        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content"),
            command: 'get_delegate_users_advanced',
            task_user_id: task_user_id,
            rate_start: rate_start,
            rate_end: rate_end,
            level: level,
            country: country,
            city: city,
            skills_ids: skills_ids,
            time: getTime(),
            price: getPrice(),
            count: 0,
            is_my: is_my
        };
        $.ajax({
            url: '/departments/tool-ajax',
            type: 'post',
            dataType: 'json',
            data: data,
            success: function(response){
                if(!response.error) {
                    set_delegate_users($('#delegate_users'),response.html);
                }
            }
        });
    }
    var advanced_send = $('#advanced-search-send');
    advanced_send.off();
    advanced_send.on('click',function(e) {
        get_delegate_users();
        $('.popover').each(function(){
            $(this).popover('hide');
        });
    });

    var advanced_send_task = $('#advanced-search-send-task');
    advanced_send_task.off();
    advanced_send_task.on('click',function(e) {
        get_delegate_users();
        $('.popover').each(function(){
            $(this).popover('hide');
        });
    });

    function unlockForm() {
        $('.popover').each(function(){
            $(this).popover('hide');
        });
        App.unblockUI('#invite-form');
    }
    var invite_send = $('#invite-form-send');
    invite_send.off();
    invite_send.on('click',function(e) {
        var email = $('#input-invite-email').val();
        var offer = $('#input-invite-offer').val();

        if(email != '' && offer != '') {
            App.blockUI({
                target: '#invite-form',
                animate: true
            });

            $.ajax({
                url: '/core/delegatebyemail',
                method: 'post',
                data: {email: email, offer: offer},
                dataType: 'json',
                success: function (response) {
                    if (response.error == true) {
                        $("#invite-modal .modal-body").text("Something wrong. Please try again");
                        $("#invite-modal").modal('show');
                        $("#invite-modal").on('shown.bs.modal',function(){
                            $("#invite-modal .modal-dialog").css({
                                'margin-top':$(window).height() / 2 - $("#invite-modal .modal-dialog").height() / 2
                            });
                            setTimeout(function(){
                                $("#invite-modal").modal('hide');
                                unlockForm();
                            }, 2000);
                        });
                    } else {
                        $(".invite-by-email").popover('hide');
                        $("#invite-modal .modal-body").text("Your invite has been sent");
                        $("#invite-modal").modal('show');
                        $("#invite-modal").on('shown.bs.modal',function(){
                            $("#invite-modal .modal-dialog").css({
                                'margin-top':$(window).height() / 2 - $("#invite-modal .modal-dialog").height() / 2
                            });
                            setTimeout(function(){
                                $("#invite-modal").modal('hide');
                                unlockForm();
                            }, 2000);
                        });
                    }
                }
            });
        }
    });
    set_delegate_active_users($('#delegate_active_users'));

    function check_status(is_timer) {
        if(is_timer == undefined) {
            is_timer = true;
        }
        if(is_timer) {
            var started = new Date().getTime();
        }
        var status = $('#status-delegate').attr('data-status');
        if(status == undefined) {
            status = 0;
        }
        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content"),
            command: 'check_status',
            task_user_id: $("#task").attr('data-task_user_id'),
            message_count: $(".task-user-message").length,
            status_delegate: status,
            delegate_tasks_count: $(".select-delegate").length,
            counter_offers_count: $(".counter-offer-row").length,
            is_active_chat: $('#portlet_tab2').hasClass('active'),
            is_my: is_my
        };
        $.ajax({
                method: "POST",
                url: '/departments/tool-ajax',
                dataType: 'json',
                data: data
            })
            .done(function (response) {
                if(!response.error) {
                    console.log(response);
                    $('.select-delegate').each(function () {
                        $(this).find('.badge').html('');
                    });
                    if (response.html_messages) {
                        handleRequestMessage(response.html_messages, true);
                        initTimeParse();
                    }
                    if (response.html_active_users) {
                        set_delegate_active_users($('#delegate_active_users'), response.html_active_users);
                        set_counter_offer($('.counter_users'), response.html_counter_offers);
                        initTimeParse();
                    }
                    if (response.html_action_panel) {
                        set_action_panel($('#action_panel'), response.html_action_panel);
                        set_delegate_users($('#delegate_users'), response.html_users);
                        set_cancel_delegate_users($('#cancel_delegate_users'), response.html_cancel_users);
                        set_counter_offer($('.counter_users'), response.html_counter_offers);
                        set_log($('#taskUserLogs'), response.html_task_user_logs);
                        initTimeParse();
                    }
                    if (response.html_counter_offers) {
                        set_counter_offer($('.counter_users'), response.html_counter_offers);
                        initTimeParse();
                    }
                    if (response.new_message) {
                        response.new_message.forEach(function (item) {
                            $('.select-delegate[data-delegate_task_id="' + item.delegate_task_id + '"]').find('.badge').html(item.count);
                        });
                        initTimeParse();
                    }
                    if (response.all_new_message) {
                        $('#badge-chat').html(response.all_new_message.count);
                    } else {
                        $('#badge-chat').html('');
                    }
                }
                else {
                    document.location.href='/departments/business';
                }
            })
            .always(function () {
                if(is_timer) {
                    var ended = new Date().getTime();
                    var milliseconds = ended - started;
                    if (milliseconds >= 0 && milliseconds < 100)
                        timeoutChat = 3000;
                    else if (milliseconds >= 100 && milliseconds < 200)
                        timeoutChat = 4000;
                    else if (milliseconds >= 200 && milliseconds < 300)
                        timeoutChat = 5000;
                    else if (milliseconds >= 300 && milliseconds < 400)
                        timeoutChat = 6000;
                    else if (milliseconds >= 500)
                        timeoutChat = 7000;
                    if (staticTask == thisTask) {
                        setTimeout(check_status, timeoutChat);
                    }
                }
            });
    }
    function setHandleBtns() {
        $(".btn-edit-note").each(function(){
            $(this).off();
            $(this).on( "click", function() {
                var textarea = $('#textarea-task');
                textarea.val($(this).attr('data-note'));
                textarea[0].focus();
                var btn_note = $("#btn-note");
                btn_note.attr('data-id',$(this).attr('data-id'));
                btn_note.html('<i class="fa fa-save"></i> Save ');
            });
        });
        $(".btn-remove-note").each(function(){
            $(this).off();
            $(this).on( "click", function() {
                $.ajax({
                        method: "POST",
                        url: "/tasks/note/remove",
                        dataType: 'json',
                        data: {
                            _csrf: $("meta[name=csrf-token]").attr("content"),
                            id: $(this).attr('data-id')
                        }
                    })
                    .done(function (response) {
                        if(!response.error) {
                            handleRequestNote(response.html);
                        }
                    });
            });
        });
        var btn_note = $("#btn-note");
        if(btn_note.length > 0) {
            btn_note.off();
            btn_note.on("click", function () {
                if ($(this).attr('data-id')) {
                    $.ajax({
                            method: "POST",
                            url: "/tasks/note/edit",
                            dataType: 'json',
                            data: {
                                _csrf: $("meta[name=csrf-token]").attr("content"),
                                note: $('#textarea-task').val(),
                                id: $(this).attr('data-id')
                            }
                        })
                        .done(function (response) {
                            if(!response.error) {
                                handleRequestNote(response.html);
                            }
                        });
                }
                else {
                    $.ajax({
                            method: "POST",
                            url: "/tasks/note/add",
                            dataType: 'json',
                            data: {
                                _csrf: $("meta[name=csrf-token]").attr("content"),
                                note: $('#textarea-task').val(),
                                task_user_id: $(this).attr('data-task_user_id')
                            }
                        })
                        .done(function (response) {
                            if(!response.error) {
                                handleRequestNote(response.html);
                            }
                        });
                }
            });
        }


        $(".btn-edit-message").each(function(){
            $(this).off();
            $(this).on( "click", function() {
                var textarea = $('#textarea-task');
                textarea.val($(this).attr('data-message'));
                textarea[0].focus();
                var btn_message = $("#btn-message");
                btn_message.attr('data-id',$(this).attr('data-id'));
                btn_message.html('<i class="fa fa-save"></i> Edit ');
            });
        });
        $(".btn-remove-message").each(function(){
            $(this).off();
            $(this).on( "click", function() {
                $.ajax({
                        method: "POST",
                        url: "/tasks/message/remove",
                        dataType: 'json',
                        data: {
                            _csrf: $("meta[name=csrf-token]").attr("content"),
                            id: $(this).attr('data-id')
                        }
                    })
                    .done(function (response) {
                        if(!response.error) {
                            handleRequestMessage(response.html);
                        }
                    });
            });
        });
        var btn_message = $("#btn-message");
        if(btn_message.length > 0) {
            btn_message.off();
            btn_message.on("click", function () {
                if ($(this).attr('data-id')) {
                    $.ajax({
                            method: "POST",
                            url: "/tasks/message/edit",
                            dataType: 'json',
                            data: {
                                _csrf: $("meta[name=csrf-token]").attr("content"),
                                message: $('#textarea-task').val(),
                                id: $(this).attr('data-id')
                            }
                        })
                        .done(function (response) {
                            if(!response.error) {
                                handleRequestMessage(response.html);
                            }
                        });
                }
                else {
                    send_message();
                }
            });
        }
    }
    function handleRequestNote(msg) {
        if(msg != '') {
            $('#taskUserNotes').html(msg);
            setHandleBtns();
            $('#textarea-task').val('');
            var btn_note = $("#btn-note");
            btn_note.removeAttr('data-id');
            btn_note.html('Send');
        }
    }
    function scrollersBottom() {
        $('.slimScrollDiv').each(function() {
            var el = $(this).find('ol');
            var pos = el.height() - 200;
            if(pos < 0)
                pos = 0;
            $(this).find('.scroller').scrollTop(pos);
            var slimScrollBar = $(this).find('.slimScrollBar');
            var h = slimScrollBar.height();
            slimScrollBar.css('top',(200 - h) + 'px');
        });
    }
    function handleRequestMessage(msg, is_timer) {
        if(is_timer === undefined) {
            is_timer = false;
        }
        if(msg != '' || !is_timer) {
            $('#taskUserMessages').html(msg);
            setHandleBtns();
            if(!is_timer) {
                $('#textarea-task').val('');
                var btn_message = $("#btn-message");
                btn_message.removeAttr('data-id');
                btn_message.html('Send');
            }
            scrollersBottom();
        }
    }
    setHandleBtns();
    if(!is_custom) {
        check_status();
    }

    var tab_note = $("#btn-tab-note");
    tab_note.off();
    tab_note.on( "click", function() {
        var btn_message = $("#btn-message");
        if(btn_message.length > 0) {
            btn_message.removeAttr('id');
            btn_message.attr('id','btn-note');
            btn_message.removeAttr('data-id');
            btn_message.html('Add ');
            setHandleBtns();
        }
        $("#tab-caption").html('Notes');
        $("#message-input").css('display','block');


    });

    function send_message() {
        $.ajax({
                method: "POST",
                url: "/tasks/message/add",
                dataType: 'json',
                data: {
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    message: $('#textarea-task').val(),
                    task_user_id: task_user_id,
                    is_my: is_my
                }
            })
            .done(function (response) {
                if(!response.error) {
                    handleRequestMessage(response.html);
                    setTimeout(function(){
                        $(".task-body .block.chat .scroller").mCustomScrollbar("scrollTo","bottom");
                    },300);
                }
            });
    }

    var tab_message = $("#btn-tab-message");
    tab_message.off();
    tab_message.on( "click", function() {
        $('.task-body .block.chat .scroller').mCustomScrollbar({
            theme:"dark",
            axis:"y",
            setHeight:255
        });

        
        $(".task-body .block.chat .scroller").mCustomScrollbar("update");
        $(".page-content") .mCustomScrollbar("destroy");

        setTimeout(function(){
            $(".task-body .block.chat .scroller").mCustomScrollbar("scrollTo","bottom");
            $('.page-content').mCustomScrollbar({
                setHeight: $('.page-content').css('minHeight'),
                theme:"dark",
                setHeight:255
            });
            check_status(false);
        },300);
        $.each($(".task-body .block.chat .content .task-user-message .message"),function(){
            var messageWidth = $(this).outerWidth();
            $(this).parent('td').css('width',messageWidth);
        });
        var btn_note = $("#btn-note");
        if(btn_note.length > 0) {
            btn_note.removeAttr('id');
            btn_note.attr('id','btn-message');
            btn_note.removeAttr('data-id');
            btn_note.html('Send ');
            setHandleBtns();
        }
        $("#tab-caption").html('Chat');
        $("#message-input").css('display','block');
        var textarea_task = $('#textarea-task');
        textarea_task.off();
        textarea_task.on('keydown',function( e ) {
            if ( e.keyCode == 13 ) {
                send_message();
            }
        });
    });
    var tab_log = $("#btn-tab-log");
    tab_log.off();
    tab_log.on( "click", function() {

        $.ajax({
            url: '/tasks/readlog',
            data: {task_user_id: task_user_id},
            type: 'post',
            dataType: 'json',
            success: function(response){
                console.log(response);
            }
        });

        $("#tab-caption").html('Logs');
        $("#message-input").css('display','none');
        $(this).closest('li').find('#badge-log').html('');
        set_log();
    });

    function setData(start,end) {
        if(end == undefined) {
            end = start;
        }
        if(end == '') {
            return;
        }
        if(is_my) {
            var data = {
                _csrf: $("meta[name=csrf-token]").attr("content"),
                command: 'set_date',
                task_user_id: task_user_id,
                start: start,
                end: end
            };
            $.ajax({
                url: '/departments/tool-ajax',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    if (!response.error) {
                        //updGant(task_user_id);
                    }
                }
            });
        }
        else {
            var input_start = $("#taskuser-start");
            var input_end = $("#taskuser-end");
            if (input_start.val() != input_start.attr('data-value') ||
                input_end.val() != input_end.attr('data-value')) {
                $('.offer').removeClass('disabled');
            }
        }
    }

    function setStart(str) {
        $("#taskuser-start").val(str);
        setData(str);
        $str_m = '';
        $str_d = '';
        if(str != '') {
            var date = $.datepicker.parseDate("yy-mm-dd", str);
            $str_m = date.toLocaleString("en", {month: 'short'});
            $str_d = date.getDate();
        }
        $(".title-caption.start").html($str_m);
        $(".title-value.start").html($str_d);
    }
    function setEnd(str) {
        $("#taskuser-end").val(str);
        setData($("#taskuser-start").val(),str);
        $str_m = '';
        $str_d = '';
        if(str != '') {
            var date = $.datepicker.parseDate("yy-mm-dd", str);
            $str_m = date.toLocaleString("en", {month: 'short'});
            $str_d = date.getDate();
        }
        $(".title-caption.end").html($str_m);
        $(".title-value.end").html($str_d);
    }
    $("#startDate").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
        showWeek: false,
        numberOfMonths: 1,
        // selectOtherMonths: true,
        beforeShowDay: function(date) {
            if($("#taskuser-start").length > 0 && $("#taskuser-end").length > 0) {
                var date1 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-start").val());
                var date2 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-end").val());
                var class_name = '';
                if(date1 && ((date.getTime() == date1.getTime())))
                    class_name = "dp-start-highlight";
                else if(date2 && ((date.getTime() == date2.getTime())))
                    class_name = "dp-end-highlight";
                else if(date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)))
                    class_name = "dp-highlight";
                return [true,  class_name];
            }
            return [true, "","Available"];
        },
        onSelect: function(dateText, inst) {

            var date1 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-start").val());
            var date2 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-end").val());

            if (!date1 || date2) {

                setStart(dateText);
                setEnd("");
            } else {
                var date_new = $.datepicker.parseDate("yy-mm-dd", dateText);
                if (date_new < date1) {
                    setStart(dateText);
                }
                else {
                    setEnd(dateText);
                    $('#datepicker').removeClass('in');
                    $('#btn-datepicker').removeClass('active');
                }
            }
            $("#endDate").datepicker( "refresh" );
        }
    });
    var endDate = $("#endDate");
    endDate.datepicker({

        dateFormat: "yy-mm-dd",
        minDate: 0,
        showWeek: false,
        numberOfMonths: 1,
        beforeShowDay: function(date) {
            if($("#taskuser-start").length > 0 && $("#taskuser-end").length > 0) {
                var date1 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-start").val());
                var date2 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-end").val());
                var class_name = '';
                if(date1 && ((date.getTime() == date1.getTime())))
                    class_name = "dp-start-highlight";
                else if(date2 && ((date.getTime() == date2.getTime())))
                    class_name = "dp-end-highlight";
                else if(date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)))
                    class_name = "dp-highlight";
                return [true,  class_name];
            }
            return [true, "","Available"];
        },
        onSelect: function(dateText, inst) {

            var date1 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-start").val());
            var date2 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-end").val());

            if (!date1 || date2) {

                setStart(dateText);
                setEnd("");
            } else {
                var date_new = $.datepicker.parseDate("yy-mm-dd", dateText);
                if (date_new < date1) {
                    setStart(dateText);
                }
                else {
                    setEnd(dateText);
                    $('#datepicker').removeClass('in');
                    $('#btn-datepicker').removeClass('active');
                }
            }
            $("#startDate").datepicker( "refresh" );

        }
    });
    endDate.datepicker('setDate','+1m');
    set_action_panel();
    set_counter_offer();
    set_cancel_delegate_users();

    // @see https://select2.github.io/examples.html#data-ajax
    function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository'>" + repo.name + "</div>";

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.name || repo.text;
    }

    $("#select-skills").select2({
        width: "off",
        ajax: {
            type: 'POST',
            url: "/core/default/skills",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data, page) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data
                return {
                    results: data.data
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
}
