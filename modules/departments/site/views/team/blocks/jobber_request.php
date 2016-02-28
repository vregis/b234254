<?php use \modules\departments\site\controllers\TeamController;?>
<div class="deps-wrap">
    <div class="roww action">
        <div data-id="1" class="item background-1">
            <button data-toggle="collapse" data-target="#idea" aria-expanded="false" aria-controls="idea" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="2" class="item background-2">
            <button data-toggle="collapse" data-target="#strategy" aria-expanded="false" aria-controls="strategy" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="3" class="item background-3">
            <button data-toggle="collapse" data-target="#customers" aria-expanded="false" aria-controls="customers" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="4" class="item background-4">
            <button data-toggle="collapse" data-target="#documents" aria-expanded="false" aria-controls="docs" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="5" class="item background-5">
            <button data-toggle="collapse" data-target="#products" aria-expanded="false" aria-controls="products" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="6" class="item background-6">
            <button data-toggle="collapse" data-target="#numbers" aria-expanded="false" aria-controls="numbers" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="7" class="item background-7">
            <button data-toggle="collapse" data-target="#computers" aria-expanded="false" aria-controls="it" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="8" class="item background-8">
            <button data-toggle="collapse" data-target="#people" aria-expanded="false" aria-controls="team" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
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
    <?php $business = TeamController::getJobberRequest($dep->id, $_GET['id']);?>
    <?php if($business):?>
<div class="collapse fade" id="<?php echo $dep->icons?>" >
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
            <th width="85">Apply</th>
            <th width="85">Reject</th>
        </tr>
        </thead>
        <tbody id="user_request">



            <?php foreach($business as $bus):?>
            <tr class="user-row" data-page-id="0" style="">
                <td>
                    <img class="gant_avatar" onError="this.onerror=null;this.src='/images/avatar/nophoto.png';" src="<?php echo $bus->ava != ''?$folder_assets = Yii::$app->params['staticDomain'] .'avatars/'.$bus->ava:'/images/avatar/nophoto.png'?>" height="33" style="margin:0;">
                </td>
                <?php if(!$bus->fname && !$bus->lname):?>
                    <td>User</td>
                <?php else:?>
                    <td><?php echo ($bus->fname)?$bus->fname:''?> <?php echo ($bus->lname)?$bus->lname:''?></td>
                <?php endif;?>
                <td>40</td>
                <td>15</td>
                <td>4</td>
                <td>2</td>
                <td>1</td>
                <td><button class="btn btn-primary circle btn-chat"><i class="ico-chat"></i></button></td>
                <td><button style="font-size: 10px;" class="btn btn-success circle"><i class="ico-check1"></i></button></td>
                <td><button style="font-size: 10px;" class="btn btn-danger circle"><i class="ico-delete"></i></button></td>
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