<?php

$this->registerJsFile("/plugins/moment/moment.js");
$this->registerJsFile("/plugins/modernizr-custom.js");

$this->registerCssFile("/plugins/gantt/assets/css/main.css");
// $this->registerCssFile("/plugins/uikit/css/uikit.almost-flat.min.css");
$this->registerJsFile("/plugins/uikit/js/uikit.js");
$this->registerJsFile("/plugins/uikit/js/components/tooltip.js");
$this->registerJsFile("/plugins/gantt/assets/js/custom/gantt_chart.js");
$this->registerJsFile("/plugins/gantt/assets/js/pages/plugins_gantt_chart.js");
?>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>

    <!--<script src="ganttDrawer.js"></script>-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel-group milestones" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <div class="info">
                                <button class="panel-toggle btn-empty" data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><i class="fa fa-angle-down"></i></button>
                                <h4 class="panel-title">Milestone name</h4>
                                <span class="label label-lg pull-right">5</span>
                                <div class="btns pull-right hide">
                                    <button class="btn-empty btn-info"><i class="icon-info"></i></button>
                                    <div class="typeSwitch">
                                        <!--<label class="live off">L</a>-->
                                        <input data-color="#53d769" type="checkbox" id="typeSwitch1" checked class="js-switch js-check-change" name="view">
                                        <!--<label class="control-label bus">G</label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="menu">
                                <div class="hor-menu">
                                    <div class="btn-group btn-group-justified">
                                        <div class="btn-group open btn-idea active">
                                            <button type="button" class="btn">
                                                <i class="ico-idea"></i>
                                                <span class="text show568-">Idea</span>
                                            </button>
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right" role="menu">
                                                <li>
                                                    <a href="javascript:;"> Action </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="/departments?id=2" class="btn btn-strategy">
                                            <i class="ico-strategy"></i>
                                            <span class="text show568-">Strategy</span>
                                        </a>
                                        <a href="/departments?id=3" class="btn btn-customers active">
                                            <i class="ico-customers"></i>
                                            <span class="text show568-">Customers</span>
                                        </a>
                                        <a href="/departments?id=4" class="btn btn-documents active">
                                            <i class="ico-documents"></i>
                                            <span class="text show568-">Documents</span>
                                        </a>
                                        <a href="/departments?id=5" class="btn btn-products">
                                            <i class="ico-products"></i>
                                            <span class="text show568-">Product</span>
                                        </a>
                                        <a href="/departments?id=6" class="btn btn-numbers active">
                                            <i class="ico-numbers"></i>
                                            <span class="text show568-">Numbers</span>
                                        </a>
                                        <a href="/departments?id=7" class="btn btn-computers active">
                                            <i class="ico-computers"></i>
                                            <span class="text show568-">IT</span>
                                        </a>
                                        <a href="/departments?id=8" class="btn btn-people active">
                                            <i class="ico-people"></i>
                                            <span class="text show568-">People</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="wrapper">
                                    <div class="ganttview-vtheader">
                                        <div class="ganttview-vtheader-group">
                                            <div class="milestones-users">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                            </div>
                                            <div class="ganttview-vtheader-series">
                                                <?php foreach($tasks as $t):?>
                                                    <div class="ganttview-vtheader-series-row">
                                                        <div class="series-content"><?php echo $t->name?></div>
                                                    </div>
                                                <?php endforeach; ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="view-box-0"></div>
                                    <script>
                                        ganttData = [{
                                            id: 1,
                                            name: "Concept",
                                            color: '#006064',
                                            series: [
                                                <?php foreach($tasks as $t):?>
                                                    {
                                                    name: "<?php echo $t->name?>",
                                                    start: '<?php echo date('m/d/Y', strtotime($t->start));?>',
                                                    end: '<?php echo date('m/d/Y', strtotime($t->end));?>',
                                                    color: "#0288D1",
                                                    },
                                                <?php endforeach;?>
                                            ]
                                        }];
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <div class="info">
                                <button class="panel-toggle btn-empty" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-angle-down"></i></button>
                                <h4 class="panel-title">Milestone name</h4>
                                <span class="label label-lg pull-right">5</span>
                                <div class="btns pull-right hide">
                                    <button class="btn-empty btn-info"><span class="icon-info"></span></button>
                                    <div class="typeSwitch">
                                        <!--<label class="live off">L</a>-->
                                        <input data-color="#53d769" type="checkbox" id="typeSwitch1" checked class="js-switch js-check-change" name="view">
                                        <!--<label class="control-label bus">G</label>-->
                                    </div>
                                </div>
                            </div>
                            <div class="menu">
                                <div class="hor-menu">
                                    <div class="btn-group btn-group-justified">
                                        <a href="/departments?id=1" class="btn btn-idea active">
                                            <i class="ico-idea"></i>
                                            <span class="text show568-">Idea</span>
                                        </a>
                                        <a href="/departments?id=2" class="btn btn-strategy">
                                            <i class="ico-strategy"></i>
                                            <span class="text show568-">Strategy</span>
                                        </a>
                                        <a href="/departments?id=3" class="btn btn-customers active">
                                            <i class="ico-customers"></i>
                                            <span class="text show568-">Customers</span>
                                        </a>
                                        <a href="/departments?id=4" class="btn btn-documents active">
                                            <i class="ico-documents"></i>
                                            <span class="text show568-">Documents</span>
                                        </a>
                                        <a href="/departments?id=5" class="btn btn-products">
                                            <i class="ico-products"></i>
                                            <span class="text show568-">Product</span>
                                        </a>
                                        <a href="/departments?id=6" class="btn btn-numbers active">
                                            <i class="ico-numbers"></i>
                                            <span class="text show568-">Numbers</span>
                                        </a>
                                        <a href="/departments?id=7" class="btn btn-computers active">
                                            <i class="ico-computers"></i>
                                            <span class="text show568-">IT</span>
                                        </a>
                                        <a href="/departments?id=8" class="btn btn-people active">
                                            <i class="ico-people"></i>
                                            <span class="text show568-">People</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="wrapper">
                                    <div class="ganttview-vtheader">
                                        <div class="ganttview-vtheader-group">
                                            <div class="milestones-users">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                                <img src="https://zhestokij-realist.ru/wp-content/uploads/2014/06/putin_vseh_prodal.jpg" title="asdasdsa">
                                            </div>
                                            <div class="ganttview-vtheader-series">

                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Brainstorm</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Wireframes</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Concept description</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Sketching</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Photography</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Feedback</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Final Design</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Specifications</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Templates</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Database</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Integration</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Focus Group</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Stress Test</div>
                                                </div>
                                                <div class="ganttview-vtheader-series-row">
                                                    <div class="series-content">Delivery</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="view-box-1"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="gimmeBack" style="display:none;" action="#" method="post" target="_blank">
        <input type="hidden" name="prj" id="gimBaPrj">
    </form>

    <script>
        
        $(function() {

            $(".exp-controller").remove();
            $.uniform.restore("#viewType");
            $("#viewType").bootstrapSwitch({
                onText: "List",
                offText: "Chart",
                size: "small",
                // handleWidth:"50px",
                // labelWidth: "50px"
            });
        });
    </script>