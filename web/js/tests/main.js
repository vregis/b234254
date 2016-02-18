/**
 * Created by toozzapc2 on 24.11.2015.
 */
var ComponentsjQueryUISliders = function () {

    return {
        //main function to initiate the module
        init: function (count) {
            //range max

            $('#slider-range-0').slider({
                isRTL: Metronic.isRTL(),
                range: "max",
                min: 1,
                max: 4,
                value: 2,
                change: function (event, ui) {
                    var name = '#testprogress-0-option';
                    $(name).val(ui.value);
                }
            });
            $('#slider-range-1').slider({
                isRTL: Metronic.isRTL(),
                range: "max",
                min: 1,
                max: 4,
                value: 2,
                change: function (event, ui) {
                    var name = '#testprogress-1-option';
                    var input = $(name);
                    input.val('' + ui.value);
                }
            });
            $('#slider-range-2').slider({
                isRTL: Metronic.isRTL(),
                range: "max",
                min: 1,
                max: 4,
                value: 2,
                change: function (event, ui) {
                    var name = '#testprogress-2-option';
                    $(name).val(ui.value);
                }
            });
            $('#slider-range-3').slider({
                isRTL: Metronic.isRTL(),
                range: "max",
                min: 1,
                max: 4,
                value: 2,
                change: function (event, ui) {
                    var name = '#testprogress-3-option';
                    $(name).val(ui.value);
                }
            });
        }

    };

}();