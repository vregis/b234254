
<?php $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"); ?>
<?php $this->registerJsFile("/js/min/jquery.mask.min.js"); ?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>
<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<div id="find_job" class="collapse slidePop">
    <!-- Nav tabs -->

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="task-block">
            <table class="table table-bordered" style="width:100%;">
                <thead>
                <tr>
                    <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                    <th width="290">Task name</th>
                    <th class="dropmenu filter-task deps" width="170">
                        <div style="position:relative;">
                            <div class="trigger">Departments <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in deps-menu" role="tooltip">
                                 <?= $deps_filter ?>
                            </div>
                        </div>
                    </th>
                    <th class="dropmenu filter-task specs" width="121">
                        <div style="position:relative;">
                            <div class="trigger">Specialty <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in spec-menu" role="tooltip">
                                 <?= $specials_filter ?>
                            </div>
                        </div>
                    </th>
                    <th width="120" class="time">Time <i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></th>
                    <th width="120" class="rate">Rate / H <i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></th>
 <!--                    <th class="filter-task status" width="121">
                        <div style="position:relative;">
                            <div class="trigger">Status <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in status-menu" role="tooltip">
                            <div class="arrow"></div>

                            </div>
                        </div>
                    </th> -->
                    <th class="dropmenu1 status" data-toggle="popover" data-not_autoclose="1">Search <i class="fa fa-angle-down"></i></th>
                </tr>
                </thead>
                <tbody id="user_task">
                    <?= $user_task ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6" style="border-right:0;padding-left: 8px;">
                        <div class="pull-left">
                            <div id="invite-form" class="no-autoclose" style="display:none;">
                                <div class="form-group">
                                    <input type="text" id="input-invite-email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <textarea name="name" id="input-invite-offer" class="form-control" rows="8" cols="40" placeholder="Offer text"></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="pull-right">
                                        <button type="submit" id="invite-form-send" class="btn btn-primary">Send</button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <? require __DIR__.'/advanced_search_form.php' ?>
                            <button style="margin-left: 5px;" class="btn btn-primary circle advanced-search-btn" data-toggle="popover" data-not_autoclose="1">
                                <i class="ico-search"></i>
                            </button>
                            Advanced search
                        </div>
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </th>

                    <th style="border-left:0;">
                        <button id="request" class="btn btn-primary make-ajax" style="width:100px;">Request</button>
                    </th>
                </tr>
                </tfoot>
            </table>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="request-block">
            <table class="table table-bordered" style="width:100%;">
                <thead>
                <tr>
                    <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                    <th width="290">Task name</th>
                    <th class="dropmenu filter-task deps" width="170">
                        <div style="position:relative;">
                            <div class="trigger">Departments <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in deps-menu" role="tooltip">
                                 <?= $deps_filter ?>
                            </div>
                        </div>
                    </th>
                    <th class="dropmenu filter-task specs" width="121">
                        <div style="position:relative;">
                            <div class="trigger">Specialty <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in spec-menu" role="tooltip">
                                 <?= $specials_filter ?>
                            </div>
                        </div>
                    </th>
                    <th width="120" class="time">Time <i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></th>
                    <th width="120" class="rate">Rate / H <i class="fa fa-angle-up"></i><i class="fa fa-angle-down"></i></th>
                    <th class="dropmenu1 status" data-toggle="popover" data-not_autoclose="1">Pending <i class="fa fa-angle-down"></i></th>
                </tr>
                </thead>
                <tbody id="user_request">
                    <?= $user_request ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6" style="border-right:0;">
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </th>
                    <th style="border-left:0;">
                        <button id="reject" class="btn btn-primary make-ajax" style="width:100px;">Cancel</button>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div id="status-menu" style="display:none !important;">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a id="btn-task-block" href="#task-block" aria-controls="task-block" role="tab" data-toggle="tab">Search </a></li>
                <li role="presentation"><a id="btn-request-block" href="#request-block" aria-controls="request-block" role="tab" data-toggle="tab" style="cursor: pointer;">Pending </a></li>
            </ul>
        </div>
    </div>
