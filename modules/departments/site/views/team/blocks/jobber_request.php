<?php use \modules\departments\site\controllers\TeamController;?>
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
                        <button <?php echo (!$business['team'])?'onclick="return false"':''?> data-toggle="collapse" data-target="#<?php echo $dep->icons?>" aria-expanded="false" aria-controls="idea" class="btn btn-primary circle"><i class="ico-add"></i></button>
                    </div>
                <?php endif;?>



            <?php endif;?>
        <?php endforeach?>
    </div>
    <div class="roww deps">
        <?php foreach($departments as $dep):?>

        <div data-id="<?php echo $dep->id?>" href="javascript:;" class="item background-<?php echo $dep->id?>"><?php echo $dep->name?><div class="arrow" style="left: 50%;"></div></div>
        <?php endforeach; ?>
    </div>
</div>
<?php foreach($departments as $dep):?>
    <?php $business = TeamController::getJobberRequest($dep->id, $_GET['id']);?>
    <?php if($business['team']):?>
<div class="collapse fade" id="<?php echo $dep->icons?>" >
    <table class="table table-bordered with-foot tbl-dep" data-dep="<?php echo $dep->id?>" style="width:100%;">
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
            <th width="85">Apply</th>
            <th width="85">Reject</th>
        </tr>
        </thead>
        <tbody id="user_request">



            <?php foreach($business['team'] as $bus):?>
            <tr class="user-row" data-page-id="0" style="">
                <td>
                    <img class="gant_avatar" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" src="<?php echo $bus->ava != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$bus->ava:'/images/avatar/nophoto.png'?>" height="33" style="margin:0;">
                </td>
                <?php if(!$bus->fname && !$bus->lname):?>
                    <td>User</td>
                <?php else:?>
                    <td><?php echo ($bus->fname)?$bus->fname:''?> <?php echo ($bus->lname)?$bus->lname:''?></td>
                <?php endif;?>
                <td><?php echo $business['milestones']?></td>
                <td><?php echo $business['tasks']?></td>
                <td><?php echo $business['tasks_new']?></td>
                <td><?php echo $business['tasks_active']?></td>
                <td><?php echo $business['tasks_complete']?></td>
                <td><button class="btn btn-primary circle btn-chat"><i class="ico-chat"></i></button></td>
                <td><button data-user-id="<?php echo $bus->dname?>" style="font-size: 10px;" class="btn btn-success circle req_accept"><i class="ico-check1"></i></button></td>
                <td><button data-user-id="<?php echo $bus->dname?>" style="font-size: 10px;" class="btn btn-danger req_rejct circle"><i class="ico-delete"></i></button></td>
            </tr>
            <?php endforeach;?>

        </tbody>
        <tfoot>
        <tr>
            <th colspan="10" style="border-right:0;height: 50px;">
            </th>
        </tr>
        </tfoot>
    </table>
    <div id="chat" style="display: none;">
        <div class="block chat">
            <div class="content">
                <div class="ajax-content">
                    <div class="tab-content">
                        <div class="tab-pane" id="portlet_tab1">
                            <div class="scroller" style="height: 200px;">
                                <ol id="taskUserNotes">
                                    <li>
                                        sdasdas
                                    </li>
                                </ol>
                            </div>
                        </div>
                        <div class="tab-pane active" id="portlet_tab2">
                            <div class="scroller" style="height: 200px;">
                                <ul id="taskUserMessages">
                                    <div class="daySepar"><span>Thu, Feb 25</span><div class="line"></div></div>
                                    <li class="task-user-message my">
                                        <table>
                                            <tbody><tr>
                                                <td class="time">05:12 AM</td>
                                                <td style="width: 0px;"><div class="message">sadasdas</div></td>
                                            </tr>
                                            </tbody></table>
                                    </li>
                                    <li class="task-user-message">
                                        <table>
                                            <tbody><tr>
                                                <td style="width: 0px;"><div class="message">asdasdas</div></td>
                                                <td class="time">05:12 AM</td>

                                            </tr>
                                            </tbody></table>
                                    </li>
                                    <li class="task-user-message my">
                                        <table>
                                            <tbody><tr>
                                                <td class="time">05:12 AM</td>
                                                <td style="width: 0px;"><div class="message">asdasda</div></td>
                                            </tr>
                                            </tbody></table>
                                    </li>
                                    <div class="clearfix"></div>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-pane" id="portlet_tab3">
                            <div class="scroller" style="height: 200px;">
                                <ol id="taskUserLogs">
                                    <li>02/22/2016 <br>
                                        Task obtained    </li>
                                    <li>02/25/2016 <br>
                                        Task offered system    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <ul class="nav nav-tabs pull-right">
                    <li class="">
                        <a href="#portlet_tab1" data-toggle="tab" class="btn btn-primary circle" id="btn-tab-note" aria-expanded="false">
                            <span class="ico-edit"></span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="#portlet_tab2" data-toggle="tab" class="btn btn-primary circle" id="btn-tab-message" aria-expanded="true">
                            <span class="ico-chat"></span>
                        </a>
                        <span id="badge-chat" class="badge badge-danger"></span>
                    </li>
                    <li class="">
                        <a href="#portlet_tab3" data-toggle="tab" class="btn btn-primary circle" id="btn-tab-log" aria-expanded="false">
                            <span class="ico-history"></span>
                        </a>
                        <span id="badge-log" class="badge badge-danger"></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer">
            <div id="message-input" style="display: block;">
                <input type="text" id="textarea-task" class="form-control" placeholder="Put your message here...">
                <button onclick="return false" type="submit" class="btn btn-primary" data-task_user_id="266" id="btn-message">Send </button>
            </div>
        </div>
    </div>
</div>
    <?php endif;?>
<?php endforeach; ?>

<script>
    $('.req_rejct').on('click', function(){
        if(!confirm('Approve reject')){
            return false;
        }
        var tool_id = <?php echo $_GET['id']?>;
        var sender_id = $(this).attr('data-user-id');
        var dep_id = $(this).closest('.tbl-dep').attr('data-dep');

        $.ajax({
            url: '/departments/team/jobber-reject',
            type: 'post',
            dataType: 'json',
            data: {tool_id:tool_id, sender_id:sender_id, dep_id:dep_id},
            success: function(){
                location.reload(); //refactor this
            }
        })
    })

    $('.req_accept').on('click', function(){
        if(!confirm('Approve accept')){
            return false;
        }
        var tool_id = <?php echo $_GET['id']?>;
        var sender_id = $(this).attr('data-user-id');
        var dep_id = $(this).closest('.tbl-dep').attr('data-dep');

        $.ajax({
            url: '/departments/team/jobber-accept',
            type: 'post',
            dataType: 'json',
            data: {tool_id:tool_id, sender_id:sender_id, dep_id:dep_id},
            success: function(){
                location.reload(); //refactor this
            }
        })
    })


</script>
