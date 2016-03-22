<tr>
    <td colspan="8" style="padding: 0; border: none;height:0">

        <?php $countPage = 1;?>


        <ul class="pagination">
            <? for($i = 1; $i<=$countPage;$i++): ?>
                <li class="<? //echo $page_id==0? 'active' : ''?>">
                    <a class="go-page" data-page-id="<?php echo $i?>"> <?php echo $i ?> </a>
                </li>
            <? endfor; ?>
        </ul>
    </td>
</tr>