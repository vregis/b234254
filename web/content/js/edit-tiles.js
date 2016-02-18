/**
 * Created by toozzapc2 on 26.10.2015.
 */
$(document).ready(function () {

    var body = $('body'),
        csrf_token = $("meta[name=csrf-token]").attr("content"),
        loadingFlag = false;

    var Width1;
    var Height1;
    var cropTop1;
    var cropLeft1;
    var cropWidth1;
    var cropHeight1;

    var Width2;
    var Height2;
    var cropTop2;
    var cropLeft2;
    var cropWidth2;
    var cropHeight2;

    var Width3;
    var Height3;
    var cropTop3;
    var cropLeft3;
    var cropWidth3;
    var cropHeight3;

    cropresizer.getObject("photo1").init({
        cropWidth : 490,
        cropHeight : 300,
        onUpdate : function() {
            if(this.crop) {
                Width1 = this.iWidth;
                Height1 = this.iHeight;
                cropTop1 = this.cropTop - this.iTop;
                cropLeft1 = this.cropLeft - this.iLeft;
                cropWidth1 = this.cropWidth;
                cropHeight1 = this.cropHeight;
            }
        }
    });
    cropresizer.getObject("photo2").init({
        cropWidth : 475,
        cropHeight : 200,
        onUpdate : function() {
            Width2 = this.iWidth;
            Height2 = this.iHeight;
            cropTop2 = this.cropTop - this.iTop;
            cropLeft2 = this.cropLeft - this.iLeft;
            cropWidth2 = this.cropWidth;
            cropHeight2 = this.cropHeight;
        }
    });
    cropresizer.getObject("photo3").init({
        cropWidth : 230,
        cropHeight : 200,
        onUpdate : function() {
            Width3 = this.iWidth;
            Height3 = this.iHeight;
            cropTop3 = this.cropTop - this.iTop;
            cropLeft3 = this.cropLeft - this.iLeft;
            cropWidth3 = this.cropWidth;
            cropHeight3 = this.cropHeight;
        }
    });

    /**
     * Кнопка "Сохранить"
     */

    body.on('click', '#edit-title-button-save', function (e) {
        e.preventDefault();

        var self = $(this);

        if (!loadingFlag) {
            loadingFlag = true;
            jpreloader('hide');

            $.ajax({
                type: 'POST',
                url: self.attr('data-url'),
                dataType: 'json',
                data: {
                    'Width1': Width1,
                    'Height1': Height1,
                    'cropTop1': cropTop1,
                    'cropLeft1': cropLeft1,
                    'cropWidth1': cropWidth1,
                    'cropHeight1': cropHeight1,
                    'Width2': Width2,
                    'Height2': Height2,
                    'cropTop2': cropTop2,
                    'cropLeft2': cropLeft2,
                    'cropWidth2': cropWidth2,
                    'cropHeight2': cropHeight2,
                    'Width3': Width3,
                    'Height3': Height3,
                    'cropTop3': cropTop3,
                    'cropLeft3': cropLeft3,
                    'cropWidth3': cropWidth3,
                    'cropHeight3': cropHeight3,
                    '_csrf': csrf_token
                },
                cache: false,
                beforeSend: function () {
                    jpreloader('show');
                },
                success: function (data) {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                    else {
                        system_dialog('Отображение не сохранилось');
                        loadingFlag = false;
                        jpreloader('hide');
                    }
                }
            });
        }
    });
});