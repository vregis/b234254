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
<input type="hidden" id='message-quantity' value='<?= $messageQuantity ?>'>
<input type="hidden" id='message-group-quantity' value='<?= $messageGroupQuantity ?>'>
<input type="hidden" id='message-common-quantity' value='<?= $messageCommonQuantity ?>'>
<input type="hidden" id='total-members-quantity' value='<?= $TotalmembersQuant ?>'>

<input type="hidden" id='draggable_id' value=''>
<input type="hidden" id='sortable_id' value=''>


<!-- massage box begin -->
<div class="dialog-main-general-massage-box dialog-fixed user-own-dialog" id="dialog_main_chat" data-userid="" style="z-index: 100;">
</div>


<div class="dialog-main-general-massage-box dialog-fixed user-own-dialog" id="dialog_groups_chat"  style="z-index: 100;" data-userid="new_groups">
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
        <div class="background-bl"></div>
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


<!--  ********************** Общий чат *************************************-->
<div class="dialog-main-general-massage-box " id="dialog_main_common_chat" style="z-index: 100;"> <!-- при этом классе высота маленькая user-own-dialog-->
    <!-- dialog selector arrow begin -->
    <div class="dialog-selector-arrow" style="bottom: 0; margin-bottom: 73px;">
        <div></div>
    </div>
    <!-- dialog selector arrow end -->


    <!-- massage block titile begin -->
    <div class="dialog-main-general-massage-box-title">
        <!-- 	<a href="#">  ссылку делаем активной только если это чат между пользователями, если это общий чат - ссылку убираем -->
        <div>
            <img src="/style/main/img/mp.jpg">
            <div class="dialog-box-user-status">
                <div class="online"></div>
            </div>
        </div><div>
        Мирпрост Чат</div>
        <!--  </a> -->
        <button onclick="Chat.closeThisWindowById('dialog_main_common_chat')" type="button">
            <i class="dialog-box-icon close"></i></button>
    </div>
    <!-- massage block titile end -->

    <!-- massage history block begin -->
    <div id="dialog-massage-history-block" class="dialog-massage-history-block history-chat" style="height: 597px;">
   

    </div>
    <!-- massage history block end -->

    <!-- massage typing block begin -->
    <div class="dialog-massage-typing-block">
        <form>
            <button class="dialog-adding-photo-btn" type="button"></button>
            <textarea class="textarea-common" placeholder="Ваше сообщение..."></textarea>
            <button class="wide"><i class="dialog-box-icon wide"></i></button>
            <button onclick="MainChat.SendMessage()" class="send" type="button">ок</button>
        </form>
    </div>
    <!-- massage typing block end -->

    <!-- user dialog actions begin -->

    <table class="dialog-massage-actions-block">
        <tbody><tr>
            <td>
                <button type="button">Блокировать</button>
            </td>
            <td>
                <button type="button">Удалить диалог</button>
            </td>
        </tr>
    </tbody></table>

    <!-- user dialog actions end -->

</div>
<!--  ********************** Общий чат конец*************************************-->


<!-- ****************** Только для создания группы ****************** -->
<div data-grop-id="" class="dialog-main-general-massage-box dialog-fixed user-own-dialog" id="dialog_groups_chat_new"  style="z-index: 100;" data-userid="new_groups"> <!-- при этом классе высота маленькая user-own-dialog-->

    <div class="dialog-main-general-massage-box-title">
       
        <div>
            <img width="30" height="30" alt="ava" src="/images/group.jpg">
        </div>
        <div class="group-name "></div>

        <button type="button" onclick="Chat.closeThisWindowById('dialog_groups_chat_new')">
            <i class="dialog-box-icon close"></i></button>
    </div>
    <div class="dialog-selector-arrow">
        <div></div>
    </div>
    <div class="dialog-massage-add-groups"  id="dialog_groups_spisok_new">
        <div class="background-bl"></div>
    </div>
    <div  class="dialog-massage-history-block">
    </div>
    <div class="dialog-massage-typing-block">
        <form>
            <button class="dialog-adding-photo-btn" type="button"></button>
            <textarea  class="message-area-group" placeholder="Ваше сообщение..."></textarea>
            <button class="wide"><i class="dialog-box-icon wide"></i></button>
            <button class="send" type="button" onclick='Group.sendMessageToNewGroup($(this))'>ок</button>
        </form>
    </div>
    <table class="dialog-massage-actions-block">
        <tr>
            <td>
                <button onClick="Group.DeleteGropById()" type="button">Удалить группу</button>
            </td>
        </tr>
    </table> 
