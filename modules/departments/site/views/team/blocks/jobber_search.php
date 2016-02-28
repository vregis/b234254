<div class="deps-wrap">
    <div class="roww action">
        <div data-id="1" class="item background-1">
            <button data-toggle="collapse" data-target="#idea1" aria-expanded="false" aria-controls="idea1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="2" class="item background-2">
            <button data-toggle="collapse" data-target="#strategy1" aria-expanded="false" aria-controls="strategy1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="3" class="item background-3">
            <!--<img width="30" onerror="this.onerror=null;this.src='/images/avatar/nophoto.png';" data-toggle="popover" class="gant_avatar active mCS_img_loaded" data-id="0" src="/images/avatar/nophoto.png" data-original-title="" title="">
            <a href="javascript:;" class="close"><i class="ico-times"></i></a>-->
            <button style="" data-toggle="collapse" data-target="#customers1" aria-expanded="false" aria-controls="customers1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="4" class="item background-4">
            <button data-toggle="collapse" data-target="#documents1" aria-expanded="false" aria-controls="docs1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="5" class="item background-5">
            <button data-toggle="collapse" data-target="#products1" aria-expanded="false" aria-controls="products1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="6" class="item background-6">
            <button data-toggle="collapse" data-target="#numbers1" aria-expanded="false" aria-controls="numbers1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="7" class="item background-7">
            <button data-toggle="collapse" data-target="#computers1" aria-expanded="false" aria-controls="it1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
        <div data-id="8" class="item background-8">
            <button data-toggle="collapse" data-target="#people1" aria-expanded="false" aria-controls="team1" class="btn btn-primary circle"><i class="ico-add"></i></button>
        </div>
    </div>
    <div class="roww deps">
        <div data-id="1" href="javascript:;" class="item background-1">Idea<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="2" href="javascript:;" class="item background-2">Strategy<div class="arrow" style="left: 50%;"></div></div>
        <div data-id="3" href="javascript:;" class="item background-3">Customers</div>
        <div data-id="4" href="javascript:;" class="item background-4">Documents</div>
        <div data-id="5" href="javascript:;" class="item background-5">Products</div>
        <div data-id="6" href="javascript:;" class="item background-6">Numbers</div>
        <div data-id="7" href="javascript:;" class="item background-7">IT</div>
        <div data-id="8" href="javascript:;" class="item background-8">Team</div>
    </div>
</div>

<?php foreach($departments as $dep):?>
<div class="collapse fade" id="<?php echo $dep->icons?>1">
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
            <th style="width:85px !important;" width="85" class="stat-toggle">Request</th>
        </tr>
        </thead>
        <tbody id="user_request">
        <tr class="user-row" data-page-id="0" style="">
            <td>
                <img class="gant_avatar" src="/images/avatar/nophoto.png" height="33" style="margin:0;">
            </td>
            <td>Simon Swerdlow <?php echo $dep->icons?></td>
            <td>40</td>
            <td>15</td>
            <td>4</td>
            <td>2</td>
            <td>1</td>
            <td><button class="btn btn-primary circle btn-chat"><i class="ico-chat"></i></button></td>
            <td style="width:85px !important;"><button class="btn btn-primary circle btn-stat-toggle"><i class="ico-add"></i></button></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="10" style="border-right:0;height: 50px;">
            </th>
        </tr>
        </tfoot>
    </table>

</div>

<?php endforeach; ?>