<div class="deps-wrap">
    <div class="roww action">
        <?php foreach($departments as $dep):?>
            <div data-id="<?php echo $dep->id?>" class="item background-<?php echo $dep->id?>">
                <!--<img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="/images/avatar/nophoto.png" data-original-title="" title="">-->
                <!--<a href="javascript:;" class="close"><i class="ico-times"></i></a>-->
                <button data-toggle="collapse" data-target="#<?php echo $dep->icons?>1" aria-expanded="false" aria-controls="<?php echo $dep->icons?>1" class="btn btn-primary circle"><i class="ico-add"></i></button>
            </div>
        <?php endforeach; ?>
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
<div class="collapse fade" id="<?php echo $dep->icons?>1">
    <table class="table table-bordered with-foot" style="width:100%;">
        <thead>
        <tr>
            <th width="60"><button style="margin:0;border:none !important;font-size: 24px;line-height: 20px !important;" class="btn btn-primary static circle"><i class="ico-user1"></i></button></th>
            <th width="212">Name</th>
            <th width="125">Department</th>
            <th width="212">Location</th>
            <th width="125">Chat</th>
            <th width="125">Apply</th>
            <th width="125">Reject</th>
        </tr>
        </thead>
        <tbody id="user_request">
        <tr class="user-row" data-page-id="0" style="">
            <td>
                <img class="gant_avatar" src="/images/avatar/nophoto.png" height="33" style="margin:0;">
            </td>
            <td>Simon Swerdlow</td>
            <td>Idea</td>
            <td>USA, Jupiter</td>
            <td><button class="btn btn-primary btn-chat circle"><i class="ico-chat"></i></button></td>
            <td><button style="font-size: 10px;" class="btn btn-success circle"><i class="ico-check1"></i></button></td>
            <td><button style="font-size: 10px;" class="btn btn-danger circle"><i class="ico-delete"></i></button></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="7" style="border-right:0;padding: 10px 12px;">
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
                <div class="clearfix"></div>
            </th>
        </tr>
        </tfoot>
    </table>
</div>

<?php endforeach; ?>