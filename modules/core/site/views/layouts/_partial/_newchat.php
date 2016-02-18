<?php

use modules\chat\models\Friend;
use modules\chat\models\Message;
use modules\chat\models\Group;
use modules\chat\models\Group_members;
use modules\chat\models\GroupView;

$userMod = Yii::$app->getModule('user');


$friend_model = Friend::getModelByUserId(Yii::$app->user->id);
$is_Visible = Friend::getVisible(Yii::$app->user->id);
$messageQuantity = Message::getMessageQuantity();
$messageGroupQuantity = Message::getGroupMessageQuantity();
$messageCommonQuantity = Message::getMessageCommonQuantity();
$model_group = Group_members::getGroupsById(Yii::$app->user->id);
$TotalmembersQuant = Group_members::getTotalMembers();

$moduleId = yii::$app->controller->module->id;
$actionId = yii::$app->controller->action->id;
$path = $moduleId.'/'.$actionId;

?>

<div style="width:500px; height:500px; position:absolute; top:50px; right:0px; background-color:#545c63; padding:20px; color:white; display:none" class="newchat">
        <div class="close" style="color:red; position:absolute; top:10px; right:10px">close</div>

<?php if($model_group):?>
    <?php foreach($model_group as $group):?>
        <p class="gr-group" data-id = '<?= $group->group_id ?>' style="cursor:pointer"><?= Group::getGroupNameById($group->group_id); ?></p>
    <?php endforeach;?>
<?php endif;?>

    <div class="dialog-main-general-massage-box dialog-fixed user-own-dialog" id="dialog_groups_chat"  style="z-index: 100; display:block; position:absolute;right:0px" data-userid="new_groups">
        <input type="hidden" id="group_id" value="">
        <input type="hidden" id="message-group-quantity" value="">
        <div class="dialog-main-general-massage-box-title">
            <div>
                <img src="/images/group.jpg" alt="ava" width="30" height="30">

            </div>
            <div class="group-name">
            </div>
            <button type="button" onclick="Chat.closeThisWindowById('dialog_groups_chat')">
                <i class="dialog-box-icon close"></i></button>
        </div>
        <div class="dialog-selector-arrow">
            <div></div>
        </div>
        <div class="dialog-massage-add-groups" id="dialog_groups_spisok">

        </div>
        <div  class="dialog-massage-history-block">
        </div>
        <div class="dialog-massage-typing-block">
            <form>
                <button class="dialog-adding-photo-btn" type="button"></button>
                <textarea class="message-area-group" placeholder="Ваше сообщение..."></textarea>
                <button class="wide"><i class="dialog-box-icon wide"></i></button>
                <button class="send" type="button" onclick='Group.sendMessageToGroup($(this))'>ок</button>
            </form>
        </div>
        <table class="dialog-massage-actions-block">
            <tr>
                <td>
                    <button class="delete-button-group" onClick="Group.DeleteGropById()" type="button">Удалить группу</button>
                </td>
            </tr>
        </table>
    </div>
</div>

<script>

    $('.close').on('click', function(){
        $('.newchat').hide();
    })

    $(document).on('click', '.gr-group', function(){
        var gr = $(this).attr('data-id');
        $('#group_id').val(gr);
    })
</script>