<?php use modules\departments\site\controllers\TeamController;?>
<?php foreach($departments as $dep): ?>
<div class="collapse fade" id="<?php echo $dep->icons?>">
    <table data-dep-id="<?php echo $dep->id?>" class="table table-bordered with-foot team-user-table" style="width:100%;">
        <thead>
        <tr>
            <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
            <th width="390">Name</th>
            <th width="290">Location</th>
            <th width="125">Chat</th>
            <th width="125">Invite</th>
        </tr>
        </thead>
        <tbody id="user_request">
        <?php $users = TeamController::getSearchUsers($dep->id);?>
        <?php if($users):?>
            <?php foreach($users as $us):?>
                <tr class="user-row" data-page-id="0" style="">
                    <td>
                        <a target="_blank" href="/user/social/shared-profile?id=<?php echo $us->dname?>">
                            <img onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" class="gant_avatar" src="<?php echo $us->ava != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$us->ava:'/images/avatar/nophoto.png'?>" height="33" style="margin:0;">
                        </a>
                    </td>
                    <?php if(!$us->fname && !$us->lname):?>
                        <td>User</td>
                    <?php else:?>
                    <td><?php echo ($us->fname)?$us->fname:''?> <?php echo ($us->lname)?$us->lname:''?></td>
                    <?php endif;?>
                    <td><?php echo ($us->country)?$us->country:''?> <?php echo ($us->city)?', '.$us->city:''?></td>
                    <td><button class="btn btn-primary circle btn-chat"><i class="ico-chat"></i></button></td>
                    <td><button data-id = '<?php echo $us->dname?>' class="btn btn-primary circle invite_user"><i class="ico-add"></i></button></td>
                </tr>
            <?php endforeach;?>
        <?php endif;?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="5" style="border-right:0;padding: 10px 12px;">
                <div class="pull-left">
                    <div id="invite-form" class="no-autoclose" style="display:none;">
                        <div class="form-group">
                            <input type="text" id="input-invite-email" class="form-control" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <textarea name="name" id="input-invite-offer" class="form-control" rows="8" cols="40" placeholder="Offer text"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="submit" id="invite-form-send" class="btn btn-primary">Send</button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <button class="btn btn-primary circle invite-by-email" data-toggle="popover">
                        <i class="ico-mail"></i>
                    </button>
                    Invite by email
                </div>
                <div class="pull-right">
                </div>
                <div class="clearfix"></div>
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

<?php endforeach; ?>
<script>
    $(function(){
        $('.invite_user').on('click', function(){
            var recipient = $(this).attr('data-id');
            var dep_id = $(this).closest('.team-user-table').attr('data-dep-id');
            var tool_id = <?php echo $_GET['id']?>;
                $.ajax({
                    url: '/departments/team/invite-user',
                    type: 'post',
                    data: {recipient:recipient, dep_id:dep_id, tool_id:tool_id},
                    dataType: 'json',
                    success: function(){

                    }
                })
        })
    })
</script>
