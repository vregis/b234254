<?php use modules\tasks\models\Task;?>
<?php use modules\tasks\models\TaskUser;?>
<?php use yii\helpers\Url;?>


<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 52px;"><a href="#" class="btn btn-primary circle static" style="margin:0;border:none !important;font-size: 24px;line-height: 42px !important;padding-left: 1px;padding-top: 1px;"><i class="ico-history"></i></a></th>
        <th width="260"> Business Name </th>
        <th style="width: 52px;"> <button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button> </th>
        <?php echo $filters?>
        <th width="100"> Total tasks </th>
        <th width="100"> My tasks </th>
    </tr>
    </thead>
    <tbody class="">


<?php $i = 0;?>
<?php $k = 0;?>
<? foreach($guestTools as $current_userTool) : ?>
    <?php $i++; ?>

    <?php if(!$current_userTool->name):?>
    <?php else:?>
        <?php $k++;?>
        <tr>
            <?
            $task_count = Task::find()
                ->join('JOIN','milestone','milestone.id = task.milestone_id')
                ->join('JOIN', 'department', 'department.id = task.department_id')
                ->where(['is_hidden' => '0','department.is_additional' => 0])
                ->count();
            $count_progress = TaskUser::find()->where(['user_tool_id' => $current_userTool->id,'status' => TaskUser::$status_active])->count();
            $count_completed = TaskUser::find()->where(['user_tool_id' => $current_userTool->id,'status' => TaskUser::$status_completed])->count();
            ?>
            <?php if($k > 5){ continue; } //TODO DELETE THIS!!!!!!!!!!?>
            <td>
                <a target ='_blank' href="<?= Url::toRoute(['/departments/business/shared-business','id' => $current_userTool->id]) ?>" style="padding-top: 1px;padding-left: 1px;" class="history btn btn-primary circle" data-toggle="popover" data-not_autoclose="1"><i class="ico-history"></i></a>
            </td>
            <td style="text-transform: uppercase">
                <a href="<?= Url::toRoute(['/departments/business/select-tool', 'id' => $current_userTool->id]) ?>"
                    <?php if(strlen($current_userTool->name) >37):?>
                        data-toggle="popover" data-placement="bottom" data-content="<?= $current_userTool->name ?>"
                    <?php endif;?>
                   style="display: block;width: 269px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"
                   class="name"
                ><?= $current_userTool->name ? $current_userTool->name : 'No name' ?> <!--<span class="label label-danger circle"></span>--></a>
            </td>
            <td>
                <a href="/user/social/shared-profile?id=<?php echo $current_userTool->user_id?>" target="_blank">
                    <img onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" style="margin:0;" class="active gant_avatar mCS_img_loaded" src="/images/avatar/nophoto.png" >
                </a>
            </td>
            <td>
                <?php echo $current_userTool->industry_name?>
            </td>
            <td>
                <?php echo $current_userTool->country?>
            </td>
            <td>
                <?php echo $task_count; ?>
            </td>
            <td>
                12
            </td>
        </tr>
        <div id="huistory<?php echo $i?>" class="huistory" style="display:none;">
            <a href="<?= Url::toRoute(['/departments/business/shared-business','id' => $current_userTool->id]) ?>" target="_blank">View Business</a>
            <a data-toggle="popover" class="delete<?php echo $i?> delete" href="javascript:;">Delete Business</a>
            <div id="delete-block" style="display: none;">
                Are you sure you want to delete <?php echo $current_userTool->name?> ?
                <br>
                <button class="btn btn-danger">
                    <i class="glyphicon glyphicon-remove"></i> No
                </button>
                <button class="btn btn-success" href="#" target="_self">
                    <i class="glyphicon glyphicon-ok"></i> <i class="icon-ok-sign icon-white"></i> Yes
                </button>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $(".dropmenu<?php echo $i?>.history").popover({
                    placement:"bottom",
                    html:true,
                    content:$("#huistory<?php echo $i?>"),
                    container:$("body"),
                    template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
                });
                $(".dropmenu<?php echo $i?>.history").on('show.bs.popover',function(){
                    $("#huistory<?php echo $i?>").show();
                    $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                }).on('hide.bs.popover',function(){
                    $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                });
            });
            $(".well > .nav-tabs li a").on('shown.bs.tab',function(){
                $(".dropmenu<?php echo $i?>.history").popover({
                    placement:"bottom",
                    html:true,
                    content:$("#huistory<?php echo $i?>"),
                    container:$("body"),
                    template:'<div class="popover dropselect1" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
                });
                $(".dropmenu<?php echo $i?>.history").on('show.bs.popover',function(){
                    $("#huistory<?php echo $i?>").show();
                    $(".huistory a.team").popover({
                        container: 'body',
                        placement: "right",
                        html:true,
                        template:'<div class="popover delegation" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
                        content : 'Will be available in the next version'
                    });
                    $(".huistory a.delete").click(function(){
                        var delBlock = $(this).next('#delete-block');
                        var toHide = $(this).parent().find('a');
                        delBlock.show();
                        toHide.hide();
                        delBlock.find(".btn-success").click(function(){
                            document.location.href = '<?php echo Url::toRoute(['/departments/business/delete','id' => $current_userTool->id]);?>';
                        });
                        delBlock.find(".btn-danger").click(function(){
                            delBlock.hide();
                            toHide.show();
                        });
                    });
                    $(this).find('.fa').removeClass("fa-angle-down").addClass('fa-angle-up');
                }).on('hide.bs.popover',function(){
                    $(this).find('.fa').removeClass("fa-angle-up").addClass('fa-angle-down');
                });
            });


            $(".huistory a.delete<?php echo $i?>").click(function(){
                var delBlock = $(this).next('#delete-block');
                var toHide = $(this).parent().find('a');
                delBlock.show();
                toHide.hide();
                delBlock.find(".btn-success").click(function(){
                    document.location.href = '<?php echo Url::toRoute(['/departments/business/delete','id' => $current_userTool->id]);?>';
                });
                delBlock.find(".btn-danger").click(function(){
                    delBlock.hide();
                    toHide.show();
                });
            });

        </script>

    <?php endif;?>
<? endforeach; ?>

    </tbody>
</table>

<?php $countPage = ceil($allToolsCount/5);?>


<ul class="pagination">
    <? for($i = 1; $i<=$countPage;$i++): ?>
        <li class="<? echo $i==$current? 'active' : ''?>">
            <a class="go-page" data-page-id="<?php echo $i?>"> <?php echo $i ?> </a>
        </li>
    <? endfor; ?>
</ul>

<script>
    $(document).on('click', '.go-page', function(){
        var id = $(this).attr('data-page-id');
        var loc = $('select[name=location]').val();
        var ind = $('select[name=industry]').val();

        $.ajax({
            url: '/departments/business/pagination-business',
            data: {id:id, loc:loc, ind:ind},
            dataType: 'json',
            type: 'post',
            success: function(response){
                $('.dynamic_block').html(response.html);
                $(".selectpicker").selectpicker();
            }
        })
    })
</script>


