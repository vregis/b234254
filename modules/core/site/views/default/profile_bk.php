<?php use yii\widgets\ActiveForm; ?>
<?php use yii\helpers\ArrayHelper; ?>


    <style>
        .profile-usertitle {
            text-align: center;
            margin-top: 20px;
        }

        .profile-usertitle-name {
            color: #5a7391;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .profile-userpic img {
            float: none;
            margin: 0 auto;
            width: 50%;
            height: 50%;
            -webkit-border-radius: 50%!important;
            -moz-border-radius: 50%!important;
            border-radius: 50%!important;
        }
    </style>

    <div style="background:#eef1f5" class="col-md-3">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light" style="margin-top:20px">
            <div class="portlet-body">
                <div class="slimScrollDiv" style="position: relative;"><div class="scroller" >
                        <div class="profile-userpic">
                            <img src="/metronic/theme/assets/layouts/layout3/img/avatar10.jpg" class="img-responsive" alt=""> </div>
                        <div style="text-align:center" class="profile-usertitle">
                            <div class="profile-usertitle-name"> Marcus Doe </div>
                            <button type="button" class="btn btn-primary change_ava">Change avatar</button>
                        </div>

                    </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 115.942px; background: rgb(161, 178, 189);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; display: none; background: yellow;"></div>
                </div>
            </div>
        </div>

        <div class="portlet light" style="margin-top:20px">
            <div class="portlet-body">
                <?php $form = ActiveForm::begin(['action' => '/core/saveprofile']) ?>
                <!--<div class="form-body">
                        <div class="form-group">
                            <?= $form->field($model, 'phone')->textInput(['placeholder'=>'+1 646 580 DEMO (6284)', 'class'=>'form-control']); ?>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <?= $form->field($model, 'skype')->textInput(['placeholder'=>'marcus.doe7', 'class'=>'form-control']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <?= $form->field($model, 'social_tw')->textInput(['placeholder'=>'@marcusdoe7', 'class'=>'form-control']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'social_fb')->textInput(['placeholder'=>'marcusdoe777', 'class'=>'form-control']); ?>
                        </div>
                        <div class="form-group">
                            <?= $form->field($model, 'email')->textInput(['placeholder'=>'marcusdoe@gmail.com', 'class'=>'form-control']); ?>
                        </div>
                    </div>-->
            </div>
        </div>


        <!-- END Portlet PORTLET-->
    </div>
    <div class="col-md-9" style="background:#eef1f5">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light" style="margin-top:20px">
            <div class="portlet-title">
                <div class="caption font-blue-sharp">
                    <span class="caption-subject bold uppercase"> Profile account</span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <?php $form = ActiveForm::begin(['action' => '/core/saveprofile']) ?>
                <div class="form-group">
                    <?= $form->field($model, 'first_name')->textInput(['placeholder'=>'John', 'class'=>'form-control']); ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'last_name')->textInput(['placeholder'=>'Doe', 'class'=>'form-control']); ?>
                </div>
                <div class="two_inputs">
                    <div class="col-md-6 form-group">
                        <?= $form->field($model, 'country_id')
                            ->dropDownList(
                                ArrayHelper::map(\modules\user\models\Country::find()->all(), 'id', 'title_en')
                            )
                        ?>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input type="text" class="form-control" placeholder="City">
                    </div>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'about')->textArea(['rows' => '9']) ?>
                </div>
                <div class="form-group">
                    <?= $form->field($model, 'website')->textInput(['placeholder'=>'http://www.website.com', 'class'=>'form-control']); ?>
                </div>
                <div class="educations">
                    <div class="one_ed">
                        <div class="education col-md-6">
                            <div class="form-group col-md-6">
                                <input type="text" name = 'skill1' class="form-control">
                            </div>
                            <div class="form-group col-md-5">
                                <input type="text" name = 'year1' class="form-control">
                            </div>
                            <div class="form-group col-md-1">
                                <span data-c = '2' class="plus">+</span>
                            </div>
                        </div>
                    </div>
                </div>



                <script>
                    $(function(){
                        $(document).on('click', '.plus', function(){
                            var id = $('.plus').data('c');
                            $.ajax({
                                url: '/core/addeducation',
                                method: 'post',
                                dataType: 'json',
                                data: {id:id},
                                success: function(response){
                                    if(response.error == false){
                                        $('.educations').append(response.html);
                                        $('.plus').each(function(){
                                            $(this).data('c', id+1);
                                        })
                                    }else{
                                        alert('Something wrong, please try again');
                                    }
                                }
                            })
                        })
                    })
                </script>




                <div class="form-actions right" style="text-align:right">
                    <button type="button" class="btn btn-primary">Share profile</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn default">Cancel</button>
                </div>
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>

<?php ActiveForm::end() ?>