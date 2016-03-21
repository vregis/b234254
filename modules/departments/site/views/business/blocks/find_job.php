<?php $this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"); ?>
<?php $this->registerJsFile("/js/min/jquery.mask.min.js"); ?>
<?php $this->registerJsFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/js/bootstrap-select.min.js");?>
<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.9.3/css/bootstrap-select.min.css");?>
<div id="find_job" class="collapse slidePop">
    <!-- Nav tabs -->

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="task-block">
            <table class="table table-bordered" style="width:100%;">
                <thead>
                <tr>
                    <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                    <th width="290">Task name</th>
                    <th class="dropmenu filter-task deps" width="170">
                        <div style="position:relative;">
                            <div class="trigger">Departments <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in deps-menu" role="tooltip">
                                 <?= $deps_filter ?>
                            </div>
                        </div>
                    </th>
                    <th class="dropmenu filter-task specs" width="121">
                        <div style="position:relative;">
                            <div class="trigger">Specialty <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in spec-menu" role="tooltip">
                                 <?= $specials_filter ?>
                            </div>
                        </div>
                    </th>
                    <th width="120" class="time">Time <i class="fa fa-angle-down"></i></th>
                    <th width="120" class="rate">Rate / H <i class="fa fa-angle-down"></i></th>
                    <th class="dropmenu1 status" data-toggle="popover" data-not_autoclose="1">Search <i class="fa fa-angle-down"></i></th>
                </tr>
                </thead>
                <tbody id="user_task">
                    <?= $user_task ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6" style="border-right:0;padding-left: 8px;">
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
                            <? require __DIR__.'/advanced_search_form.php' ?>
                            <button style="margin-left: 5px;" class="btn btn-primary circle advanced-search-btn" data-toggle="popover" data-not_autoclose="1">
                                <i class="ico-search"></i>
                            </button>
                            Advanced search
                        </div>
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </th>

                    <th style="border-left:0;">
                        <button id="request" class="btn btn-primary make-ajax" style="width:100px;">Request</button>
                    </th>
                </tr>
                </tfoot>
            </table>

        </div>
        <div role="tabpanel" class="tab-pane fade" id="request-block">
            <table class="table table-bordered" style="width:100%;">
                <thead>
                <tr>
                    <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                    <th width="290">Task name</th>
                    <th class="dropmenu filter-task deps" width="170">
                        <div style="position:relative;">
                            <div class="trigger">Departments <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in deps-menu" role="tooltip">
                                 <?= $deps_filter_pending ?>
                            </div>
                        </div>
                    </th>
                    <th class="dropmenu filter-task specs" width="121">
                        <div style="position:relative;">
                            <div class="trigger">Specialty <i class="fa fa-angle-down"></i></div>
                            <div class="popover dropselect fade bottom in spec-menu" role="tooltip">
                                 <?= $specials_filter_pending ?>
                            </div>
                        </div>
                    </th>
                    <th width="120" class="time">Time <i class="fa fa-angle-down"></i></th>
                    <th width="120" class="rate">Rate / H <i class="fa fa-angle-down"></i></th>
                    <th class="dropmenu1 status" data-toggle="popover" data-not_autoclose="1">Pending <i class="fa fa-angle-down"></i></th>
                </tr>
                </thead>
                <tbody id="user_request">
                    <?= $user_request ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6" style="border-right:0;">
                        <div class="pull-right">
                        </div>
                        <div class="clearfix"></div>
                    </th>
                    <th style="border-left:0;">
                        <button id="reject" class="btn btn-primary make-ajax" style="width:100px;">Cancel</button>
                    </th>
                </tr>
                </tfoot>
            </table>
        </div>
        <div id="status-menu" style="display:none !important;">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a id="btn-task-block" href="#task-block" aria-controls="task-block" role="tab" data-toggle="tab">Search </a></li>
                <li role="presentation" class="disabled"><a id="btn-request-block" href="#request-block" aria-controls="request-block" role="tab" data-toggle="tab">Pending </a></li>
            </ul>
        </div>
    </div>
</div>
