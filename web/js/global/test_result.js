/**
 * Created by toozzapc2 on 27.12.2015.
 */


function resizePage() {

    
    var headerHeight = $('.page-header').outerHeight();
    var footerHeight = $('.page-footer').outerHeight();
    var titleHeight = $('.portlet-title').outerHeight(true);
    var nextHeight = $('.btn-next-wrapper').outerHeight(true);

    var height = App.getViewPort().height - headerHeight - footerHeight - titleHeight - nextHeight - 3*51;
    var heightResult = height / 9;
    if(heightResult < 40) {
        heightResult = 40;
    }

    $('.test-result').each(function() {
        var test_result = $(this);
        var test_desc = $(this).parent('.test-line').next('.collapse').find('.test-description');
        var widthResult = test_result.find(".name-cell").attr('aria-valuenow');;
        // test_result.find('.name-cell').css('height',heightResult + 'px');
        // test_result.find('.name-cell').css('lineHeight',heightResult + 'px');
        if($(window).width() < 1025){
            test_desc.css('width','100%');
        }else{
            test_desc.css('width',"calc("+widthResult + '% - 10px)');
        }
                test_result.find(".name-table").animate({
            width: widthResult + '%',
        }, 1000 );
        test_result.click(function() {
            var collapse = $('#collapse' + test_result.attr('id'));
            if(!collapse.hasClass('in')) {
                collapse.collapse('toggle');
                $('.collapse').each(function () {
                    if ($(this) != collapse) {
                        $(this).collapse('hide');
                    }
                });
            }
        });
    });

    
}
function loadPage() {
    resizePage();

    $('.test-result').each(function() {
        var test_result = $(this);
        var test_desc = $(this).parent('.test-line').next('.collapse').find('.test-description');
        var widthResult = test_result.find(".name-cell").attr('aria-valuenow');;
        
        if($(window).width() < 1025){
            test_desc.css('width','100%');
        }else{
            test_desc.css('width',"calc("+widthResult + '% - 10px)');
        }
        
        test_result.find(".name-table").animate({
            width: widthResult + '%',
        }, 1000 );

    });
    
}
$(document).ready(function(){
    $('.btn-next-wrapper .btn[data-toggle="popover"]').popover({
        placement: "right"
    });
});
$( document ).ready(loadPage);
$( window ).resize(resizePage);