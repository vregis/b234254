
<?php for($i=1; $i<=3; $i++):?>
    <?php $can = null;?>
    <?php $likes = \modules\departments\models\BenefitLike::find()->where(['user_tool_id' => $id, 'benefit_id' => $i, 'like' => 1])->all(); //TODO refactor this?>
    <?php $dislikes = \modules\departments\models\BenefitLike::find()->where(['user_tool_id' => $id, 'benefit_id' => $i, 'like' => 0])->all();?>
    <?php $can = \modules\departments\models\BenefitLike::find()->where(['user_tool_id' => $id, 'benefit_id' => $i, 'ip_address' => $_SERVER['REMOTE_ADDR']])->one();?>
    <?php //var_dump($can);?>
    <td class="likes">
        <table>
            <tr class="benefit" data-benefit-id = '<?php echo $i?>'>
                <td>
                    <a href="" onclick="return false" class="btn btn-primary <?php echo (!$can)?'add-thumb':(($can->like ==1)?'hover':'')?> circle like"><i class="fa fa-thumbs-o-up"></i></a>
                    <?php echo count($likes)?>
                </td>
                <td>
                    <a href="" onclick="return false" class="btn btn-primary <?php echo (!$can)?'add-thumb':(($can->like ==0)?'hover':'')?> circle dislike"><i class="fa fa-thumbs-o-down"></i></a>
                    <?php echo count($dislikes)?>
                </td>
            </tr>
        </table>
    </td>
<?php endfor;?>
<style>
    .hover{
        border-color: #5184f3 !important;
        background-color: #5184f3 !important;
        color: #ffffff !important;
    }
</style>
