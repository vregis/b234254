/**
 * Created by toozzapc2 on 17.12.2015.
 */

var timeoutChat = 2000;
$(document).ready(function(){

    var offs = 32;
    console.log(offs);
    $('.well').css({
        'margin-top': offs - 2,
        'margin-bottom': offs - 2
    });
});
function afterSubmit() {
    var start = $("#taskuser-start");
    if($('#taskuser-status').val() == '2') {
        if(start.val()  == '') {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!

            var yyyy = today.getFullYear();
            if(dd<10){
                dd='0'+dd
            }
            if(mm<10){
                mm='0'+mm
            }
            start.val(yyyy+'-'+mm+'-'+dd);
        }
    }
    var end = $("#taskuser-end");
    if(start.val() != '' && end.val() == '') {
        end.val(start.val());
    }
}



var date_timepicker_start = $('#taskuser-start');
if(date_timepicker_start.length > 0) {
    date_timepicker_start.datetimepicker({
        format:'Y-m-d',
        timepicker:false,
        onShow:function( ct ){
            var date_end = $('#taskuser-end').val();
            date_end = date_end.replace(/-/g,"/");
            this.setOptions({
                maxDate: (date_end != '') ? date_end : false
            });
        }
    });
}
var date_timepicker_end = $('#taskuser-end');
if(date_timepicker_end.length > 0) {
    date_timepicker_end.datetimepicker({
        format:'Y-m-d',
        timepicker:false,
        onShow:function( ct ){
            var date_start = $('#taskuser-start').val();
            date_start = date_start.replace(/-/g,"/");
            this.setOptions({
                minDate:(date_start != '') ? date_start : false
            });
        }
    });
}
function getMonth($number) {
    var month = '';
    switch ($number) {
        case 1:
            month = 'Jan';
            break;
        case 2:
            month = 'Feb';
            break;
        case 3:
            month = 'Mar';
            break;
        case 4:
            month = 'Apr';
            break;
        case 5:
            month = 'May';
            break;
        case 6:
            month = 'June';
            break;
        case 7:
            month = 'July';
            break;
        case 8:
            month = 'Aug';
            break;
        case 9:
            month = 'Sept';
            break;
        case 0:
            month = 'Oct';
            break;
        case 11:
            month = 'Nov';
            break;
        case 12:
            month = 'Dec';
            break;
    }
    return month;
}
function setStart(str) {
    $("#taskuser-start").val(str);
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

// $("#datepicker").datepicker({
//     dateFormat: "yy-mm-dd",
//     minDate: 0,
//     numberOfMonths: 1,
//     beforeShowDay: function(date) {
//         if($("#taskuser-start").length > 0 && $("#taskuser-end").length > 0) {
//             var date1 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-start").val());
//             var date2 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-end").val());
//             return [true, date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)) ? "dp-highlight" : ""];
//         }
//         // return;
//     },
//     onSelect: function(dateText, inst) {
//
//         var date1 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-start").val());
//         var date2 = $.datepicker.parseDate("yy-mm-dd", $("#taskuser-end").val());
//
//         if (!date1 || date2) {
//
//             setStart(dateText);
//             setEnd("");
//         } else {
//             var date_new = $.datepicker.parseDate("yy-mm-dd", dateText);
//             if (date_new < date1) {
//                 setStart(dateText);
//             }
//             else {
//                 setEnd(dateText);
//             }
//         }
//         $('.help-block').each(function() {
//             $(this).html('');
//         });
//         $('.has-error').each(function() {
//             $(this).removeClass('has-error');
//         });
//     }
// });

$(window).resize(function(){
    $('.task-description .wrapper').readmore({
        collapsedHeight:300,
        moreLink:'<button class="btn expand"><i class="fa fa-angle-down"></i></button>',
        lessLink:'<button class="btn expand"><i class="fa fa-angle-up"></i></button>'
    });
});
$('.task-description .wrapper').readmore({
    collapsedHeight:300,
    moreLink:'<button class="btn expand"><i class="fa fa-angle-down"></i></button>',
    lessLink:'<button class="btn expand"><i class="fa fa-angle-up"></i></button>'
});
// $(".tabbable-tabdrop").tabdrop();
$( "#complete" ).bind( "click", function() {
    $('#taskuser-status').val('2');
    afterSubmit();
    $('#task-form').submit();
});
$( "#restart" ).bind( "click", function() {
    $('#taskuser-status').val('1');
    afterSubmit();
    $('#task-form').submit();
});
$(".b-btn-no-idea").bind( "click", function() {
    $('#taskuser-status').val('2');
    afterSubmit();
    $('#input-href').val('/core/profile');
    $('#task-form').submit();
});
// alert($(window).width());
// $(".ui-datepicker-prev .ui-icon").html("<i class='fa fa-angle-left'></i>");
// $(".ui-datepicker-next .ui-icon").html("<i class='fa fa-angle-right'></i>");
$('.task-title [data-toggle="popover"]').popover({
    placement: "bottom"
});
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var IMG = $('#collapseVideos img');
    IMG.click(function(){
        var that = $(this);
        var idIMG = $(this).attr('src').replace(/http...img.youtube.com.vi.([\s\S]*?).1.jpg/g, '$1');
        $('#myModal').on('show.bs.modal', function (e) {
            var IFRAME = $('#collapseVideos iframe');
            if(IFRAME.attr('src') != 'http://www.youtube.com/embed/' + idIMG + '?rel=0&autoplay=1'){
                IFRAME.attr('src','http://www.youtube.com/embed/' + idIMG + '?rel=0&autoplay=1');
                console.log(IFRAME.src);
                if(this.dataset.end) IFRAME.src = IFRAME.src.replace(/([\s\S]*)/g, '$1&end=' + this.dataset.end);
                if(this.dataset.start) IFRAME.src = IFRAME.src.replace(/([\s\S]*)/g, '$1&start=' + this.dataset.start);
                IMG.removeClass('active');
                that.addClass('active');
            }
        });
        $('#myModal').on('hidden.bs.modal', function (e) {
            var IFRAME = $('#collapseVideos iframe');
            IFRAME.attr('src','');
        });
    });
});

// $.each($('.task-body .block.desc .footer .btn'),function(){
$('.task-body .block.desc .footer .btn').popover({
    container:$("body"),
    // trigger: 'click',
    html:true,
}).on('show.bs.popover',function(){
    $(this).addClass('active');
}).on('hidden.bs.popover',function(){
    $(this).removeClass('active');
}).on('click', function (e) {
    $('.task-body .block.desc .footer .btn').not(this).popover('hide');
});


// });
$(".task-title .item.date .icon").popover({
    container:$("body"),
    trigger: "click",
    html:true,
    placement:"bottom",
    content: $("#datepicker").html()
}).on('shown.bs.popover',function(){
    $(this).addClass('active');
}).on('hidden.bs.popover',function(){
    $(this).removeClass('active');
});

$(document).on('keyup', '#feedback-input', function(){
    $(this).closest('div').removeClass('has-error');
})

$(document).on('click', '#btn-feedback', function(){
    var msg = $('#feedback-input').val();
    if(msg == ''){
        $('#feedback-input').closest('div').addClass('has-error')
    }else{
        App.blockUI({
            target: '#task',
            animate: true
        });
        $.ajax({
            url: '/tasks/sendfeedback',
            data: {msg:msg},
            dataType: 'json',
            type: 'post',
            success: function(response){
                App.unblockUI('#task');
                bootbox.alert("You message was sent");
            }
        })
    }
});