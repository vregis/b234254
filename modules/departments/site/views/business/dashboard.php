<?
use modules\departments\models\Department;
use yii\helpers\Url;
$this->registerCssFile("/css/task.css");
?>

<div id="tool" data-tool-id="<?= $tool->id ?>" class="well well-sm task-bg">
    <div class="logo text-center">
        <a href="/"><img src="/images/logo-default.png" alt="logo" class="logo-default"></a> <span> Business Without BusYness </span>
    </div>
    <div class="idea">
        <div class="row">
            <div class="col-md-6">
                <div class="idea-name">
                    <?= $idea->name ?>
                </div>
                <div class="idea-description-like">
                    <?= $idea->description_like ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="idea-description-problem">
                    <?= $idea->description_problem ?>
                </div>
            </div>
        </div>

        <div class="title text-center" style="margin-top: 15px;">Do you like our idea?</div>
        <div class="step">
            <div class="question-name">
                <h4 class="left pull-left">No</h4>
                <h4 class="right pull-right">Yes</h4>
                <div class="clearfix"></div>
            </div>
            <div id="idea_like" class="form-md-radios md-radio-inline b-page-checkbox-wrap <?= !is_null($idea_like->like) ? 'disabled off' : '' ?>">
                <? for($i = 0; $i < 4; $i++) : ?>
                    <div class="md-radio has-test b-page-checkbox">
                        <input type="radio" id="IdeaLike[<?= $i ?>]" <?= !is_null($idea_like->like) ? 'disabled' : '' ?> name="IdeaLike" class="md-radiobtn" <? if(!is_null($idea_like->like) && $idea_like->like == $i) echo 'checked' ?> value="<?= $i ?>">
                        <label for="IdeaLike[<?= $i ?>]">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                        </label>
                    </div>
                <? endfor; ?>
                <div style="display:inline-block;width:100%;">
                </div>
            </div>
        </div>
    </div>
    <div class="benefits">
        <div class="benefits-name text-center">
            Our benefits
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="number"> 1 </div>
                <?= $benefit->first ?>
            </div>
            <div class="col-md-4">
                <div class="number"> 2 </div>
                <?= $benefit->second ?>
            </div>
            <div class="col-md-4">
                <div class="number"> 3 </div>
                <?= $benefit->third ?>
            </div>
        </div>
        <div class="title text-center" style="margin-top: 15px;">Do you like our benefits?</div>
        <div class="step">
            <div class="question-name">
                <h4 class="left pull-left">No</h4>
                <h4 class="right pull-right">Yes</h4>
                <div class="clearfix"></div>
            </div>
            <div id="benefit_like" class="form-md-radios md-radio-inline b-page-checkbox-wrap <?= !is_null($benefit_like->like) ? 'disabled off' : '' ?>">
                <? for($i = 0; $i < 4; $i++) : ?>
                    <div class="md-radio has-test b-page-checkbox">
                        <input type="radio" id="BenefitLike[<?= $i ?>]" <?= !is_null($benefit_like->like) ? 'disabled' : '' ?> name="BenefitLike" class="md-radiobtn" <? if(!is_null($benefit_like->like) && $benefit_like->like == $i) echo 'checked' ?> value="<?= $i ?>">
                        <label for="BenefitLike[<?= $i ?>]">
                            <span></span>
                            <span class="check"></span>
                            <span class="box"></span>
                        </label>
                    </div>
                <? endfor; ?>
                <div style="display:inline-block;width:100%;">
                </div>
            </div>
        </div>
    </div>
    <div class="our-team">
        <div class="our-team-name text-center">
            Our team
        </div>
        <div class="profile text-center">
            <div class="caption">Founder</div>
            <img  onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="gant_avatar" src="<?php echo $profile->avatar ? $folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$profile->avatar:'/images/avatar/nophoto.png'?>">
            <div class="field-name"><?= $profile->first_name && $profile->last_name ? $profile->first_name.' '.$profile->last_name : $user->email ?></div>
            <div class="location"><?= $profile->country ? $profile->country : '' ?><?= $profile->city_title ? ($profile->country ? ', ' : '').$profile->city_title : '' ?></div>
        </div>
        <div class="vacancy text-center">
            <? $i=0; ?>
            <?php foreach($test_result_inform as $t):?>
                <? if($i<6) : ?>
                    <? $dep_id = $t['result']['department_id']; ?>
                    <?php $dep = Department::find()->where(['id' => $t['result']['department_id']])->one();?>
                    <div class="do sell" style="background-color:<?php echo $t['result']['color']?>">
                        <i class="ico-<?= $dep->icons ?>"> </i>
                        <?php $str = $t['result']['title_medium']; ?>
                        <?php $title = explode(' ', $str);?>
                        <div class="hui1"><?php echo $title[0]?></div>
                    </div>
                    <? $i++; ?>
                <?php endif;?>
            <?php endforeach;?>

            <button onclick="if(!$(this).hasClass('disabled')) document.location.href='<?= Url::toRoute(['/departments/business']) ?>'" class="btn btn-success"> Join us </button>
        </div>
    </div>
    <div class="comments">
        <div class="comments-title">Comments</div>
    </div>
</div>

<script>
    $( document ).ready(function() {
        var input_idea_like = $('input[name=IdeaLike]');
        input_idea_like.on('click',function() {
            if(!$(this).is('[disabled]')) {
                $.ajax({
                    url: '/departments/business/idea-like',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _csrf: $("meta[name=csrf-token]").attr("content"),
                        like: $(this).val(),
                        tool_id: $('#tool').attr('data-tool-id')
                    },
                    success: function (response) {
                        input_idea_like.attr('disabled', 'disabled');
                        input_idea_like.closest('.b-page-checkbox-wrap').addClass('disabled off');
                    }
                });
            }
        });
        var input_benefit_like = $('input[name=BenefitLike]');
        input_benefit_like.on('click',function() {
            if(!$(this).is('[disabled]')) {
                $.ajax({
                    url: '/departments/business/benefit-like',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        _csrf: $("meta[name=csrf-token]").attr("content"),
                        like: $(this).val(),
                        tool_id: $('#tool').attr('data-tool-id')
                    },
                    success: function (response) {
                        input_benefit_like.attr('disabled', 'disabled');
                        input_benefit_like.closest('.b-page-checkbox-wrap').addClass('disabled off');
                    }
                });
            }
        });
    });
</script>