</div>
<style>
    table th .fa{
        margin-left:10px;
    }
    table th.rate .fa,table th.time .fa{
        position:absolute;
        cursor:pointer;
    }
    table th.rate .fa-angle-up,table th.time .fa-angle-up{
        margin-top:-4px;
    }
    table th.rate .fa-angle-down,table th.time .fa-angle-down{
        margin-top:10px;
    }
    table th.rate{
        text-align:right;
        padding-right:30px !important;
        padding-left:0 !important;
    }
    table th.time{
        padding-right:40px !important;
        padding-left:0 !important;
        text-align:right;
    }
    .select-all{
        width:100px;
        height:28px;
    }
    #advanced-search-form{
        border:none;
    }
    .popover{
        min-width: 420px;
        border:1px solid #d7d7d7;
        padding: 10px;
        /*white-space: nowrap;*/
        /*background: #ebebeb;*/
        border-radius:10px !important;
        box-shadow: 0 0 32px 0 rgba(139,139,143,0.34) !important;
        border: 1px solid #dae2ea;
    }
    .advanced-search-btn+.popover .popover-content{
        padding:0;
        width: 410px;
        height:239px;
    }
    .popover.bottom > .arrow:after {
        border-bottom-color: #FFF !important;
    }
    .popover.top > .arrow:after {
        border-top-color: #FFF !important;
    }
    .popover.right > .arrow:after {
        border-right-color: #fff !important;
    }
    .popover .popover-content,.advanced-search-btn+.popover .popover-content{
        background: #fff;
        /*border: 1px solid #d7d7d7;*/
    }
    .dropselect,.dropselect1{
        min-width:195px !important;
        width:195px !important;
    }
    .dropselect1{
        min-width:150px !important;
        width:150px !important;
    }
    .dropselect .popover-content,.dropselect1 .popover-content{
        padding: 0;
    }
    .dropselect a{
        display: block;
        width: 100%;
        text-align: center;
        line-height: 30px;
        font-size: 16px;
        color: #7b7b7b;
        text-decoration: none;
        /*border-bottom: 1px solid #d7d7d7;*/
        border-radius:3px;
        margin-bottom:1px;
    }
    #status-menu ul{
        position: relative;
        top: 0;
        border:none;
        margin: 0;
    }
    #status-menu a{
        border:none;
        display:block;
        width:100%;
        background:none !important;
        color: #7b7b7b !important;
        padding: 0 !important;
        line-height: 30px;
    }
    #status-menu li{
        display:block;
        width:100%;
        float:none;
    }
    #status-menu li.active a{
        background:#8eb6f8 !important;
        color:#fff !important;
        border-radius:3px;
    }
    .dropmenu,.dropmenu1{
        cursor: pointer;
        padding:0 !important;
    }
    .dropmenu .trigger{
        height:50px;
        line-height:50px;
    }
    .dropmenu > div:first-child{
        padding:0px;
    }
    .dropmenu .popover{
        top:100%;
    }
    .dropselect a:last-child {
        border-bottom: 0;
    }

    .dropselect a.off{
        color:rgba(123,123,123,0.5);
    }
    .background-1.on{
        background-color: rgba(145, 135, 208,0.6);
    }
    .background-2.on{
        background-color: rgba(183, 135, 209,0.6);
    }
    .background-3.on{
        background-color: rgba(253, 109, 100,0.6);
    }
    .background-4.on{
        background-color: rgba(255, 162, 93,0.6);
    }
    .background-5.on{
        background-color: rgba(255, 209, 71,0.6);
    }
    .background-6.on{
        background-color: rgba(170,215,114,0.6);
    }
    .background-7.on{
        background-color: rgba(112,202,200,0.6);
    }
    .background-8.on{
        background-color: rgba(93,201,240,0.6);
    }
    #input-rate-start,#input-rate-end{
        background: #fff url("/images/cost-bg.png") 7px 0 no-repeat;
        padding-left: 30px;
    }
    .advanced-search-btn+.popover.top > .arrow {
        left: 28px !important;
    }
    label{
        text-indent: 12px;
    }
    .bootstrap-select.btn-group .dropdown-toggle .filter-option{
        line-height: 30px;
    }
    .pagination{
        position: absolute;
        z-index: 1;
        margin: 0;
        display: block;
        margin-top: 17px;
        left:50%;
    }
    .btn.info {
        width: 18px !important;
        height: 18px;
        padding: 0;
        line-height: 18px !important;
        font-size: 12px;
    }
    .dropmenu{
        cursor: pointer;
    }
    .popover.avatar{
        text-align:center;
        min-width:185px;
        color:#5a5a5a;
    }
