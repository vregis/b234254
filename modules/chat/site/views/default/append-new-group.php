
    <form class="dialog-box-user-list-item" id="edit_group_id_<?= $group->id ?>" >
        <div class="dialog-box-main-avatar-block">
            <!-- massage number begin -->
            <div class="num"></div>
            <!-- massage number end -->
            <img src="/images/group.jpg" alt="ava" width="30" height="30" />
        </div><div class="dialog-box-user-list-name">
            <span><?= $group->name ?></span>
            <input type="text" name="text" class="new_name_<?= $group->id ?>" value="<?= $group->name ?>">

        </div><div class="dialog-box-user-choosen-block">
            <button type="button" class="dialog-box-icon edit" onclick="show_dialog_group_form('edit_group_id_<?= $group->id ?>')"></button>
            <button type="button" class="dialog-box-icon save" onclick="Group.SaveGroupName('edit_group_id_<?= $group->id ?>', '<?= $group->id ?>')"></button>
        </div>
        <div class="dialog_group_show dialog-box-show posible-dublicate" data-userid="<?= $group->id ?>" onclick="Chat.openGroupId(<?= $group->id ?>, $(this))"></div>
    </form>
    <script>
        $(document).ready(function() {
            $('body').on('keypress', '.new_name_<?= $group->id ?>', function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    //Group.SaveGroupName('edit_group_id_<?= $group->id ?>',<?= $group->id ?>);
                }
            });
        });
    </script>