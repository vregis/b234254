// user list resize begin

function getUserlistHeight(){
    var scrheight = $(window).height();
    var dbTitleBox = $('.dialog-box-title-block').height();
    var dbTabBlock = $('.dialog-box-tab-block').height();
    var dbSectionNavy = $('.dialog-box-section-navy').height();
    var dbNameBlock = $('.dialog-box-name-block').height();
    var dbBtnSize = $('.dialog-box-condition-btn').height();
    var totalRest = dbTitleBox + dbTabBlock + dbSectionNavy + dbNameBlock + dbBtnSize;
    var totalRestClosed = dbTitleBox + dbSectionNavy + dbNameBlock + dbBtnSize;
    $('#dialog-massage-history-block').css('height', scrheight - 178 +'px');
    if($('.general-dialog-box').hasClass('active')){
        $('.dialog-box-user-list-block').css('height', scrheight - totalRestClosed -60 +'px');
        $('.dialog-box-user-list-block').css('max-height', scrheight - totalRestClosed -60 +'px');
    }else{
        $('.dialog-box-user-list-block').css('height', scrheight - totalRest -60 +'px');
        $('.dialog-box-user-list-block').css('max-height', scrheight - totalRest -60 +'px');
    }

    // Пересчет стрелочки
    var dialog_id = $('.dialog-main-general-massage-box.dialog-fixed.active').attr('data-userid');
    if(dialog_id){        
        if($('.dialog_box_show.active[data-userid="'+dialog_id+'"]').hasClass('active')){
            var id_button =$('.dialog_box_show.active[data-userid="'+dialog_id+'"]');
            arrow_offset(id_button);
        }        
        if( $('.dialog_group_show.active[data-userid="'+dialog_id+'"]').hasClass('active') ){
            var id_button =$('.dialog_group_show.active[data-userid="'+dialog_id+'"]');
            arrow_offset(id_button);                
        }        
    }
}

$(document).ready(function(){
    getUserlistHeight();
});
$(window).resize(function(){
    getUserlistHeight();
});

// user list resize end

// tabs begin
$(document).ready(function() {
    $('#switcher-all').click(function(){
        Chat.closeAllWindows();
        $(this).addClass('active');
        $('#dialog-box-contenttab-all').addClass('active');
        $('.filter-online-favorite').removeClass('active');
        if($(this).hasClass('active')){
            $('#dialog-box-contenttab-last').removeClass('active');
            $('#switcher-last').removeClass('active');
        }
        Chat.refreshAll('refresh');
        $('.star').parent().parent().show();
    });

    
    $('#switcher-last').click(function(){
         Chat.closeAllWindows();
         $('.filter-online-favorite').removeClass('active');
        $(this).addClass('active');
        $('#dialog-box-contenttab-last').addClass('active');
        if($(this).hasClass('active')){
            $('#dialog-box-contenttab-all').removeClass('active');
            $('#switcher-all').removeClass('active');
        }
        Chat.GetLastDialogs('refrash');
        $('.star').parent().parent().show();
    });
});
// tabs end

// tooltip begin

$(document).ready(function() {
    $('.tooltip').tooltipster({
        position: 'bottom',
        animation: 'grow',
        touchDevices: false,
        delay: 1000
    });
    $('.tooltip.left').tooltipster({
        position: 'left'
    });
});

// tooltip begin end

// serch field append begin
function serchClose(){
    $( "#search_add_contact" ).animate({
        width: 1
    }, 250, function() {
        $( "#search_add_contact" ).hide();
        $( "#search_add_freands" ).hide();        
        $('#dialog-box-section-navy-list').show();
        $('.dialog-box-content .active').show();
        
        $('.dialog-box-serch-results').hide();
    });
}
// serch field append begin
function serchCloseAny(){   
    $( "#dialog-box-appending-serch-any" ).animate({
        width: 1
    }, 250, function() {
        $( "#dialog-box-appending-serch-any" ).hide();
        $('#dialog-box-section-navy-list').show();
        $('#dialog-box-contenttab-all .dialog-box-user-list-item').show();
        $('.dialog-box-serch-results').hide();
    });
}

