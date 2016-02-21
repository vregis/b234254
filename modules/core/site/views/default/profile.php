<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<?php $this->registerCssFile("/css/profile.css");?>
<?php $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"); ?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>
<?php $this->registerJsFile("/js/ajaxform.js");?>
<?php $this->registerJsFile("/js/global/index.js"); ?>
<?php $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2.min.css"); ?>
<?php $this->registerCssFile("/metronic/theme/assets/global/plugins/select2/css/select2-bootstrap.min.css"); ?>
<?php $this->registerCssFile("/plugins/jquery-typeahead-2.3.2/dist/jquery.typeahead.min.css"); ?>

<?php $this->registerJsFile("/js/min/jquery.mask.min.js"); ?>

<?php use yii\helpers\Html;?>
<?php use yii\widgets\ActiveForm; ?>
<?php use yii\helpers\ArrayHelper; ?>
<?php use \modules\user\models\Country; ?>
<?php use \modules\departments\models\Specialization; ?>
<?php use \modules\tests\models\TestUser; ?>
<?php use modules\core\widgets\Flash;?>
<?php use \modules\departments\models\Department;?>
<?php use \modules\tests\models\TestResult;?>
<?php use \modules\user\models\User;?>
<?php //use kartik\social\FacebookPlugin;?>
<?php //use kartik\social\TwitterPlugin;?>
<?
$this->registerJsFile("/plugins/jquery-typeahead-2.3.2/dist/jquery.typeahead.min.js");
$this->registerJsFile("/js/core/ajaxModel/DynamicData.js");
$this->registerJsFile("/js/core/profile/ServiceData.js");
$this->registerJsFile("/js/core/profile/SkillData.js");
$this->registerJsFile("/js/core/profile/LanguageData.js");
$education_class = $educationData->main_class;
$language_class = $languageData->main_class;
$service_class = $serviceData->main_class;
$skill_class = $skillData->main_class;
$msgJs = <<<JS
$( document ).ready(function() {
new DynamicData('$education_class');
//new DynamicData('$language_class');
new ServiceData('$service_class');
new SkillData('$skill_class');
new LanguageData('$language_class');
});
JS;
$this->registerJs($msgJs);
?>
<?= Flash::widget(['view' => '@modules/core/widgets/views/dialog']) ?>
<!-- BEGIN Portlet PORTLET-->
<div class="well" style="margin-top:30px; max-width:1024px; margin:auto;">
    <div class="container-fluid">
        <div class="row title">
            <div class="col-sm-6">
                <table>
                    <tr>
                        <td width="139">
                            <div class="profile-userpic">
                                <img style="height:134px; width:134px;margin-right:22px;" src="<?php echo $model->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$model->avatar:'/images/avatar/nophoto.png'?>" class="img-responsive avatar_image" alt="">
                                <?php $file = new \modules\user\models\Avatar();?>
                                <?php $form = ActiveForm::begin(['action'=>'/core/changeavatar', 'options' => ['enctype' => 'multipart/form-data', 'class'=>'avatar']]) ?>
                                <?= $form->field($file, 'file')->fileInput(['style'=>'', 'class'=>'upload'])->label(false) ?>
                                <?php ActiveForm::end() ?>
                                <!--<input class="upload" type="file" name="avatar" style="opacity:0; height:134px; width:134px; left:43px; top:0px; position:absolute;">-->
                                <input type="text" class="status_name" style="display:none"><i class="fa fa-check upd_status" style="display:none"></i><i class="del_status fa fa-close" style="display:none"></i>
                            </div>
                        </td>
                        <td>
                            <div class="col-sm-12">
                                <?= $form->field($model, 'first_name')->textInput(['placeholder'=>'First name', 'class'=>'form-control'])->label(false); ?>
                            </div>
                            <div class="col-sm-12">
                                <?= $form->field($model, 'last_name')->textInput(['placeholder'=>'Last name', 'class'=>'form-control'])->label(false); ?>
                            </div>
                            <div class="col-sm-12">
                                <?= $form->field($model, 'status')->textInput(['placeholder'=>'My motto', 'class'=>'form-control'])->label(false); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-4 col-sm-offset-2">
                <div class="form-group">
                    <?php $res = TestUser::find()->where(['user_id' => Yii::$app->user->getId()])->one();?>
                    <?php if(isset($res) && $res->is_finish == 1):?>
                    <button class="btn btn-primary btn-block btn-test-result result_btn">Test results</button>
                    <?php else:?>
                    <button class="btn btn-primary btn-block btn-test-result result_btn">Take a test</button>
                    <?php endif;?>
                    <button style="line-height: 37px !important;" class="btn dropdown-toggle settings circle btn-primary" data-toggle="dropdown" aria-expanded="false">
                    <i class="ico-settings"></i>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li style="text-align:center; padding-top:10px"><button class="btn btn-primary" data-toggle="modal" href="#basic">Change Password</button></li>
                        <li class="divider"> </li>
                        <li style="text-align:center; padding-top:10px"><button style="width:142px" class="btn btn-primary" data-toggle="modal" href="#privacy">Privacy Settings</button></li>
                        <li class="divider"> </li>
                       <!-- <li class="check">
                            <span>Show test results</span><div><input class="shows" name="show_test_result" <?php echo $model->show_test_result == 1?'checked':''?>  type="checkbox"></div>
                        </li>
                        <li class="divider"> </li>
                        <li class="check">
                            <span>Show contacts</span><div><input name="show_contacts" class="shows" <?php echo $model->show_contacts == 1?'checked':''?> type="checkbox"></div>
                        </li>
                        <li class="divider"> </li>
                        <li class="check">
                            <span>Show social network</span><div><input name="show_socials" class="shows" <?php echo $model->show_socials == 1?'checked':''?> type="checkbox"></div>
                        </li>-->
                        <?php if(Yii::$app->user->id == 25 || Yii::$app->user->id == 155): // clear test from admin?>
                        <li class="divider"> </li>
                        <li class="check">
                            <a href="/tests/clear">Reset test</a>
                        </li>
                <?php endif;?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <?php $countrylist = Country::findBySql('SELECT * FROM geo_country gc ORDER BY id=1 DESC, title_en ASC')->all();?>
                    <select class="form-control selectpicker country" name="ProfileForm[country_id]" style="position:relative">
                        <option class="start" value="0">Select country</option>
                        <?php foreach($countrylist as $c):?>
                        <option <?php echo $c->id == $model->country_id?'selected':''?> value="<?php echo $c->id?>"><?php echo $c->title_en?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom: 8px;">
                    <div class="row">
                        <div class="col-sm-9"> <?= $form->field($model, 'city_title')->textInput(['placeholder'=>'City', 'class'=>'form-control'])->label(false); ?></div>
                        <div class="col-sm-3" style="padding-left:0;"><?= $form->field($model, 'zip')->textInput(['placeholder'=>'ZIP', 'class'=>'form-control'])->label(false); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <hr style="margin-top: 0;">
        <div class="body">
            <div style="display:none" class="services row">
                <?php $user = User::find()->where(['id' => Yii::$app->user->id])->one();?>
                <?php $j = 0;?>
                <?php if(empty($testData)): // Steve without test result?>
                    <?php $departments = Department::find()->all();?>
                    <?php foreach($departments as $dep):?>
                        <?php $status = \modules\departments\models\UserDo::find()->where(['department_id' => $dep->id, 'user_id' => Yii::$app->user->id])->one();?>
                        <?php if($status && $status->status_show == 1):?>
                            <?php $in = ''?>
                        <?php else:?>
                            <?php $in = 'in'?>
                        <?php endif;?>
                        <?php if($status && $status->status_sell == 1):?>
                            <?php $class_sell = 'active';?>

                        <?php else:?>

                            <?php $class_sell = ''?>
                        <?php endif;?>
                        <?php if($j <= 7):?>
                        <?php $tResult = TestResult::find()->where(['department_id' => $dep->id])->one();?>
                        <?php $j++;?>
                        <div class="col-sm-12">
                            <div class="panel-group accordion" aria-multiselectable="true" data-department="<?php echo $dep->id?>" id="accordion<?=$j;?>">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <div class="accordion-toggle collapsed" style="background-color:<?php echo $tResult->color?>">
                                                <!--<div class="do"> <a style="color:<?php echo $tResult->color?>" class="check <?php echo $j==1?'active':'';?>" data-toggle="collapse" href="#collapse_3_<?php echo $j?>" aria-expanded="true"><i class="ico-check"></i></a>DO</div>-->
                                                <div class="do sell"> <a style="color:<?php echo $tResult->color?>" class="sell_department check <?php echo $class_sell?><?php //echo $j==1?'active':'';?>" data-toggle="collapse" href="#collapse_3_<?php echo $j?>" aria-expanded="true"><i class="ico-check"></i></a>Sell your skills</div>
                                                <div class="icon"><i class="ico-<?php echo $dep->icons?>"></i></div>
                                                <div class="text">
                                                    <?php $str = $tResult->title_medium; ?>
                                                    <?php $title = explode(' ', $str);?>
                                                    <div class="hui1"><?php echo $title[0]?></div>
                                                    <div class="hui2"><?php echo $tResult->name; ?></div>
                                                </div>
                                            </div>
                                        </h4>
                                    </div>
                                    <div id="collapse_3_<?php echo $j?>" class="panel-collapse collapse <?php echo $in?>" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body background-<?php echo $j?>">
                                            <div class="col-md-8 col-md-offset-2 service-heading">
                                                <div class="row">
                                                        <div class="col-sm-5" style="padding: 0;padding-left: 12px;">Specialty</div>
                                                        <div class="col-sm-4" style="padding-left: 24px;">Level</div>
                                                        <div class="col-sm-3" style="padding: 0;padding-left: 12px;">Rate / h</div>
                                                </div>
                                            </div>
                                            <div class="service serv-<?php echo $dep->id; ?>">
                                                <?php echo $serviceData->render()?>
                                                <!---->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php endif;?>
                    <?php endforeach;?>
                <?php else:?>
                    <?php $i = 0;?>
                <?php foreach($testData as $t):?>
                        <?php $status = \modules\departments\models\UserDo::find()->where(['department_id' => $t['result']['department_id'], 'user_id' => Yii::$app->user->id])->one();?>
                        <?php if($status && $status->status_do == 1):?>
                            <?php $class_do = 'active';?>
                        <?php else:?>
                            <?php $class_do = ''?>
                        <?php endif;?>
                        <?php if($status && $status->status_sell == 1):?>
                            <?php $class_sell = 'active';?>
                        <?php else:?>
                            <?php $class_sell = ''?>
                        <?php endif;?>
                        <?php if($status && $status->status_show == 1):?>
                            <?php $in = '';?>
                        <?php else:?>
                            <?php $in = 'in'?>
                        <?php endif;?>
                            <?php $i++;?>
                            <?php if($user->user_type ==1): // Steve with test result?>
                                <div class="col-sm-12">
                                    <div class="panel-group accordion" aria-multiselectable="true" data-department="<?php echo $t['result']['department_id']?>" id="accordion<?=$i;?>">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <div class="accordion-toggle collapsed" style="background-color:<?php echo $t['result']['color']?>">
                                                        <div class="do sell"> <a style="color:<?php echo $t['result']['color']?>" class="sell_department check <?php echo $class_sell?>" data-toggle="collapse" href="#collapse_3_<?php echo $i?>" aria-expanded="true"><i class="ico-check"></i></a>Sell your skills</div>
                                                        <?php $dep = Department::find()->where(['id' => $t['result']['department_id']])->one();?>
                                                        <div class="icon"><i class="ico-<?php echo $dep->icons?>"></i></div>
                                                        <div class="text">
                                                            <?php $str = $t['result']['title_medium']; ?>
                                                            <?php $title = explode(' ', $str);?>
                                                            <div class="hui1"><?php echo $title[0]?></div>
                                                            <div class="hui2"><?php echo $t['result']['name']; ?></div>
                                                        </div>
                                                    </div>
                                                </h4>
                                            </div>
                                            <div id="collapse_3_<?php echo $i?>" class="panel-collapse collapse <?php echo $in?>" aria-expanded="false" style="height: 0px;">
                                                <div class="panel-body background-<?php echo $i?>">
                                                    <div class="col-md-8 col-md-offset-2 service-heading">
                                                        <div class="row">
                                                            <div class="col-sm-5" style="padding: 0;padding-left: 12px;">Specialty</div>
                                                            <div class="col-sm-4" style="padding-left: 24px;">Level</div>
                                                            <div class="col-sm-3" style="padding: 0;padding-left: 12px;">Rate / h</div>
                                                        </div>
                                                    </div>
                                                    <div class="service serv-<?php echo $dep->id; ?>">
                                                        <?php echo $serviceData->render()?>
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: // Lucy with test result?>
                            <?php if($i <= 8):?>
                            <div class="col-sm-12">
                                <div class="panel-group accordion" aria-multiselectable="true" data-department="<?php echo $t['result']['department_id']?>" id="accordion<?=$i;?>">
                                    <div class="panel panel-default">
                                        <?php if($status && $status->status_do == 1):?>
                                            <?php $class_do = 'active';?>
                                        <?php else:?>
                                            <?php $class_do = ''?>
                                        <?php endif;?>
                                        <?php if($status && $status->status_sell == 1):?>
                                            <?php $class_sell = 'active';?>
                                        <?php else:?>
                                            <?php $class_sell = ''?>
                                        <?php endif;?>
                                        <?php if($status && $status->status_show == 1):?>
                                            <?php $in = ''?>
                                        <?php else:?>
                                            <?php $in = 'in'?>
                                        <?php endif;?>
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <div class="accordion-toggle collapsed" style="background-color:<?php echo $t['result']['color']?>">

                                                    <div class="do"> <a style="color:<?php echo $t['result']['color']?>" class="do_department check <?php echo $class_do?>" ><i class="ico-check"></i></a>Do</div>
                                                    <div class="do sell"> <a style="color:<?php echo $t['result']['color']?>" class="sell_department check <?php echo $class_sell?>" data-toggle="collapse" href="#collapse_3_<?php echo $i?>" aria-expanded="true"><i class="ico-check"></i></a>Sell your skills</div>
                                                    <?php $dep = Department::find()->where(['id' => $t['result']['department_id']])->one();?>
                                                    <div class="icon"><i class="ico-<?php echo $dep->icons?>"></i></div>
                                                    <div class="text">
                                                        <?php $str = $t['result']['title_medium']; ?>
                                                        <?php $title = explode(' ', $str);?>
                                                        <div class="hui1"><?php echo $title[0]?></div>
                                                        <div class="hui2"><?php echo $t['result']['name']; ?></div>
                                                    </div>
                                                </div>
                                            </h4>
                                        </div>
                                        <div id="collapse_3_<?php echo $i?>" class="panel-collapse collapse <?php echo $in;?>" aria-expanded="false" style="height: 0px;">
                                            <div class="panel-body background-<?php echo $t['result']['department_id']?>">
                                                <div class="col-md-8 col-md-offset-2 service-heading">
                                                    <div class="row">
                                                        <div class="col-sm-5" style="padding: 0;padding-left: 12px;">Specialty</div>
                                                        <div class="col-sm-4" style="padding-left: 24px;">Level</div>
                                                        <div class="col-sm-3" style="padding: 0;padding-left: 12px;">Rate / h</div>
                                                    </div>
                                                </div>
                                                <div class="service serv-<?php echo $t['result']['department_id']; ?>">
                                                    <?php echo $serviceData->render()?>
                                                    <!---->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php endif;?>
                <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>
        <hr>
        <div class="row" style="margin-right: 0;"><?= $languageData->render() ?></div>
        <hr>
        <div class="row" style="margin-right: 0;">
            <div class="col-md-5" style="padding-right:0;">
                <div class="contact_show">
                    <h3 style="margin-left: 57px;">Contacts</h3>
                    <div class="row">
                        <div class="col-md-2" ><img src="/images/phone.png"></div>
                        <div class="col-md-10" style="padding-bottom: 10px;padding-left: 0;">
                            <?= $form->field($model, 'phone')->textInput(['placeholder'=>'Phone', 'class'=>'form-control'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><img src="/images/skype.png"></div>
                        <div class="col-md-10" style="padding-bottom: 10px;padding-left: 0;">
                            <?= $form->field($model, 'skype')->textInput(['placeholder'=>'Skype', 'class'=>'form-control'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><img src="/images/lin.png"></div>
                        <div class="col-md-10" style="padding-bottom: 10px;padding-left: 0;">
                            <?= $form->field($model, 'social_ln')->textInput(['placeholder'=>'Link to your account', 'class'=>'form-control'])->label(false); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><img src="/images/mail.png"></div>
                        <div class="col-md-10" style="padding-bottom: 10px;padding-left: 0;">
                            <?= $form->field($model, 'email')->textInput(['placeholder'=>'Email', 'class'=>'form-control mail_check'])->label(false); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7" style="padding-right: 0;">
                <h3 style="margin-left:12px;">About me</h3>
                <div class="col-md-12" style="padding-left: 0;padding-right: 0;">
                    <?= $form->field($model, 'about')->textArea(['rows' => '6', 'style'=>'height: 212px;resize:none;'])->label(false) ?>
                </div>
            </div>
        </div>
        <hr style="margin-top:0px">
        <div class="form-group row">
            <div class="col-md-12">
                <table style="width:100%">
                    <tr>
                        <td style="padding-right:1em;">
                            <table style="width:100%">
                                <tr>
                                    <td><img style="margin: 0 8px 0 0;" src="/images/tw.png"></td>
                                    <td>
                                    <?= Html::activeTextInput($model, 'social_tw', ['placeholder' => 'Link to your account', 'class' => 'form-control']); //echo FacebookPlugin::widget(['type'=>FacebookPlugin::SHARE, 'settings' => ['appId' => '1558782291101766', 'secret' => '2472333477808e624445ec2c8d1ac45a', 'data-href' => '/user/login']]); ?>
                                        <?php //echo TwitterPlugin::widget(['type'=>TwitterPlugin::SHARE, 'settings' => ['size'=>'large', 'url' => 'ss', 'data-related' => 'http://www.argophilia.com/news/wp-content/uploads/2012/09/rope.jpg']]);?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td style="padding-right:1em;">
                            <table style="width:100%">
                                <tr>
                                    <td><img style="margin: 0 8px 0 0;" src="/images/fb.png"></td>
                                    <td><?= Html::activeTextInput($model, 'social_fb', ['placeholder' => 'Link to your account', 'class' => 'form-control']); ?></td>
                                </tr>
                            </table>
                        </td>
                        <td style="padding-right:1em;">
                            <table style="width:100%">
                                <tr>
                                    <td><img style="margin: 0 8px 0 0;" src="/images/gp.png"></td>
                                    <td><?= Html::activeTextInput($model, 'social_gg', ['placeholder' => 'Link to your account', 'class' => 'form-control']); ?></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table style="width:100%">
                                <tr>
                                    <td><img style="margin: 0 8px 0 0;" src="/images/inst.png"></td>
                                    <td><?= Html::activeTextInput($model, 'social_in', ['placeholder' => 'Link to your account', 'class' => 'form-control']); ?></td>
                                    <?php if(isset($_GET['first']) && $_GET['first'] == 1):?>
                                        <input type="hidden" name = 'is_first' value = '1'>
                                    <?php else:?>
                                        <input type="hidden" name = 'is_first' value = '0'>
                                    <?php endif;?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="pull-left">
                    <a target="_blank" href="/user/social/shared-profile?id=<?php echo Yii::$app->user->id?>" class="btn btn-primary share" style="margin-top: 15px;width:100px;margin-left:200px;">Share</a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-success save" style="margin-top: 15px;width:100px;margin-right:200px;">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Change password</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Old password</label>
                <input type="text" class="form-control old_pass">
            </div>
            <div class="form-group">
                <label>New password</label>
                <input type="text" class="form-control new_pass">
            </div>
            <div class="form-group">
                <label>Confirm new password</label>
                <input type="text" class="form-control conf_pass">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary change_pass">Save changes</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<div class="modal fade" id="privacy" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Privacy Settings</h4>
            </div>
            <div style="text-align:center" class="modal-body">
                    <div class="form-group">
                        <label style="text-align:left"><img style="margin:5px" width="20" src="/images/phone.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_phone == 1?'checked':''?> id="show_phone" class="form-control show_soc">
                    </div>
                    <div class="form-group">
                        <label><img width="20" style="margin:5px" src="/images/skype.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_skype == 1?'checked':''?> id="show_skype" class="form-control show_soc">
                    </div>
                    <div class="form-group">
                        <label><img width="20" style="margin:5px" src="/images/mail.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_mail == 1?'checked':''?> id="show_mail" class="form-control show_soc">
                    </div>
                    <div class="form-group">
                        <label><img width="20" style="margin:5px" src="/images/tw.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_tw == 1?'checked':''?> id="show_tw" class="form-control show_soc">
                    </div>
                    <div class="form-group">
                        <label><img width="20" style="margin:5px" src="/images/fb.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_fb == 1?'checked':''?> id="show_fb" class="form-control show_soc">
                    </div>
                    <div class="form-group">
                        <label><img width="20" style="margin:5px" src="/images/gp.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_gg == 1?'checked':''?> id="show_gg" class="form-control show_soc">
                    </div>
                    <div class="form-group">
                        <label><img width="20" style="margin:5px" src="/images/inst.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_in == 1?'checked':''?> id="show_in" class="form-control show_soc">
                    </div>
                    <div class="form-group">
                        <label><img width="20" style="margin:5px" src="/images/lin.png"> Show it in profile</label>
                        <input type="checkbox" <?php echo $model->show_ln == 1?'checked':''?> id="show_ln" class="form-control show_soc">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="status" tabindex="-1" role="status" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Change status</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Enter new status</label>
                <input type="text" style="text-align:left" value="<?php echo $model->status!=null?$model->status:'Status'; ?>" class="form-control status">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary change_status" data-dismiss="modal">Save changes</button>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<?php $this->registerJsFile("/js/profile.js");?>
<script>

    $(function () {
        $('.page-content').mCustomScrollbar({
            setHeight: $('.page-content').css('minHeight'),
            theme:"dark"
        });
        $('.services.row').fadeIn(1000);
    })


    $(document).on('change', '.upload', function () {
        $('form.avatar').ajaxSubmit(function (response) {
            response = JSON.parse(response);
            if (response.error == true) {
                alert(response.msg);
            } else {
                $.ajax({
                    url: '/core/getimage',
                    type: 'post',
                    dataType: 'json',
                    async: false,
                    success: function (response) {
                        if (response.image == '') {
                            $('.avatar_image').attr('src', '/images/avatar/nophoto.png');
                        } else {
                            $('.avatar_image').attr('src', '<?php echo Yii::$app->params['staticDomain']?>avatars/' + response.image);
                        }
                    }
                })
            }
        });
    })

    $(document).on('click', '.show_soc', function(){
        var field = $(this).attr('id');
        var value = $(this).prop('checked');
        $.ajax({
            url: '/core/privacy-settings',
            type: 'post',
            dataType: 'json',
            data: {field:field, value:value},
            success: function(){

            }
        })
    })

</script>