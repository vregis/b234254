<div class="task-body">
    <div class="col-full">
        <div class="block desc" style="border: none;">
            <div class="content" style="
    border-width: 1px;
    border-color: rgba(215, 215, 215, 0.7);
    border-style: solid;padding:0 15px;height:auto;overflow: auto; height:150px !important;border-radius:10px;">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade" id="videos">
                    <? foreach($task_videos as $task_video) : ?>
                        <a href="https://www.youtube.com/watch?v=<?= $task_video ?>" data-toggle="popover" data-content="&nbsp;" class="item" target="_blank">
                            <i class="ico-video"></i> <br>
                        </a>
                    <? endforeach; ?>
                    <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="audios">
                    <? foreach($files['audio'] as $file) : ?>
                        <a href="<?= $file['path'] ?>" class="item" data-toggle="popover" data-content="&nbsp;" target="_blank">
                            <i class="ico-sound"></i> <br>
                        </a>
                    <? endforeach; ?>
                    <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="photos">
                    <? foreach($files['photo'] as $file) : ?>
                        <a href="<?= $file['path'] ?>" data-toggle="popover" data-content="&nbsp;" target="_blank">
                            <i class="ico-photo"></i> <br>
                        </a>
                    <? endforeach; ?>
                    <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="docs">
                    <? foreach($files['document'] as $file) : ?>
                        <a href="<?= $file['path'] ?>" data-toggle="popover" data-content="&nbsp;" class="item" target="_blank">
                            <i class="ico-docs"></i> <br>
                            <?= $file['name'] ?>
                        </a>
                    <? endforeach; ?>
                    <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="archive">
                    <? foreach($files['archive'] as $file) : ?>
                        <a href="<?= $file['path'] ?>" data-toggle="popover" data-content="&nbsp;" class="item" target="_blank">
                            <i class="ico-archive"></i> <br>
                            <?= $file['name'] ?>
                        </a>
                    <? endforeach; ?>
                    <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="links">
                    <? foreach($task_links as $task_link) : ?>
                        <a target="_blank" href="<?= $task_link->name ?>" data-toggle="popover" data-content="&nbsp;" class="item">
                            <i class="ico-link"></i> <br>
                        </a>
                    <? endforeach; ?>
                    <div class="clearfix"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade in active" id="desc"><?php echo $task->description?></div>
              </div>
            </div>
                <div class="footer">
                    <div>
<ul class="btn-group nav nav-tabs" role="tablist">
                               <?php if(count($task_videos) > 0):?>
                                <li><a class="btn" href="#videos" role="tab" data-toggle="tab">
                                    <span class="text">Video</span>
                                    <span class="label"><?php echo count($task_videos)?></span>
                                </a></li>
                            <?php endif; ?>
                            <?php if(count($files['audio']) > 0):?>
                                <li><a class="btn" href="#audios" role="tab" data-toggle="tab">
                                    <span class="text">Sound</span>
                                    <span class="label"><?php echo count($files['audio'])?></span>
                                </a></li>
                            <?php endif;?>
                            <?php if(count($files['photo']) > 0):?>
                                <li><a class="btn" href="#photos" role="tab" data-toggle="tab">
                                    <span class="text">Photo</span>
                                    <span class="label"><?php echo count($files['photo'])?></span>
                                </a></li>
                            <?php endif;?>
                            <?php if(count($files['document']) > 0):?>
                                <li><a class="btn" href="#docs" role="tab" data-toggle="tab">
                                    <span class="text">Doc</span>
                                    <span class="label"><?php echo count($files['document'])?></span>
                                </a></li>
                            <?php endif;?>
                            <?php if(count($files['archive']) > 0):?>
                                <li><a class="btn" href="#archive" role="tab" data-toggle="tab">
                                    <span class="text">Archive</span>
                                    <span class="label"><?php echo count($files['archive'])?></span>
                                </a></li>
                            <?php endif;?>
                            <?php if(count($task_links) > 0):?>
                                <li><a class="btn" href="#links" role="tab" data-toggle="tab">
                                    <span class="text">Link</span>
                                    <span class="label"><?php echo count($task_links)?></span>
                                </a></li>
                            <?php endif;?>
                            <li class="active"><a class="btn" href="#desc" role="tab" data-toggle="tab">
                                <span class="text">Description</span>
                            </a></li>
                        </ul>
                    </div>
                </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<script>
$('.nav-tabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
$('.nav-tabs a').on('shown.bs.tab',function(){
    $('.page-content').mCustomScrollbar({
        setHeight: $('.page-content').css('minHeight'),
        theme:"dark"
    }); 
    $(".task-body .block.desc .tab-content > .tab-pane .item").popover({
        placement: "top",
        html: true,
        trigger:"hover",
        container:$("body"),
        template:'<div class="popover material" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>',
    });
});
</script>
<style>
    .nav-tabs{
        border-bottom:none;
    }
</style>