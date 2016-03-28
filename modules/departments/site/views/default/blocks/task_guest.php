<link rel="stylesheet" type="text/css" href="/css/task.css">
<div class="well well-sm" style="margin:0px auto;max-width:1024px;padding: 10px !important;">
<div class="task mCustomScrollbar _mCS_5 mCS_no_scrollbar" style="height: 620px;"><div id="mCSB_5" class="mCustomScrollBox mCS-dark mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_5_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
        <div class="hidden-task-id" style="display:none"><?php echo $task->id?></div>
        <div class="row">
            <div class="col-sm-12">
                <div class="task-bg" style="box-shadow: none !important;border: none !important;">
                    <div class="row task-title">
                        <div class="name pull-left"><?php echo $task->name?></div>
                        <div id="action_panel" class="pull-right inline">
                            
<div id="status-delegate" data-status="0"></div>

<input type="hidden" id="taskuser-start" data-value="" value="">
<input type="hidden" id="taskuser-end" data-value="" value="">

<div class="item date" style="min-width: 141px;">
    <input type="hidden" id="input-href" name="href" value="none">
            <button class="btn btn-primary circle icon collapsed" id="btn-datepicker" data-toggle="collapse" data-target="#datepicker" aria-expanded="false" aria-controls="datepicker">
            <i class="ico-calendar"></i>
        </button>
        <span class="title-value start"></span> <span class="title-caption start"></span> -
    <span class="title-value end"></span> <span class="title-caption end"></span>
</div>
<div class="item time">
    <button class="btn btn-primary circle icon static" data-toggle="popover" data-placement="bottom" data-content="test">
        <i class="ico-clock1"></i>
    </button>
                        <input class="chngval" id="input-time" value="1h" type="text">
            </div>
<div class="item cost" style="margin-right: 33px;">
    <button class="btn btn-primary circle icon static" data-toggle="popover" data-placement="bottom" data-content="test">
        <i class="ico-dollar"></i>
    </button>
                        <input class="chngval" id="input-price" value="0" type="text">
            </div>
<input type="hidden" id="taskuser-status" name="TaskUser[status]" value="1">
                        <button data-id = '<?php echo $task->id?>' class="btn btn-primary offer create-request">Request</button>
                            <button id="btn-delegate" class="btn btn-primary disabled static" style="width:93px;">Reject</button>
            <button class="btn btn-success disabled static" style="width:93px;">Submit</button>
            <a href="#" data-dismiss="modal" class="href-black task-close"></a>
<div id="payment-form" style="display:none;">
    <div class="container-fluid" style="padding-top: 0;">
        <div class="row">
                            <label for="" class="col-sm-12">Pay with credit card</label>
                    </div>
        <div class="row"><label for="" class="col-sm-12" style="text-align:center;">Enter payment information</label></div>

        <div class="row">
            <div class="col-sm-6 col-xs-6 noselect"><input style="height:32px;margin:9px 0;" type="text" class="form-control" data-inputmask="'alias': 'email'" placeholder="Paypal login" name="paypal_login"></div>
            <div class="col-sm-6 col-xs-6 noselect"><input style="height:32px;margin:9px 0;" type="text" class="form-control" data-inputmask="'alias': 'email'" placeholder="Re-type paypal login" name="paypal_loginre"></div>
        </div>
        <div class="row text-center">
            <button style="margin:20px 0 10px;" id="btn-pay" type="submit" class="btn btn-primary">Fund <span class="label" data-toggle="popover">?</span></button>
            <style type="text/css">
                [type="submit"] .label{
                    font-size:10px;
                    border:1px solid #818588;
                    border-radius:100% !important;
                    color: #818588;
                    z-index: 999999;
                }
                [type="submit"]:hover .label{
                    color:#fff;
                    border-color:#fff;
                }
            </style>

        </div>
    </div>
