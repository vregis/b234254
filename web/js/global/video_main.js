/**
 * Created by toozzapc2 on 14.12.2015.
 */
function open_popup(box, yt) {
    var width = $( window ).width();
    var height = width * 0.56;
    if(height > $( window ).height()) {
        var test = (35 + Math.round((height - $( window ).height()) / 2));
        $('.popup-close').css('top', test + 'px');
    } else {
        $('.popup-close').css('top', '35px');
    }
    if(!$(box+' iframe').length && yt) {
        $(box).append('<iframe id="yt" width="'+width+'" height="'+height+'" class="youtube-player" type="text/html" src="//www.youtube.com/embed/'+yt+'?rel=0&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>');
    }
    $(box+' .popup-close').html('<div class="popup-l1"></div><div class="popup-l2"></div>');
    if(width) $(box).css({'width': width, 'margin-left': -(width/2)});
    if(height) $(box).css({'height': height, 'margin-top': -(height/2)});
    else $(box).css('margin-top', -($(box).height()/2));
    $(box).show();
}
function close_popup(box) {
    $(box).hide();
    $(box + ' #yt').remove();
}

$( window ).resize(function() {
    var yt = $("#yt");
    var box = $('#box-2');
    if(yt.length > 0) {
        var width = $( window ).width();
        var height = width * 0.56;
        if(height > $( window ).height()) {
            var test = (35 + Math.round((height - $( window ).height()) / 2));
            $('.popup-close').css('top', test + 'px');
        } else {
            $('.popup-close').css('top', '35px');
        }
        yt.attr("width", width);
        yt.attr("height", height);
        if(width) box.css({'width': width, 'margin-left': -(width/2)});
        if(height) box.css({'height': height, 'margin-top': -(height/2)});
    }
});