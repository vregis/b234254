<?php use \modules\user\models\Languagelist;?>
<?php use \modules\user\models\Skilllist;?>
<table class="table table-hover">
    <tr>
        <td>Mail</td>
        <td><?php echo $user->email?></td>
    </tr>
    <tr>
        <td>First Name</td>
        <td><?php echo $profile->first_name?$profile->first_name:''?></td>
    </tr>
    <tr>
        <td>Last Name</td>
        <td><?php echo $profile->last_name?$profile->last_name:''?></td>
    </tr>
    <tr>
        <td>Test Results</td>
        <td>
            <?php if($profile->show_test_result == 1):?>
                <?php if($test_result):?>
                    <?php foreach($test_result as $res):?>
                        <?php echo $res->result?> = <?php echo $res->points?><br/>
                    <?php endforeach;?>
                <?php endif;?>
            <?php else:?>
                Access denied
            <?php endif;?>
        </td>
    </tr>
    <tr>
        <td>Specializations</td>
        <td>
            <?php if($special):?>
                <?php foreach($special as $spec):?>
                    Specialization: <?php echo $spec->name?><br/>
                    Department: <?php echo $spec->dname?><br/>
                    <?php if($spec->exp_type):?>
                        <?php $sk_lev = Skilllist::find()->where(['id'=>$spec->exp_type])->one();?>
                        <?php if($sk_lev):?>
                            Skill: <?php echo $sk_lev->name?>
                        <?php endif;?>
                    <?php endif;?>
                    <hr/>
                <?php endforeach;?>
            <?php endif;?>
        </td>
    </tr>
    <tr>
        <td>Idea</td>
        <td>
            <?php if($idea):?>
                Idea: <?php echo $idea->ideaname?> <br/>
                Industry:
                <?php if($idea->iname != NULL && $idea->iname != ''):?>
                    <?php echo $idea->iname; ?>
                <?php endif;?>
                <br/>
                description like: <?php echo $idea->description_like;?><br/>
                description problem: <?php echo $idea->description_problem;?><br/>
                description like: <?php echo $idea->description_planning;?><br/>
            <?php else:?>
                No idea No problem
            <?php endif;?><br/>
        </td>
    </tr>

    <tr>
        <td>Socials</td>
        <td>
            <?php if($profile->show_socials == 1):?>
                <?php if($profile->social_fb):?>
                    Facebook: <?php echo $profile->socials_fb?><br/>
                <?php endif;?>
                <?php if($profile->social_tw):?>
                    Twitter: <?php echo $profile->socials_tw?><br/>
                <?php endif;?>
            <?php else:?>
                Access Denied
            <?php endif;?>
        </td>
    </tr>
    <tr>
        <td>Contacts</td>
        <td>
            <?php if($profile->show_contacts == 1):?>
                <?php if($profile->phone):?>
                    Phone: <?php echo $profile->phone?>
                <?php endif;?>
                <?php if($profile->skype):?>
                    Skype: <?php echo $profile->skype?>
                <?php endif;?>
            <?php else:?>
                Access Denied
            <?php endif;?>
        </td>
    </tr>

    <tr>
        <td>Languages</td>
        <td>
            <?php if($language):?>
                <?php foreach(unserialize($language->language) as $lang):?>
                    Language: <?php echo $lang['name']?><br/>
                    <?php $level = Languagelist::find()->where(['id'=>$lang['skill']])->one();?>
                    <?php if(isset($level) && !empty($level)):?>
                        Level: <?php echo $level->name?><br/>
                    <?php endif;?>
                    <hr/>
                <?php endforeach;?>
            <?php endif;?>
        </td>
    </tr>

    <tr>
        <td>Skills</td>
        <td>
            <?php if($skills):?>
                <?php foreach(unserialize($skills->skillname) as $sk):?>
                    Skill: <?php echo $sk['name']?><br/>
                    <?php $skill_level = Skilllist::find()->where(['id'=>$sk['year']])->one();?>
                    <?php if(isset($skill_level) && !empty($skill_level)):?>
                        Level: <?php echo $skill_level->name?><br/>
                    <?php endif;?>
                    <hr/>
                <?php endforeach;?>
            <?php endif;?>
        </td>
    </tr>
</table>