</style>
<script>
    $( document ).ready(function() {
        $("#find_job").on('shown.bs.collapse',function(){
            $(".btn.info").popover({
                placement:"top",
                html:true
            });

            $(".gant_avatar").popover({
                container:$("body"),
                html:true,
                template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                trigger:"click"
            });
            $(".dropmenu1.status").popover({
                placement:"bottom",
                html:true,
                content:$("#status-menu"),
                // container:$("body"),
                template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
            });
            $(".dropmenu1.status").on('shown.bs.popover',function(){
                $("#status-menu a[data-toggle='tab']").click(function(){
                    console.log("asdasda");
                    $("#status-menu li").removeClass('active');
                    $(this).tab('show').parents('li').addClass('active');
                    // $(".dropmenu1.status").popover('hide');
                });
            });
            $(".btn.info").on('show.bs.popover',function(){
                $(".gant_avatar,table tr td.name .pull-left").popover('destroy');
            }).on('hide.bs.popover',function(){
                $(".gant_avatar").popover({
                    container:$("body"),
                    html:true,
                    template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                    trigger:"click"
                });
                $("table tr td.name .pull-left").popover({
                    container:$("body"),
                    trigger:"hover"
                });
            });

            $("table tr td.name .pull-left").popover({
                container:$("body"),
                trigger:"hover"
            });
            $(".dropmenu1").on('show.bs.popover',function(){
                $("#status-menu").show();
                $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
            }).on('hide.bs.popover',function(){
                $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
            });
            $(".dropmenu .trigger").click(function(){
                var that = $(this).parent('.dropmenu');
                
                if(!$(this).next('.dropselect').is(":visible")){
                    $('.dropselect').hide();
                    $(".dropmenu").find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                    $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                    $(".gant_avatar,table tr td.name .pull-left").popover('destroy');

                }else{
                    $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                    $(".gant_avatar").popover({
                        container:$("body"),
                        html:true,
                        template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                        trigger:"click"
                    });
                    $("table tr td.name .pull-left").popover({
                        container:$("body"),
                        trigger:"hover"
                    });

                }
                $(this).next('.dropselect').toggle();
                 return false;
            });

            $('html').click(function(e) {
                $('.dropselect').hide(); 
                $('.dropmenu').find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                    $(".gant_avatar").popover({
                        container:$("body"),
                        html:true,
                        template:'<div class="popover avatar" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                        trigger:"click"
                    });
                    $("table tr td.name .pull-left").popover({
                        container:$("body"),
                        trigger:"hover"
                    });
                });
                
            $('.dropselect').click(function(e){
                e.stopPropagation();
            });
            $("#search-block .pagination").css({
                'margin-left': "-" + ($("#search-block .pagination").width() / 2) + "px",
            });
            $('#find_job a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                e.target // newly activated tab
                e.relatedTarget // previous active tab
                $(".pagination").css({
                    'margin-left': "-" + ($($(this).attr('href')).find(".pagination").width() / 2) + "px",
                });
                $(".btn.info").popover({
                    placement:"top",
                    html:true
                });
            });
        });
        $('.selectpicker').selectpicker({});
        $("#input-rate-start,#input-rate-end").inputmask({
            "mask": "9",
            "repeat": 3,
            "greedy": false,
        }); // 
        $(".advanced-search-btn").popover({
            placement:"auto top",
            html:true,
            trigger:"click",
            content:$("#advanced-search-form")
        });
        $(".advanced-search-btn").on('show.bs.popover',function(){
            $('#advanced-search-form-dom').html('');
            $("#advanced-search-form").show();
        });
        $(".advanced-search-btn").on('hide.bs.popover',function(){
            $('#advanced-search-form-dom').html($('.popover.in').html());
        });

        function setHandlerPagination(table) {

            function goPage(page_id) {
                table.find('.user-row').each(function() {
                    var cur_page_id = parseInt($(this).attr('data-page-id'));
                    if(cur_page_id != page_id) {
                        $(this).attr('style','display: none');
                    }else {
                        $(this).attr('style','display: table-row');
                    }
                });
                table.find('.go-page').each(function() {
                    var cur_page_id = parseInt($(this).attr('data-page-id'));
                    var li = $(this).closest('li');
                    if(cur_page_id != page_id) {
                        li.removeClass('active');
                    }else {
                        li.addClass('active');
                    }
                });
                var prev_li = table.find('.prev-page').closest('li');
                if(page_id!=0) {
                    prev_li.removeClass('disabled');
                }else {
                    prev_li.addClass('disabled');
                }
                var next_li = table.find('.next-page').closest('li');
                if(page_id!=go_page.length-1) {
                    next_li.removeClass('disabled');
                }else {
                    next_li.addClass('disabled');
                }
                table.find('.button-select').each(function() {
                    $(this).removeClass('active');
                });
                table.find('.make-ajax').removeClass('active');
            }
            var go_page = table.find('.go-page');
            go_page.off();
            go_page.on('click', function(){
                if(!$(this).closest('li').hasClass('active')) {
                    var page_id = parseInt($(this).attr('data-page-id'));
                    goPage(page_id);
                }
            });
            var prev_page = table.find('.prev-page');
            prev_page.off();
            prev_page.on('click', function(){
                if(!$(this).closest('li').hasClass('disabled')) {
                    var page_id = parseInt(table.find('.pagination li.active .go-page').attr('data-page-id'));
                    goPage(page_id - 1);
                }
            });
            var next_page = table.find('.next-page');
            next_page.off();
            next_page.on('click', function(){
                if(!$(this).closest('li').hasClass('disabled')) {
                    var page_id = parseInt(table.find('.pagination li.active .go-page').attr('data-page-id'));
                    goPage(page_id + 1);
                }
            });
        }

        function set_user_task(_this, html) {
            if(html!=undefined) {
                _this.html(html);
            }else {
                _this = $('#user_task');
            }
            var button_select = _this.find('.button-select');
            button_select.off();
            button_select.on('click', function(){
                $(this).toggleClass("active");

                $("#request").addClass('active');
                if(_this.closest('.table').find('.button-select.active').length == 0){
                    $("#request").removeClass('active');
                }
            });
            setHandlerPagination(_this.closest('.table'));
            var on = $('.on');
            on.off();
            on.on('click',function(e) {
                var count = $(this).closest('div').find('.on').length;
                if(count > 1) {
                    $(this).removeClass('on');
                    $(this).addClass('off');
                    if($(this).closest('.filter-task').length > 0) {
                        get_user_task(false);
                    }
                    else {
                        get_user_request(false);
                    }
                }
            });
            var off = $('.off');
            off.off();
            off.on('click',function(e) {
                $(this).removeClass('off');
                $(this).addClass('on');
                var is_dep = false;
                if($(this).closest('.deps-menu').length > 0) {
                    is_dep = true;
                }
                if($(this).closest('.filter-task').length > 0) {
                    get_user_task(false, is_dep);
                }else {
                    get_user_request(is_dep);
                }
            });

            $('.dropselect .popover-content').mCustomScrollbar({
                setHeight: 247,
                theme:"dark"
            });
        }
        function set_user_request(_this, html) {
            if(html!=undefined) {
                _this.html(html);

            }
            var button_select = _this.find('.button-select');
            button_select.off();
            button_select.on('click', function(){
                $(this).toggleClass("active");

                $("#reject").addClass('active');
                if(_this.closest('.table').find('.button-select.active').length == 0){
                    $("#reject").removeClass('active');
                }
            });

            if(button_select.length == 0) {
                var btn_request_block = $('#btn-request-block');
                btn_request_block.removeAttr('data-toggle');
                btn_request_block.removeAttr('href');
                btn_request_block.css('cursor','default');
                $('#btn-task-block').tab('show');

            }else {
                var btn_request_block = $('#btn-request-block');
                btn_request_block.attr('data-toggle','tab');
                btn_request_block.attr('href','#request-block');
                btn_request_block.css('cursor','pointer');
            }
            setHandlerPagination(_this.closest('.table'));

        }

        $('#request').on('click', function(){
            var ids = [];
            var task_ids = [];
            var names = "";
            var i=0;
            $('#user_task').find('.button-select').each(function() {
                if($(this).hasClass("active")) {
                    ids.push($(this).attr('data-id'));
                    task_ids.push($(this).attr('data-task-id'));
                    if(i != 0) {
                        names += ", ";
                    }
                    names += $(this).closest('.user-row').find('.name').find('.pull-left').text();
                    i++;
                }
            });

            if(ids.length > 0) {
                $.ajax({
                    url: '/departments/business/request',
                    type: 'post',
                    dataType: 'json',
                    data: Object.assign({
                        _csrf: $("meta[name=csrf-token]").attr("content"),
                        user_ids: ids,
                        user_task_ids: task_ids,
                        start: $("#input-rate-start").val(),
                        end: $("#input-rate-end").val()
                    }, get_find_params()),
                    success: function (response) {
                        if (!response.error) {
                            toastr["success"]("Make requests: " + names, "Success");
                            $('.filter-task .deps-menu').html(response.html_deps_filter);
                            $('.filter-task .spec-menu').html(response.html_specials_filter);
                            set_user_task($('#user_task'), response.html_user_task);
                            set_user_request($('#user_request'), response.html_user_request);
                            $('#delegated_businesses').html(response.html_delegated_businesses);
                        }
                    }
                });
                $(this).removeClass('active');
            }
        });
        $('#reject').on('click', function(){
            var ids = [];
            var names = "";
            var i=0;
            $('#user_request').find('.button-select').each(function() {
                if($(this).hasClass("active")) {
                    ids.push($(this).attr('data-id'));
                    if(i != 0) {
                        names += ", ";
                    }
                    names += $(this).closest('.user-row').find('.name').find('.pull-left').text();
                    i++;
                }
            });

            if(ids.length > 0) {
                $.ajax({
                    url: '/departments/business/reject',
                    type: 'post',
                    dataType: 'json',
                    data: Object.assign({
                        _csrf: $("meta[name=csrf-token]").attr("content"),
                        user_ids: ids,
                        start: $("#input-rate-start").val(),
                        end: $("#input-rate-end").val()
                    }, get_find_params()),
                    success: function (response) {
                        if (!response.error) {
                            toastr["success"]("Reject requests: " + names, "Success");
                            $('.filter-task .deps-menu').html(response.html_deps_filter);
                            $('.filter-task .spec-menu').html(response.html_specials_filter);
                            set_user_task($('#user_task'), response.html_user_task);
                            set_user_request($('#user_request'), response.html_user_request);
                            $('#delegated_businesses').html(response.html_delegated_businesses);
                        }
                    }
                });
                $(this).removeClass('active');
            }
        });
        set_user_task($('#user_task'));
        set_user_request($('#user_request'));

        $('.select-all').on('click', function(){
            var select_all = $(this);
            var table = select_all.closest('.table');
            table.find('.user-row').each(function() {
                if($(this).css('display') != 'none') {
                    $(this).find('.button-select').addClass("active");
                }
            });
            table.find('.make-ajax').addClass("active");
        });

        function get_find_params(is_advance) {
            if(is_advance == undefined) {
                is_advance = false;
            }
            var country = 0;
            if($('#select-country').length > 0)
            {
                country = $('#select-country').val();
            }
            var rate_start = 0;
            if($('#input-rate-start').length > 0)
            {
                rate_start = $('#input-rate-start').val();
            }
            var rate_end = 0;
            if($('#input-rate-end').length > 0)
            {
                rate_end = $('#input-rate-end').val();
            }
            var department = 0;
            if($('#select-department').length > 0)
            {
                department = $('#select-department').val();
            }
            var special = 0;
            if($('#select-special').length > 0)
            {
                special = $('#select-special').val();
            }
            var is_request = false;
            if(!is_advance) {
                var deps = [];
                var tab = $('#task-block');
                if(!tab.hasClass('in')) {
                    tab = $('#request-block')
                    is_request = true;
                }
                tab.find('.deps-menu').find('.on').each(function() {
                    deps.push($(this).attr('data-id'));
                });
                var spec = [];
                tab.find('.spec-menu').find('.on').each(function() {
                    spec.push($(this).attr('data-id'));
                });
            }
            return {
                country: country,
                rate_start: rate_start,
                rate_end: rate_end,
                department: department,
                special: special,
                deps: deps,
                spec: spec,
                is_request: is_request
            };
        }

        function get_user_task(is_advance, is_dep) {
            if(is_advance == undefined) {
                is_advance = false;
            }
            if(is_dep == undefined) {
                is_dep = false;
            }
            $.ajax({
                url: '/departments/business/user-task',
                type: 'post',
                dataType: 'json',
                data: Object.assign({
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    is_dep: is_dep
                }, get_find_params(is_advance)),
                success: function (response) {
                    if (!response.error) {
                        $('.filter-task .deps-menu').html(response.html_deps_filter);
                        $('.filter-task .spec-menu').html(response.html_specials_filter);
                        set_user_task($('#user_task'), response.html_user_task);
                        set_user_request($('#user_request'), response.html_user_request);
                        $('#delegated_businesses').html(response.html_delegated_businesses);
                    }
                }
            });
        }
        function get_user_request(is_dep) {
            if(is_dep == undefined) {
                is_dep = false;
            }
            $.ajax({
                url: '/departments/business/user-request',
                type: 'post',
                dataType: 'json',
                data: Object.assign({
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    is_dep: is_dep
                }, get_find_params(false)),
                success: function (response) {
                    if (!response.error) {
                        $('.filter-request .deps-menu').html(response.html_deps_filter);
                        $('.filter-request .spec-menu').html(response.html_specials_filter);
                        set_user_task();
                        set_user_request($('#user_request'), response.html_user_request);
                        $('#delegated_businesses').html(response.html_delegated_businesses);
                    }
                }
            });
        }

        var advanced_send = $('#advanced-search-send');
        advanced_send.on('click',function(e) {
            get_user_task(true);
            $('.popover').each(function(){
                $(this).popover('hide');
            });
        });

        $('#select-department').on('change',function(e) {
            var department = $(this).val();
            $.ajax({
                url: '/departments/business/get-specials',
                type: 'post',
                dataType: 'json',
                data: {
                    _csrf: $("meta[name=csrf-token]").attr("content"),
                    department: department
                },
                success: function (response) {
                    if (!response.error) {
                        var select_special = $('#select-special');
                        select_special.html('<option class="start" value="0">Select speciality</option>' + response.html);
                        if(response.html != '') {
                            select_special.removeAttr('disabled');
                        }else {
                            select_special.attr('disabled','');
                        }
                        select_special.selectpicker('refresh');
                    }
                }
            });
        });
    });
</script>