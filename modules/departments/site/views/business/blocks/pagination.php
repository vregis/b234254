<? //if(count($users) > 5): ?>
<tr>
    <td colspan="8" style="padding: 0; border: none;height:0">
        <ul class="pagination">
            <li class="disabled">
                <a class="prev-page">
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>
            <? //for($i = 0, $page_id=0; $i<count($users);$i+=5,$page_id++) : ?>
                <li class="<? //echo $page_id==0? 'active' : ''?>">
                    <a class="go-page" data-page-id="<? //echo $page_id ?>"> <? //echo $page_id+1 ?> </a>
                </li>
            <? //endfor; ?>
            <li class="<? //echo count($users) <= 5 ? 'disabled':'' ?>">
                <a class="next-page">
                    <i class="fa fa-angle-right"></i>
                </a>
            </li>
        </ul>
    </td>
</tr>
<? //endif; ?>