</div>
<!-- ****************** Только для создания группы  end ****************** -->
<!-- dialog box main begin -->
<div class="general-dialog-box active">
    <!-- title begin -->
    <div class="dialog-box-title-block">
        <div class="dialog-box-title-general">
            <div class="dialog-box-main-avatar">
                <img src="<?= $userMod->getAvatarUrl(Yii::$app->user->id) ?>" width="30" height="30" alt=""/>

            </div>
            <div class="dialog-box-user-info">
                <div><?= Yii::$app->user->identity->username; ?></div>
            </div>
            <div onclick="Chat.ChangeVisible($(this))" class="dialog-box-main-stat  <?php
            if ($is_Visible == true) {
                echo 'active';
            } else {
                echo '';
            }
            ?>">
                <div id="status-pointer"></div>
                <i class="dialog-box-icon stat active"></i>
            </div>
        </div>
    </div>
    <!-- title end -->
    <!-- dialog box condition button begin -->

    <button type="button" class="dialog-box-condition-btn active" id="dialog-box-condition-btn2">
        <i class="dialog-box-icon arrow"></i>
    </button>

    <!-- dialog box condition button end -->
    
    <!-- tab block begin
    <div class="dialog-box-tab-block">
        <div class="dialog-box-tab-toogler">
            <a href="#" id="switcher-all" class="switcher">Все</a>
            <a href="#" id="switcher-last" class="switcher active">Последние</a>
            <div class="clearfix"></div>
        </div>​
    </div>
    <!-- tab block end -->

    <!-- sections links begin -->
    <div class="dialog-box-section-navy">
        <ul id="dialog-box-section-navy-list" >
            <li>
                <a href="javascript: void(0);" class="tooltip dialog-box-onclick-activated filter-online-chat active" onclick="Chat.closeAllWindows();" title="чат">
                    <i class="dialog-box-icon chat"></i>
                </a>
            </li><li>
                <a href="javascript: void(0);" class="tooltip dialog-box-onclick-activated filter-online-favorite" onclick="Chat.OnlyOnline($(this));Chat.SerchCloseALL();" title="онлайн">
                    <div class="num" id="online"><?= Friend::getOnlineCountity($friend_model); ?></div>
                    <i class="dialog-box-icon online"></i>
                </a>
            </li><li>
                <a href="javascript: void(0);" class="tooltip dialog-box-onclick-activated filter-online-favorite" onclick="Chat.OnlyFavorite($(this));Chat.SerchCloseALL();"title="избранные">
                    <i class="dialog-box-icon choosen"></i>
                </a>
            </li><li>
                <a href="javascript:void(0);" class="tooltip dialog-box-onclick-activated" title="группы"onclick="Chat.GroupOpen($(this))"  data-userid="new_groups1" data-user = "group">
                    <i class="dialog-box-icon group"></i>
                </a>
            </li><li>
                <a href="javascript:void(0);" class="tooltip dialog-box-onclick-activated" onclick="Chat.serchOpenFreands($(this))" title="поиск">
                    <i class="dialog-box-icon serch"></i>
                </a>
            </li>
<!--            <li>
                <a href="#" class="tooltip dialog-box-onclick-activated" title="добавить контакт" onclick="Chat.SerchOpenAddContact($(this));">
                    <i class="dialog-box-icon add"></i>
                </a>
            </li>
