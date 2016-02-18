
function makeMarkOnPlayer(that){
    if(that.hasClass('active')){
        that.removeClass('active');
          $(' .input_game_text',that).val('*');
    }else{
        that.addClass('active');
        //испортить инпут
        var real = $(' .input_game_text',that).attr('data-id');        
        $(' .input_game_text',that).val(real);
    }
    
}function makeMarkOnPlayerCancel(that){
    if(that.hasClass('active')){
        that.removeClass('active');
          $(' .input_game_text',that).val('*');
    }else{
        $('.player_name',that).html('Пользователь уже состоит в команде.');

    }

}