function search_opener(){
    $('#dialog-box-appending-serch').show();
    $('#dialog-box-contenttab-all .dialog-box-user-list-item').hide();    
    $('.dialog-box-serch-results').show();
    
    $( "#dialog-box-appending-serch" ).animate({
        width: 210
    }, 250, function() {
        $('#dialog-box-section-navy-list').hide();
        $(document).keyup(function(e){
            if(e.which == 27)
            {
                serchClose();
            }
        });
    });
}
function search_opener_new(){
    $('#dialog-box-appending-serch-any').show();
    $('#dialog-box-contenttab-all .dialog-box-user-list-item').hide();
    $('.dialog-box-serch-results').show();
    $( "#dialog-box-appending-serch-any" ).animate({
        width: 210
    }, 250, function() {
        $('#dialog-box-section-navy-list').hide();
        $(document).keyup(function(e){
            if(e.which == 27)
            {
                serchCloseAny();
            }
        });
    });
}
// window hide begin(расширение окна с пользователями)
$(document).ready(function() {
    $('.dialog-box-condition-btn').click(function(){
        if($(this).hasClass('active')){
            $('.dialog-box-condition-btn').removeClass('active');
            $('.general-dialog-box').removeClass('active');
            $('.dialog-main-general-massage-box').css('right', 251 +'px');
            $('.dialog-selector-arrow').css('right', 243 +'px');
            getUserlistHeight();
        }else{
            $('.dialog-box-condition-btn').addClass('active');
            $('.general-dialog-box  ').addClass('active');
            $('.dialog-main-general-massage-box').css('right', 72 +'px');
            $('.dialog-selector-arrow').css('right', 64 +'px');
            getUserlistHeight();
            Chat.closeAllWindows();
        }
    });
});
// window hide begin

// add to choosen begin

$(document).ready(function() {
    /*
    $('.dialog-box-onclick-activated').click(function(){
        if($(this).hasClass('active')){
            $('.dialog-box-onclick-activated').removeClass('active');
        }else{
            $('.dialog-box-onclick-activated').removeClass('active');
            $(this).addClass('active');
        }
    });
    */
});


// add to choosen end
/*
// general mp chat opener begin
function chat_gd(item){
    if(item=='hide'){
        $('#dialog_main_general_massage_box_button').removeClass('active');
        $('#dialog_main_general_massage_box').removeClass('active');
    }else if(item=='show'){
        $('#dialog_main_general_massage_box_button').addClass('active');
        $('#dialog_main_general_massage_box').addClass('active');
    }
}

$(document).ready(function() {
    $('#dialog_main_general_massage_box_button').click(function(){
        if($(this).hasClass('active')){
            chat_gd('hide');
        }else{
            chat_gd('show');
        }
    });
});
*/

// general mp chat opener end
/*
// count massge arrow offset begin
$(document).ready(function() {
    $('.dialog-box-user-list-item').click(function(e){
        if ($(e.target).hasClass('dialog-box-onclick-activated')) {
            // избранное
            return false;
        }else{
            var arrowOset = $(this).position().top;
            $('.dialog-selector-arrow').css('top', arrowOset + 14 +'px');
            $('.dialog-main-general-massage-box.user-own-dialog').css('top', arrowOset +'px');
        }
    });
});
// count massge arrow offset end


*/


// При нажатии на юзера или чат выводится dialog-main-general-massage-box
/*
function show_dialog_chat(user_id){
    //делаю сообщения просмотренными
    Chat.makeMessagesOfUserRead(user_id);
    $('#dialog_main_chat').attr('data-userid',user_id);
        Chat.getDialogWithUser(user_id);
    $('#dialog_main_chat').addClass('active');
}
*/
function hide_dialog_chat(data_userid){
    $('#dialog_main_chat').removeClass('active');
    $('.dialog_box_show[data-userid="'+data_userid+'"]').removeClass('active');
    dragable_all_destroy();
}

