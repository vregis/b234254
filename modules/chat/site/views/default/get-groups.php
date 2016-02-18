<?php
    use modules\chat\models\Group;
    use modules\chat\models\GroupView;
?>


<?php foreach ($model_group as $group): ?>
  <?php $q = GroupView::getMessageQuantityByGroupId($group->group_id);
  //vd($q);
  ?>
    <form class="dialog-box-user-list-item" id="edit_group_id_<?= $group->group_id ?>" >
        <div class="dialog-box-main-avatar-block">
            <!-- massage number begin -->
              <div class="num num_group_<?= $group->group_id ?> <?php if($q > 0){ echo"active";}?>"><?= $q ?></div>
            <!-- massage number end -->
            <img src="/images/group.jpg" alt="ava" width="30" height="30" />
        </div><div class="dialog-box-user-list-name">
            <span><?= Group::getGroupNameById($group->group_id ); ?></span>
            <input type="text" name="text" class="new_name_<?= $group->group_id ?>" value="<?= Group::getGroupNameById($group->group_id ); ?>" onkeypress="alert($(this).keyCode);">

        </div><div class="dialog-box-user-choosen-block">
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
                    Group.SaveGroupName('edit_group_id_<?= $group->group_id ?>',<?= $group->group_id ?>);
                }
            });
        });
    </script>
<?php endforeach; ?>