-->
        </ul>
    </div>        
    <!-- sections links end -->

    <!-- user list block begin -->

    <div class="dialog-box-user-list-block">
        <!-- Вывод активных кнопок begin -->
        <div class="dialog-box-serch-show dialog_box_serch_show_bl">
            <div class="dialog-box-appending-serch dialog_box_serch_show" id="search_add_contact">
                <input  onkeyup="Chat.FindSomeUsersAddContact($(this))" type="text" placeholder="Поиск по всем">
                <button type="button">
                    <i class="dialog-box-icon serch"></i>
                </button>
            </div>
        </div>
        <div class="dialog-box-serch-show dialog_box_serch_show_bl">
            <div class="dialog-box-appending-serch dialog_box_serch_show" id="search_add_freands">
                <input  onkeyup="Chat.FindSomeUsersFromFriend($(this))" type="text" placeholder="Поиск по друзьям">
                <button type="button">
                    <i class="dialog-box-icon serch"></i>
                </button>
            </div>
        </div>
        <div class="dialog-box-serch-show" id="dialog_box_serch_show_group">
            <div class="dialog-box-group-add dialog_box_serch_show" id="dialog_group">
                <button type="button" onclick="Chat.activeGroupEditor()" class="button-group-add">СОЗДАТЬ</button>
            </div>
        </div>

        <!-- Вывод активных кнопок end -->
        <!-- serch results begin
        <div class="dialog-box-serch-results dialog_box_serch_show" id='dialog_search_add_contact_list'>
            <div class="item-bl">
                <div class="title-bl">
                    Найдено
                    <a class="close-bl" href="javascript:void(0);" onClick="Chat.SerchCloseAddContact();"><i class="dialog-box-icon close"></i></a>
                </div>
            </div>
            <div class="clearfix"></div>
            <h3>Добавить контакт</h3>
            <p>Поиск знакомых по имени, логину или Steam ID</p>
            <div class="dialog-box-search-all serch-target">

            </div>      
        </div>
    -->
        <div class="dialog-box-serch-results dialog_box_serch_show " id='dialog_search_freands_list'>  <!-- if search users add class found -->
            <!--<div class="item-bl">
                <div class="title-bl">
                    Найдено
                    <a class="close-bl" href="javascript:void(0);" onClick="Chat.SerchCloseFreands();"><i class="dialog-box-icon close"></i></a>
                </div>

            </div>   -->
            <div class="clearfix"></div>
            <h3 >Добавить контакт</h3>
            <p>Поиск знакомых по имени, логину или Steam ID</p>
            <div class="dialog-box-search-all serch-target">
                <!-- user item begin -->

                <!-- user item end -->
            </div>            
        </div>
        <!-- Group  -->
        <!--
        <div class="dialog-box-serch-results dialog_box_serch_show" id='dialog_group_list'>
            <div class="item-bl">
                <div class="title-bl">
                    Найдено
                    <a class="close-bl" href="javascript:void(0);" onClick="Chat.GroupClose();"><i class="dialog-box-icon close"></i></a>
                </div>
            </div>



            <div class="dialog-box-group-list">
            
          
            </div>         
        </div>
        -->
        <!-- Group ************************************************************************************* -->            
        <div class="dialog-box-tab-box" id="dialog-box-user-list-tab">
            <div id="dialog-box-contenttab-all" class="dialog-box-content active" style="color:#fff;">              
                <div class="dialog-box-group-list">
                    <!-- group item begin -->
                    <?php if($model_group): ?>
                    <?php foreach ($model_group as $group): ?>
                    <?php $q = GroupView::getMessageQuantityByGroupId($group->group_id);?>
                        <form class="dialog-box-user-list-item" id="edit_group_id_<?= $group->group_id ?>">
                            <div class="dialog-box-main-avatar-block">
                                <div class="num num_group_<?= $group->group_id ?> <?php if($q > 0){ echo"active";}?>"><?= $q ?></div>
                                <img src="/images/group.jpg" alt="ava" width="30" height="30" />
                            </div>
                            <div class="dialog-box-user-list-name">
                                <span><?= Group::getGroupNameById($group->group_id); ?></span>
                                <input type="text" name="text" class="new_name_<?= $group->group_id ?>" data_id="<?= $group->group_id ?>" value="<?= Group::getGroupNameById($group->group_id); ?>">
                            </div>
                            <div class="dialog-box-user-choosen-block" style="z-index: 10;">
                                <button type="button" class="dialog-box-icon edit" onclick="show_dialog_group_form('edit_group_id_<?= $group->group_id ?>')"></button>
                                <button type="button" class="dialog-box-icon save" onclick="Group.SaveGroupName('edit_group_id_<?= $group->group_id ?>', '<?= $group->group_id ?>')"></button>
                            </div>
                            <div class="dialog_group_show dialog-box-show" data-userid="<?= $group->group_id ?>" onclick="Chat.openGroupId(<?= $group->group_id ?>, $(this))"></div>
                        </form>
                            <script>
                                $(document).ready(function() {
                                    $('body').on('keypress', '.new_name_<?= $group->group_id ?>', function (e) {
                                        if (e.keyCode == 13) {
                                            e.preventDefault();
                                            Group.SaveGroupName('edit_group_id_' + $(this).attr('data_id'), $(this).attr('data_id'));
                                        }
                                        if (e.keyCode == 27) {
                                            $('#edit_group_id_'+$(this).attr('data_id')).removeClass('active');
                                        }
                                    });
                                });
                            </script>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <!-- group item end **********************************************************************-->
                </div>


                <!-- ****************** all model ***************************************** -->
                <?php
               // echo $this->render('//layouts/_partial/_chat-all');
                ?>
                <!-- ****************** all model end ***************************************** -->

                <div class="user_freand_spisok">

                <!-- ****************** friends ***************************************** -->
                <?php
                // echo $this->render('//layouts/_partial/_chat-friends');
                ?>
                </div>
                <!-- ****************** friends end ***************************************** -->
            </div>
                <!--
                <div id="dialog-box-contenttab-last" class="dialog-box-content" style="color:#fff;">
                    Tab 2 Content
                </div>
                -->
        </div>​
    </div>
    <!-- user list block end -->

    <!-- dialog box name begin -->
    <div onclick="MainChat.OpenMainDialog()" class="dialog-box-name-block " data-userid="dialog_main_general">
        <div class="inner">
            <div class="dialog-box-mp-icon">
                <i class="dialog-box-icon mp"></i>
            </div>
            <span>Мирпрост Чат</span>
        </div>
    </div>

    <!-- dialog box condition button begin -->

    <button type="button" class="dialog-box-condition-btn active" id="dialog-box-condition-btn">
        <i class="dialog-box-icon arrow"></i>
    </button>

    <!-- dialog box condition button end -->

