/**
 * Created by toozzapc2 on 14.01.2016.
 */

function LanguageData(main_class) {
    var dynamicData = new DynamicData(main_class);

    var g_main_class = main_class;
    var g_point_class = '.' + main_class;



   /* $(document).on('change', g_point_class + ' select.update', function(){
        $(this).closest('div.update').find('.start').hide();
        var row = $(this).closest('div.dynamic-block');
        beforeUpdate(row);
        var parent = $(this);
        var id = row.attr('data-id');
        var update_key = $(this).attr('data-key');
        var update_data = $(this).val();

        var data = {
            command : 'update',
            id:id,
            update_key: update_key,
            update_data: update_data
        };
        $.ajax({
            url: '/core/' + g_main_class + '-ajax',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (response) {
                var row = parent.closest('div.dynamic-block');
                row.attr('data-id', response.id);
                var btn_del = row.find('.delete');
                if(btn_del.length > 0) {
                    btn_del.removeClass('delete');
                    btn_del.addClass('delete-ajax');
                }
                //_this.handlerUpdate.call(null,parent,response);
            }
        });
    });*/

    function beforeUpdate(row) {
        row.find('.disabled').each(function() {
            $(this).removeClass('disabled');
            $(this).find('.start').parent().remove();
        });
        row.find('select.update').each(function() {
            $(this).attr('disabled', false);
            $(this).find('.start').parent().remove();
            alert("asdasdas");
        });
        row.find('input.update').each(function() {
            $(this).attr('disabled', false);
        });
    }

}
LanguageData.prototype = DynamicData;

