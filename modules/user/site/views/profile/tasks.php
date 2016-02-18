<style>
    .s_high{
        background-color:red;
        color:black;
        height:25px;
        width:25px;
        padding-top:5px;
        font-weight:bold;
        border-radius: 30px!important;
        text-align:center;
    }
    .s_medium{
        background-color:yellow;
        color:black;
        height:25px;
        width:25px;
        padding-top:5px;
        font-weight:bold;
        border-radius: 30px!important;
        text-align:center;
    }
    .s_low{
        background-color:gray;
        color:black;
        height:25px;
        width:25px;
        padding-top:5px;
        font-weight:bold;
        border-radius: 30px!important;
        text-align:center;
    }

    .cent {
        padding-left:26px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <!-- Begin: life time stats -->
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption tools pull-left">
                    <a href="javascript:;" class="collapse"><?=$this->title?></a>
                </div>
                <div class="actions">
                    <!--    <a href="/admin/<?=$this->context->module->id?>/create" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
								<span class="hidden-480">
								New task </span>
                    </a> -->
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">
                                ID&nbsp;#
                            </th>
                            <th width="5%" style="text-align:center; position:relative">
                                <i class="fa fa-chevron-down" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li class="sort_priority act" data-p = 'all' style="text-align:center; padding-top:10px; cursor:pointer">All</li>
                                    <li class="sort_priority" data-p = '3' style="text-align:center; padding-top:10px; cursor:pointer">High</li>
                                    <li class="sort_priority" data-p = '2' style="text-align:center; padding-top:10px; cursor:pointer">Medium</li>
                                    <li class="sort_priority" data-p = '1' style="text-align:center; padding-top:10px; cursor:pointer">Low</li>
                                    <li class="divider"> </li>


                                </ul>
                            </th>
                            <th>
                                Name
                            </th>
                            <th style="position:relative">
                                Specialization
                                <i class="fa fa-chevron-down" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu pull-right" style="height: 200px; overflow-y:scroll" role="menu">
                                    <li class="sort_spec act1" data-p = 'all' style="text-align:center; padding-top:10px; cursor:pointer">All</li>
                                    <?php foreach($spec as $s):?>
                                        <li class="sort_spec" data-p = '<?php echo $s->id?>' style="text-align:center; padding-top:10px; cursor:pointer"><?php echo $s->name?></li>
                                    <?php endforeach;?>
                                    <li class="divider"> </li>


                                </ul>
                            </th>
                            <th>
                                Suggested time
                            </th>
                            <th>
                                Market Rate
                            </th>
                            <th width="15%">
                                Activity
                            </th>
                        </tr>
                        </thead>
                        <tbody class="ajaxbody">
                        <?php foreach($tasks as $t):?>
                        <tr role="row" >
                            <td>
                                <?php echo $t->id?>
                            </td>
                            <td style="text-align:center;" class="cent">
                                <?php if($t->priority == 3):?>
                                <div class="s_high">H</div>
                                <?php elseif($t->priority == 2):?>
                                <div class="s_medium">M</div>
                                <?php else:?>
                                <div class="s_low">L</div>
                                <?php endif;?>
                            </td>
                            <td>
                               <?php echo $t->name?>
                            </td>
                            <td>
                                <?php $spec = \modules\departments\models\Specialization::find()->where(['id' => $t->specialization_id])->one();?>
                                <?php echo  $spec->name; ?>
                            </td>
                            <td>
                                <?php echo $t->recommended_time?>h
                            </td>
                            <td>
                                <?php echo $t->market_rate?>$</td>
                            <td>
                                active
                            </td>
                        </tr>

                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
</div>

<script>
    $(function(){
        $(document).on('click', '.sort_priority', function() {
            var type = $(this).data('p');
            $('.act').removeClass('act');
            $(this).addClass('act');
            var last = $('.act1').data('p');
            $.ajax({
                url: '/user/profile/sortpriority',
                type: 'post',
                dataType: 'json',
                data: {type:type, last:last},
                success: function (response) {
                    $('.ajaxbody').html(response.html);
                }
            })
        })

        $(document).on('click', '.sort_spec', function() {
            $('.act1').removeClass('act1');
            $(this).addClass('act1');
            var type = $(this).data('p');
            var last = $('.act').data('p');
            $.ajax({
                url: '/user/profile/sortspec',
                type: 'post',
                dataType: 'json',
                data: {type:type, last:last},
                success: function (response) {
                    $('.ajaxbody').html(response.html);
                }
            })
        })

    })
</script>