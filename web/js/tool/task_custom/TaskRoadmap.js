/**
 * Created by toozzapc2 on 02.02.2016.
 */

function TaskRoadmap() {

    var input_roadmap = $('input[name=Roadmap]');
    input_roadmap.off();
    input_roadmap.on('click',function() {
        var page_checkbox = $(this).closest('.b-page-checkbox');
        var title = page_checkbox.find('.task-name').html();
        var desc = page_checkbox.find('.text-desc-task').html();
        $('#title-task').html(title);
        $('.task-body .block.desc .content .mCSB_container').html(desc);
    });
}