<?php use modules\departments\site\controllers\TeamController;?>
<div class="deps-wrap">
    <div class="roww action">
        <?php foreach($departments as $dep):?>
            <?php $business = TeamController::getJobberRequest($dep->id, $_GET['id']);?>
            <?php $do = TeamController::getDoDepartment($_GET['id'], $dep->id);
            ?>

            <?php if($do):?>
                <div data-id="<?php echo $dep->id?>" class="item background-<?php echo $dep->id?>">
                    <a target="_blank" href="/user/social/shared-profile?id=<?php echo $do->user_id?>"><img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="<?php echo $do->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$do->avatar:'/images/avatar/nophoto.png'?>" data-original-title="" title=""></a>
                </div>
            <?php else: ?>

                <?php $deleg = TeamController::getDelegateDepartment($_GET['id'], $dep->id);
                ?>
                <?php if($deleg):?>
                    <div data-id="<?php echo $dep->id?>" class="item background-<?php echo $dep->id?>">
                        <a target="_blank" href="/user/social/shared-profile?id=<?php echo $deleg->user_id?>"><img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="<?php echo $deleg->avatar != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$deleg->avatar:'/images/avatar/nophoto.png'?>" data-original-title="" title=""></a>
                    </div>
                <?php else:?>
                    <div data-id="<?php echo $dep->id?>" class="item background-<?php echo $dep->id?>">
                        <button data-toggle="collapse" data-target="#<?php echo $dep->icons?>1" aria-expanded="false" aria-controls="idea" class="btn btn-primary circle"><i class="ico-add"></i></button>
                    </div>
                <?php endif;?>



            <?php endif;?>
        <?php endforeach?>
    </div>
    <div class="roww deps">
        <div data-id="1" href="javascript:;" class="item background-1">Idea<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="2" href="javascript:;" class="item background-2">Strategy<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="3" href="javascript:;" class="item background-3">Customers<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="4" href="javascript:;" class="item background-4">Documents<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="5" href="javascript:;" class="item background-5">Products<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="6" href="javascript:;" class="item background-6">Numbers<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="7" href="javascript:;" class="item background-7">IT<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="8" href="javascript:;" class="item background-8">Team<div class="arrow" style="left: 50%;"></div></div>
    </div>
</div>

<?php foreach($departments as $dep):?>

    <?php $array = TeamController::getJobberTasks($dep->id, $_GET['id']);?>

    <?php if(isset($array)):?>

        <?php $req = TeamController::getJobberRequests($dep->id, $_GET['id']);?>

<div class="collapse fade" id="<?php echo $dep->icons?>1">
    <table class="table table-bordered with-foot" style="width:100%;">
        <thead>
        <tr>
            <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
            <th width="300">Founder</th>
            <th width="125">Milestones</th>
            <th width="85">Tasks</th>
            <th width="85">New</th>
            <th width="85">Active</th>
            <th width="85">Completed</th>
            <th width="85">Chat</th>
            <th style="width:85px !important;" width="85" class="stat-toggle">Request</th>
        </tr>
        </thead>
        <tbody id="user_request">
        <tr class="user-row" data-page-id="0" style="">
            <td>
                <img class="gant_avatar" src="/images/avatar/nophoto.png" height="33" style="margin:0;">
            </td>
            <?php if(!$array['user']->first_name && !$array['user']->last_name):?>
                <td>User</td>
            <?php else:?>
                <td><?php echo ($array['user']->first_name)?$array['user']->first_name:''?> <?php echo ($array['user']->last_name)?$array['user']->last_name:''?></td>
            <?php endif;?>
            <td><?php echo $array['milestones']?></td>
            <td><?php echo $array['tasks']?></td>
            <td><?php echo $array['tasks_new']?></td>
            <td><?php echo $array['tasks_active']?></td>
            <td><?php echo $array['tasks_complete']?></td>
            <td><button class="btn btn-primary circle btn-chat"><i class="ico-chat"></i></button></td>
            <td style="width:85px !important;">
                <?php if($req):?>
                    <?php if($req->status == 1):?>
                    <?php else:?>
                        <button data-dep="<?php echo $dep->id?>" data-sender-id="<?php echo $array['user']->user_id?>"  class="btn btn-danger circle del_request_jobber"><i class="ico-delete"></i></button>
                    <?php endif;?>
                    <?php else: ?>
                    <button data-dep="<?php echo $dep->id?>" data-sender-id="<?php echo $array['user']->user_id?>"  class="btn btn-primary circle add_request_jobber"><i class="ico-add"></i></button>
                <?php endif;?>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="10" style="border-right:0;height: 50px;">
            </th>
        </tr>
        </tfoot>
    </table>

</div>

<?php endif;?>

<?php endforeach; ?>

<script>
    $('.add_request_jobber').click(function(){
        var data = {
            dep_id: $(this).attr('data-dep'),
            sender_id: $(this).attr('data-sender-id'),
            tool_id: <?php echo $_GET['id']?>,
        }

        $.ajax({
            url: '/departments/team/add-jobber-request',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(){
                location.reload();
            }
        })
    })
</script>

<script>
    $('.del_request_jobber').click(function(){
        var data = {
            dep_id: $(this).attr('data-dep'),
            sender_id: $(this).attr('data-sender-id'),
            tool_id: <?php echo $_GET['id']?>,
        }

        $.ajax({
            url: '/departments/team/del-jobber-request',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(){
                location.reload();
            }
        })
    })
</script>
