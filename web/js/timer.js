
$(function(){
    var data = {
        _csrf: $("meta[name=csrf-token]").attr("content")
    };
    $.ajax({
        url: '/departments/get-new-task-number',
        method: 'post',
        dataType: 'json',
        data: data,
        success: function(response){
            $('label.label-danger.circle').hide();
            //if(response.ismy == true) {
                for (var i = 0; i < response.milestones.length; i++) {
                    var c = getCountById(response.milestones[i].milestone_id, response.milestones);
                    if(c != 0) {
                        $('#accordion' + response.milestones[i].milestone_id).find('.label-lg').find('span.label-danger').text(c);
                        $('#accordion' + response.milestones[i].milestone_id).find('.label-lg').find('span.label-danger').show();
                    }
                    //$('.ganttview-blocks').find('.label-danger').text('1');
                    $('#task-id-'+response.milestones[i].ava).find('.label-danger').text('1').show();
                    $('#task-'+response.milestones[i].ava).find('.label-danger').text('1').show();
                    console.log(response.milestones[i].ava);
                }
            //}
        }
    })



    function getCountById(id, object){
        var k = 0;
        for(var i=0; i<object.length; i++){
            if(object[i].milestone_id == id){
                k++;
            }
        }
        return k;
    }

    function getCountByUt(id, object){
        var k = 0;
        for(var i=0; i<object.length; i++){
            if(object[i].tool_id == id){
                k++;
            }
        }
        return k;
    }

    if(window.location.pathname.substr(1) == 'departments/business'){
        var data = {
            _csrf: $("meta[name=csrf-token]").attr("content")
        };
        $.ajax({
            url: '/departments/get-count-by-tool',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response){
                for (var i = 0; i < response.milestones.length; i++) {
                    var c = getCountByUt(response.milestones[i].tool_id, response.milestones);
                    $('#toolid-'+response.milestones[i].tool_id).find('span.label-danger').text(c).show();
                }
            }
        })
    }

    var data = {
        _csrf: $("meta[name=csrf-token]").attr("content")
    }

    $.ajax({
        url: '/departments/get-count-by-business',
        data: data,
        type: 'post',
        dataType:'json',
        success: function(response){
            if(response.tools != 'undefined' && response.tools > 0){
                $('.business-switch').find('.label-danger').text(response.tools).show();
            }
        }
    })


   /* var timerId = setInterval(function() {
        alert( "djh" );
    }, 2000);*/
})
function getus(id){
    $.ajax({
        url: '/departments/get-new-logs',
        type: 'post',
        dataType: 'json',
        data: {id:id},
        success: function(response){
            if(response.number > 0) {
                $('#badge-log').text(response.number);
            }
        }
    })
}