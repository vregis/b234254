/**
 * Created by toozzapc2 on 10.12.2015.
 */

function setText(block,_this) {
    block.html(_this.val());
}
var input_name = $('#idea-name');
var block_name = $('#ideablock-name');
input_name.change(function() {
    setText(block_name, $(this));
});
input_name.bind("keyup change", function(e) {
    setText(block_name, $(this));
});

var input_industry = $('#idea-industry_id');
var block_industry = $('#ideablock-industry');
input_industry.change(function() {
    $( "select option:selected" ).each(function() {
        if($(this).html() == '') {
            block_industry.html('');
        }
        else {
            block_industry.html($(this).html() + ' industry');
        }
    });
});

var input_like = $('#idea-description_like');
var block_like = $('#ideablock-like');
input_like.change(function() {
    setText(block_like, $(this));
});
input_like.bind("keyup change", function(e) {
    setText(block_like, $(this));
});

var input_problem = $('#idea-description_problem');
var block_problem = $('#ideablock-problem');
input_problem.change(function() {
    setText(block_problem, $(this));
});
input_problem.bind("keyup change", function(e) {
    setText(block_problem, $(this));
});

var input_planning = $('#idea-description_planning');
var block_planning = $('#ideablock-planning');
input_planning.change(function() {
    setText(block_planning, $(this));
});
input_planning.bind("keyup change", function(e) {
    setText(block_planning, $(this));
});