</div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="datepicker" class="collapse slidePop" aria-expanded="false">
                            <div class="arrow"></div>
                            <table style="width:100%;">
                                <tbody><tr>
                                    <td style="vertical-align:top;"><div id="startDate" class="hasDatepicker"><div class="ui-datepicker-inline ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" style="display: block;"><div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all"><a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="Prev"><span class="ui-icon ui-icon-circle-triangle-w">Prev</span></a><a class="ui-datepicker-next ui-corner-all" data-handler="next" data-event="click" title="Next"><span class="ui-icon ui-icon-circle-triangle-e">Next</span></a><div class="ui-datepicker-title"><span class="ui-datepicker-month">March</span>&nbsp;<span class="ui-datepicker-year">2016</span></div></div><table class="ui-datepicker-calendar"><thead><tr><th scope="col" class="ui-datepicker-week-end"><span title="Sunday">Su</span></th><th scope="col"><span title="Monday">Mo</span></th><th scope="col"><span title="Tuesday">Tu</span></th><th scope="col"><span title="Wednesday">We</span></th><th scope="col"><span title="Thursday">Th</span></th><th scope="col"><span title="Friday">Fr</span></th><th scope="col" class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th></tr></thead><tbody><tr><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">1</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">2</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">3</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">4</span></td><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">5</span></td></tr><tr><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">6</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">7</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">8</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">9</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">10</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">11</span></td><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">12</span></td></tr><tr><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">13</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">14</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">15</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">16</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">17</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">18</span></td><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">19</span></td></tr><tr><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">20</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">21</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">22</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">23</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">24</span></td><td class=" ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">25</span></td><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">26</span></td></tr><tr><td class=" ui-datepicker-week-end ui-datepicker-unselectable ui-state-disabled "><span class="ui-state-default">27</span></td><td class=" ui-datepicker-days-cell-over  ui-datepicker-current-day ui-datepicker-today" data-handler="selectDay" data-event="click" data-month="2" data-year="2016"><a class="ui-state-default ui-state-highlight ui-state-active ui-state-hover" href="#">28</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="2" data-year="2016"><a class="ui-state-default" href="#">29</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="2" data-year="2016"><a class="ui-state-default" href="#">30</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="2" data-year="2016"><a class="ui-state-default" href="#">31</a></td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td></tr></tbody></table></div></div></td>
                                    <td style="vertical-align:top;"><div id="endDate" class="hasDatepicker"><div class="ui-datepicker-inline ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" style="display: block;"><div class="ui-datepicker-header ui-widget-header ui-helper-clearfix ui-corner-all"><a class="ui-datepicker-prev ui-corner-all" data-handler="prev" data-event="click" title="Prev"><span class="ui-icon ui-icon-circle-triangle-w">Prev</span></a><a class="ui-datepicker-next ui-corner-all" data-handler="next" data-event="click" title="Next"><span class="ui-icon ui-icon-circle-triangle-e">Next</span></a><div class="ui-datepicker-title"><span class="ui-datepicker-month">April</span>&nbsp;<span class="ui-datepicker-year">2016</span></div></div><table class="ui-datepicker-calendar"><thead><tr><th scope="col" class="ui-datepicker-week-end"><span title="Sunday">Su</span></th><th scope="col"><span title="Monday">Mo</span></th><th scope="col"><span title="Tuesday">Tu</span></th><th scope="col"><span title="Wednesday">We</span></th><th scope="col"><span title="Thursday">Th</span></th><th scope="col"><span title="Friday">Fr</span></th><th scope="col" class="ui-datepicker-week-end"><span title="Saturday">Sa</span></th></tr></thead><tbody><tr><td class=" ui-datepicker-week-end ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" ui-datepicker-other-month ui-datepicker-unselectable ui-state-disabled">&nbsp;</td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">1</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">2</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">3</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">4</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">5</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">6</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">7</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">8</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">9</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">10</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">11</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">12</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">13</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">14</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">15</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">16</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">17</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">18</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">19</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">20</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">21</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">22</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">23</a></td></tr><tr><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">24</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">25</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">26</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">27</a></td><td class="  ui-datepicker-current-day" data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default ui-state-active" href="#">28</a></td><td class=" " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">29</a></td><td class=" ui-datepicker-week-end " data-handler="selectDay" data-event="click" data-month="3" data-year="2016"><a class="ui-state-default" href="#">30</a></td></tr></tbody></table></div></div></td>
                                </tr>
                            </tbody></table>
                        </div>
                                                <div id="counter" class="collapse slidePop" aria-expanded="false"> <div class="arrow"></div>
                        <div class="arrow"></div>
