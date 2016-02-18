/**
 * Created by toozzapc2 on 14.01.2016.
 */

function SkillData(main_class) {
    var dynamicData = new DynamicData(main_class);

    var g_main_class = main_class;
    var g_point_class = '.' + main_class;

    function setHandlerTags(elem) {
        if(elem == undefined) {
            elem = $('.user_v1-query');
        }
        else {
            elem = elem.find('.user_v1-query');
        }
        elem.each(function() {
            var _this = $(this);
            _this.typeahead({
                minLength: 1,
                order: "asc",
                dynamic: true,
                delay: 500,
                backdrop: {
                    "background-color": "#fff"
                },
                template: function (query, item) {
                    return '{{name}}';
                },
                source: {
                    user: {
                        display: "name",
                        url: [{
                            type: "POST",
                            url: "/core/default/skills",

                            data: {
                                q: "{{query}}"
                            }
                        }, "data"]
                    }
                },
                callback: {
                    onClick: function (node, a, item, event) {

                        node.val(item.name);
                        node.change();
                        // You can do a simple window.location of the item.href
                        return true;
                    },
                    onSendRequest: function (node, query) {
                        console.log('request is sent, perhaps add a loading animation?')
                    },
                    onReceiveRequest: function (node, query) {
                        console.log('request is received, stop the loading animation?')
                    }
                },
                debug: true
            });
        })

    }

    dynamicData.handlerAdd = function(elem,response) {
        setHandlerTags(elem);
    };

    setHandlerTags();
}
SkillData.prototype = DynamicData;

