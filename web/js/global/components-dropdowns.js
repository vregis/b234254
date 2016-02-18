var ComponentsDropdowns = function () {

    var handleBSSelect = function (select) {
        if(select.val() == "1") {
            select.selectpicker('setStyle', 'bs-select-but-high', 'remove');
            select.selectpicker('setStyle', 'bs-select-but-medium', 'remove');
            select.selectpicker('setStyle', 'bs-select-but-low');
        }
        else if(select.val() == "2") {
            select.selectpicker('setStyle', 'bs-select-but-low', 'remove');
            select.selectpicker('setStyle', 'bs-select-but-high', 'remove');
            select.selectpicker('setStyle', 'bs-select-but-medium');
            select.selectpicker('render');
        }
        else if(select.val() == "3") {
            select.selectpicker('setStyle', 'bs-select-but-low', 'remove');
            select.selectpicker('setStyle', 'bs-select-but-medium', 'remove');
            select.selectpicker('setStyle', 'bs-select-but-high');
            select.selectpicker('render');
        }
    };

    var handleBootstrapSelect = function() {
        var select = $('.bs-select');
        select.change(function() {
            handleBSSelect(select);
        });
        select.selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
        handleBSSelect(select);
    };

    var handleQuestion = function (select) {
        if(select.val() == "1") {
            select.selectpicker('setStyle', 'question-select-but-high1', 'remove');
            select.selectpicker('setStyle', 'question-select-but-medium1');
            select.selectpicker('render');
        }
        else if(select.val() == "2") {
            select.selectpicker('setStyle', 'question-select-but-medium1', 'remove');
            select.selectpicker('setStyle', 'question-select-but-high1');
            select.selectpicker('render');
        }
    };

    var handleQuestionSelect = function() {
        var select = $('.question-select');
        select.change(function() {
            handleQuestion($(this));
        });
        select.selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check'
        });
        handleQuestion(select);
    };

    function hideAllSelect() {
        $('.field-task-specialization_id').each(function( index ) {
            $( this).attr('hidden',true);
            $( this).find('#task-specialization_id').attr('disabled',true);
        });

    }

    var handleSpecializationSelect = function() {
        var select_department = $('#task-department_id');
        select_department.change(function() {
            hideAllSelect();
            var id = $(this).val();
            if(id != '') {
                var specialization_field = $('#specialization-field-' + id);
                specialization_field.removeAttr('hidden');
                specialization_field.find('#task-specialization_id').removeAttr('disabled');
            }
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            handleBootstrapSelect();
            handleQuestionSelect();
            handleSpecializationSelect();
        }
    };

}();