<table style="width:100%;" class="table">
    <tbody id="counter_users">
        </tbody>
</table>
                    </div>
                                        <div id="delegate" class="collapse slidePop" aria-expanded="false"> <div class="arrow"></div>
                    <!-- Nav tabs -->
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="search-block">
                            <table style="width:100%;" class="table with-foot table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
                                        <th width="280">Name</th>
                                        <th width="165">Level</th>
                                        <th width="105" class="rate">Rate by h <i class="fa fa-angle-up"></i></th>
                                        <th width="250">Location</th>
                                        <th width="130" class="dropmenu1 status" data-toggle="popover" data-not_autoclose="1" data-original-title="" title="">Search<i class="fa fa-angle-down"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="delegate_users">
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="5" style="border-right:0;">
                                        <div class="pull-left" style="margin-left: 10px;">
                                            <div id="invite-form" class="no-autoclose" style="display:none;">
                                            <legend>Delegate by email</legend>
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
                                            <div id="advanced-search-form" class="no-autoclose" style="display:none;">
                                                <legend>Advanced search</legend>
                                                <div class="row form-group">
                                                    <div class="col-sm-6">
                                                        <label for="">Rate by/H</label> <br>
                                                                                                                <div class="col-sm-5 pull-left" style="padding:0;"><input type="text" id="input-rate-start" value="0" class="form-control"></div>
                                                        <div class="col-sm-5 pull-right" style="padding:0;"><input type="text" id="input-rate-end" value="0" class="form-control"></div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="">Level</label> <br>
                                                        <select id="select-level" class="update form-control selectpicker">
                                                                                                                        <option value="1">Guru</option>
                                                                                                                        <option value="2">Professional</option>
                                                                                                                        <option value="3">Specialist</option>
                                                                                                                        <option value="4">Beginner</option>
                                                                                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-6">
                                                        <label for="">Country</label> <br>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="">City</label>
                                                        <input id="input-city" type="text" value="" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <div class="col-sm-12">
                                                        <div class="pull-right">
                                                            <button type="submit" id="advanced-search-send-task" class="btn btn-primary">Search</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary circle invite-by-email" data-toggle="popover">
                                            <i class="ico-mail"></i>
                                            </button>
                                            <!-- Delegate by email -->
                                            <button style="margin-left: 32px;" class="btn btn-primary circle advanced-search-btn" data-toggle="popover" data-not_autoclose="1">
                                            <i class="ico-search"></i>
                                            </button>
                                            <!-- Advanced search -->
                                        </div>
                                        <div class="pull-right">
                                        </div>
                                        <div class="clearfix"></div>
                                    </th>
                                    <th style="border-left:0;">
                                        <button class="btn btn-primary make-offer" style="width:96px;font-size:11px !important;padding: 0px 15px !important;white-space: initial;">Make <br> an offer</button>
                                    </th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="offered-block">

                        </div>
                    </div>
                    <div id="status-menu" style="display:none !important;">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#search-block" aria-controls="search-block" role="tab" data-toggle="tab">Search</a></li>
                            <li id="liofer" role="presentation"><a id="btn-offered-block" data-toggle="tab" href="#offered-block" aria-controls="offered-block" role="tab">Offered <!--<span class="label label-danger circle"></span>--></a></li>
                        </ul>
                    </div>
                </div>
            </div>
                    <script>
                        function showLi(id){
                            if(id == 1){
                                $('#liofer').removeClass('disabled');
                                $('#btn-offered-block').attr('data-toggle','tab');
                                $('#btn-offered-block').attr('href','#offered-block');
                                
                            }else{
                                $('#liofer').addClass('disabled');
                                $('#btn-offered-block').removeAttr('data-toggle');
                                $('#btn-offered-block').removeAttr('href');
                                $("a[href='#search-block']").tab('show')
                            }
                        }
                    </script>
            <div class="row task-body">
                <div class="col1">
                    <div class="title">Speciality:  <?php echo $task->spec?></div>
                    <div class="block desc" style="border: none;">
                        <div class="content mCustomScrollbar _mCS_4 mCS_no_scrollbar" style="border: 1px solid rgb(215, 215, 215); padding: 0px 15px; height: 285px; overflow: visible; position: relative;"><div id="mCSB_4" class="mCustomScrollBox mCS-dark mCSB_vertical mCSB_outside" style="max-height: none;" tabindex="0"><div id="mCSB_4_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade" id="videos">
                                                                        <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="audios">
                                                                        <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="photos">
                                                                        <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="docs">
                                                                        <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="archive">
                                                                        <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="links">
                                                                        <a href="http://getsigneasy.com" target="_blank" data-toggle="popover" data-content="&nbsp;" class="item">
                                        <i class="ico-link"></i> <br>
                                    </a>
                                                                        <a href="https://www.docusign.com" target="_blank" data-toggle="popover" data-content="&nbsp;" class="item">
                                        <i class="ico-link"></i> <br>
                                    </a>
                                                                        <a href="https://www.pandadoc.com" target="_blank" data-toggle="popover" data-content="&nbsp;" class="item">
                                        <i class="ico-link"></i> <br>
                                    </a>
                                                                        <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="notes">
                                                                        <a href="https://www.pandadoc.com" target="_blank" class="item">https://legaltemplates.net/form/non-disclosure-agreement/?gclid=Cj0KEQiA7rmzBRDezri2r6bz1qYBEiQAg-YEtkfESC3Mxu7A1Qr_X3hyEVT1L1QbLKD8QDidxMt3LJQaAtR08P8HAQ                                        <i class="ico-history"></i> <br>
                                        Name
                                    </a>
                                                                        <div class="clearfix"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade in active" id="desc"><p><span style="font-size: 14px; letter-spacing: 0.1599999964237213px; font-family: Arial;">A Confidentiality Agreement or NDA (Non-Disclosure Agreement)</span><span style="font-family: Arial;"><span style="font-size: 14px;">&nbsp;is a legal contract between two parties which restricts the disclosure of confidential information which is shared between the parties. </span></span></p><p><span style="font-family: Arial;"><span style="font-size: 14px;">This is a common practice in many business partnerships or cooperative projects in which sensitive information is shared.</span></span></p><p><span style="font-size: 14px; font-family: Arial;">It can be made between individuals or between businesses to protect your idea:</span></p><ul><li style="box-sizing: inherit; position: relative;"><span style="font-family: Arial;"><span style="box-sizing: inherit; font-weight: 600; font-size: 14px;">The “Disclosing Party”:</span><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">the individual or entity sharing information</span></span></li><li style="box-sizing: inherit; position: relative;"><span style="font-family: Arial;"><span style="box-sizing: inherit; font-weight: 600; font-size: 14px;">The “Receiving Party”:</span><span style="font-size: 14px;">&nbsp;</span><span style="font-size: 14px;">the individual or entity receiving information</span></span></li><br></ul></div>
                            </div>
                        </div></div><div id="mCSB_4_scrollbar_vertical" class="mCSB_scrollTools mCSB_4_scrollbar mCS-dark mCSB_scrollTools_vertical" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_4_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 25px; top: 0px; height: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="line-height: 25px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div>
                        <div class="footer">
                            <div>
                                <ul class="btn-group nav nav-tabs" role="tablist">
                                                                                                                                                                                                                                                            <li><a class="btn" href="#links" role="tab" data-toggle="tab">
                                        <span class="text">Link</span>
                                        <span class="label">3</span>
                                    </a></li>
                                                                        <li class="active"><a class="btn" href="#desc" role="tab" data-toggle="tab">
                                        <span class="text">Description</span>
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="title text-center" style="margin-top: 4px;">Is this task was helpful to you?</div>
                    <div class="step">
                        <div class="question-name">
                            <h4 class="left pull-left">No</h4>
                            <h4 class="right pull-right">Yes</h4>
                            <div class="clearfix"></div>
                        </div>
                        <div id="helpful" class="form-md-radios md-radio-inline b-page-checkbox-wrap disabled off">
                                                        <div class="md-radio has-test b-page-checkbox">
                                <input type="radio" id="Helpful[0]" disabled="" name="Helpful" class="md-radiobtn" value="0">
                                <label for="Helpful[0]">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                </label>
                            </div>
                                                        <div class="md-radio has-test b-page-checkbox">
                                <input type="radio" id="Helpful[1]" disabled="" name="Helpful" class="md-radiobtn"  value="1">
                                <label for="Helpful[1]">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                </label>
                            </div>
                                                        <div class="md-radio has-test b-page-checkbox">
                                <input type="radio" id="Helpful[2]" disabled="" name="Helpful" class="md-radiobtn" value="2">
                                <label for="Helpful[2]">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                </label>
                            </div>
                                                        <div class="md-radio has-test b-page-checkbox">
                                <input type="radio" id="Helpful[3]" disabled="" name="Helpful" class="md-radiobtn" value="3">
                                <label for="Helpful[3]">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                </label>
                            </div>
                                                        <div style="display:inline-block;width:100%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col2">
                    <div id="delegate_active_users" class="milestones-users">
                                            </div>
                    <div class="block chat">
                        <div class="content">
                            <div class="ajax-content">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab1">
                                        <div class="scroller" style="height: 255px;">
                                            <ol id="taskUserNotes">
                                                
                                            </ol>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="portlet_tab2">
                                        <div class="scroller" style="height: 255px;">
                                            <ul id="taskUserMessages">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="portlet_tab3">
                                        <div class="scroller" style="height: 255px;">
                                            <ol id="taskUserLogs">
                                                        <li style="font-size:14px;"><span>03/28/2016</span> <br>
        <span style="font-size:12px;"><strong>Obtained</strong></span>
    </li>
        <li style="font-size:14px;"><span>03/28/2016</span> <br>
        <span style="font-size:12px;"><strong>Task offered Иван Чернецкий</strong></span>
    </li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="actions">
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active">
                                        <a onclick="return false" class="btn btn-primary circle" id="btn-tab-note">
                                            <span class="ico-edit"></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a onclick="return false" id="btn-tab-message">
                                            <span class="ico-chat"></span>
                                        </a>
                                        <span id="badge-chat" class="badge badge-danger"></span>
                                    </li>
                                    <li>
                                        <a onclick="return false" class="btn btn-primary circle" id="btn-tab-log">
                                            <span class="ico-history"></span>
                                        </a>
                                        <span id="badge-log" class="badge badge-danger"></span>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="footer">
                            <div id="message-input">
                                <input type="text" disabled id="textarea-task" class="form-control" placeholder="Put your message here...">
                                <button onclick="return false" id="btn-note" type="submit" class="btn btn-primary" data-task_user_id="307">Send</button>
                            </div>
                        </div>
                    </div>
                    <div class="title">Feedback</div>
                    <div class="block feedback">
                        <div class="footer">
                            <div>
                                <input disabled type="text" id="feedback-input" class="form-control" placeholder="Put your message here...">
                                <button onclick="return false"  type="submit" id="btn-feedback" class="btn btn-primary">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
</div><div id="mCSB_5_scrollbar_vertical" class="mCSB_scrollTools mCSB_5_scrollbar mCS-dark mCSB_scrollTools_vertical" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_5_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 155px; height: 0px; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="line-height: 155px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
</div>

<script>
    $('.create-request').on('click', function(){

        var id = $(this).data('id');
        var price = $('#input-price').val();
        var time = parseInt($('#input-time').val());

        $.ajax({
            url: '/departments/create-user-request',
            type: 'post',
            dataType: 'json',
            data: {id:id, price:price, time:time},
            success: function(response){

            }
        })

    })
</script>


