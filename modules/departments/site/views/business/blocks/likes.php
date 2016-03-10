
<?php for($i=1; $i<=3; $i++):?>
    <?php $can = null;?>
    <?php $likes = \modules\departments\models\BenefitLike::find()->where(['user_tool_id' => $id, 'benefit_id' => $i, 'like' => 1])->all(); //TODO refactor this?>
    <?php $dislikes = \modules\departments\models\BenefitLike::find()->where(['user_tool_id' => $id, 'benefit_id' => $i, 'dislike' => 1])->all();?>
    <?php $can = \modules\departments\models\BenefitLike::find()->where(['user_tool_id' => $id, 'benefit_id' => $i, 'ip_address' => $_SERVER['REMOTE_ADDR']])->one();?>
    <?php //var_dump($can->dislike);?>
    <td class="likes">
        <table>
            <tr class="benefit" data-benefit-id = '<?php echo $i?>'>
                <td>
                    <div class="text-right" style="margin-right: 5px;display: inline-block;width: 50px;font-size: 14px;"><?php echo count($dislikes)?></div>
                    <a href="" onclick="return false" class="btn btn-primary <?php echo (!$can)?'add-thumb':(($can->dislike ==1)?'hover':'')?> left-circle dislike static"><i class="ico-dislike"></i></a>
                    <a href="" onclick="return false" class="btn btn-primary <?php echo (!$can)?'add-thumb':(($can->like ==1)?'hover':'')?> right-circle like static"><i class="ico-like"></i></a>
                    <div class="text-left" style="margin-left: 5px;display: inline-block;width: 50px;font-size: 14px;"><?php echo count($likes)?></div>
                    
                    
                </td>
            </tr>
        </table>
    </td>
<?php endfor;?>
<style>
    .hover.like{
        color: #0F9D58!important;
    }
    .hover.dislike{
        color: #FF5252!important;
    }
</style>