</div>
<!-- dialog box main end-->

<!--
<div class="dialog-box light-box chat-win-dialog" data-index="1000" id="okno_chat_info">
    <table class="chat-del-info">
        <tr>
            <td>
                <div class="name-bl">Удалить диалог</div>
                <div class="title-bl">Вы действительно хотите удалить всю историю переписки с этим пользователем?</div>
                <div class="btn-bl">
                    <a href="javascript:void(0);" class="btn-70x26 del-btn" onclick="Chat.deleteDialogToUserFinishOK()">удалить</a>
                    <a href="javascript:void(0);" class="btn-70x26 ok-btn" onclick="close_dialog('okno_chat_info')">оставить</a>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="dialog-box light-box chat-win-dialog" data-index="1000" id="okno_chat_group_info">
    <table class="chat-del-info">
        <tr>
            <td>
                <div class="name-bl">Удалить группу</div>
                <div class="title-bl">Вы действительно хотите удалить группу?</div>
                <div class="btn-bl">
                    <a href="javascript:void(0);" class="btn-70x26 del-btn" onclick="Group.DeleteGropByIdFinish()">удалить</a>
                    <a href="javascript:void(0);" class="btn-70x26 ok-btn" onclick="close_dialog('okno_chat_group_info')">оставить</a>
                </div>
            </td>
        </tr>
    </table>
</div>
-->