/* Вычесление расположения стрелочки относительно кнопки */
function arrow_offset(id_button){
    var dialog_id = id_button.attr('data-userid');
    var arrowOset = id_button.offset().top;
    var height_dialog = 440;
    if($('#dialog_groups_chat').hasClass('active')){
        height_dialog = $('#dialog_groups_chat').height();
    }
    var height_windows = $(window).height();
    // Выводится для Общего чата

    $('.dialog-main-general-massage-box.dialog-fixed.active .dialog-selector-arrow').css('top', arrowOset + 14 +'px');
    $('.dialog-main-general-massage-box.dialog-fixed.active .dialog-selector-arrow').show();

    if((height_windows - height_dialog - arrowOset) > 0){
        $('.dialog-main-general-massage-box.dialog-fixed.active').css('bottom','auto');
        $('.dialog-main-general-massage-box.dialog-fixed.active').css('top', arrowOset +'px');
    }else{
        $('.dialog-main-general-massage-box.dialog-fixed.active').css('bottom','0');
        $('.dialog-main-general-massage-box.dialog-fixed.active').css('top', 'auto');
    }
    
    // При нажатии на кнопку ">"
    if($('.dialog-box-condition-btn').hasClass('active')){
        $('.dialog-selector-arrow').css('right', 64 +'px');
    }else{
        $('.dialog-selector-arrow').css('right', 243 +'px');
    }
    
}
/* Вычесление расположения стрелочки относительно кнопки */
function arrow_hideoffset(){
    $('.dialog-main-general-massage-box.dialog-fixed.active .dialog-selector-arrow').hide();
    $('.dialog-main-general-massage-box.dialog-fixed.active').css('bottom','auto');
    $('.dialog-main-general-massage-box.dialog-fixed.active').css('top', 0);
}



/* click на пользователя  в блоке ВСЕ */
$(document).ready(function() {
    $('#dialog-box-contenttab-all .dialog_box_show').click(function(){        
        var id_button = $(this);
        var user_id = id_button.attr('data-user');        
        Chat.ButtonClick(id_button, user_id);
    });
})


/* Edit name dialog group begin */
function show_dialog_group_form(id){
    var id_form = $('#'+id);
    if($('#'+id).hasClass('active')){
        $('#'+id).removeClass('active')
    }else{
        $('#'+id).addClass('active')
        //alert(1);
    }
}
/* Edit name dialog group end */

// Перенос пользователя в группу
/*
 id - id кнопки
 sortable_id  - id блока куда переносим id '#dialog_groups_spisok_new'
 destroy - удаляем или нет
*/
function dragable_all_list(id, sortable_id){
    $(id).draggable({
        connectToSortable: sortable_id,
        helper: "clone",
        //revert: true ,
        helper: function( event ) {
            var img = $(this).clone();
            var id = $('.dialog_box_show',img).attr('data-userid');
            $('.dialog-box-user-list-name',img).remove();
            $('.num.active',img).remove();
            $('.dialog-box-user-choosen-block',img).remove();
            $('.dialog-box-user-choosen-block',img).remove();
            // Кнопка для того чтоб убрать пользовате с чата
            $(img).append('<div class="active-bl" onclick="Chat.DeleteMemberFromGrop(' + id +', $(this))"><i class="dialog-box-icon cansel">icon</i></div>');
            return img;
        },
        start: function() {

        },
        drag: function() {
            // потащил
        },
        stop: function( event, ui ) {
            var user_id = $(' .dialog_box_show',ui.helper).attr('data-userid');
            var group_id = $('#dialog_groups_chat_new').attr('data-grop-id');
            Chat.addUsertoGroup(user_id,group_id);
            //Group.refreshCurrerntMembers();
        }
    });
    $(sortable_id).sortable({
        revert: false
    });

    $('#draggable_id').val(id);
    $('#sortable_id').val(sortable_id);

    console.log($('#draggable_id').val());
    console.log($('#sortable_id').val());
}
function dragable_all_destroy(){
    var draggable_id = $('#draggable_id').val();
    var sortable_id = $('#sortable_id').val();
    if(sortable_id !=='' ){
        $(draggable_id).draggable( "destroy" );
        $(sortable_id).sortable( "destroy" );
        $('#draggable_id').val('');
        $('#sortable_id').val('');
    }
}

/* drag and drop on groups begin */
$(document).ready(function() {
    /* Активация для перетаскивания
    $('#dialog_groups_spisok_new').sortable({
        revert: false
    });
    dragable_all_list('#dialog-box-contenttab-all div.dialog-box-user-list-item')*/

})
/* drag and drop on groups end */


/* drag and drop dialog-main-general-massage-box begin
$(document).ready(function() {
    $('.dialog-main-general-massage-box.user-own-dialog').draggable({
        start: function() {
            $(' .dialog-selector-arrow',this).hide()
            $(this).removeClass('dialog-fixed');
        },
        drag: function() {
            console.log($(this).attr('data-userid'));
        },
        stop: function() {
            console.log($(this).attr('data-userid'));
        }

    });

});
/* drag and drop dialog-main-general-massage-box end */


