<?php use yii\helpers\Url;?>
<?php foreach($tasks as $t):?>
    <tr role="row" >
        <td>
            <?php echo $t->id?>
        </td>
        <td style="text-align:center;" class="cent" >
            <?php if($t->priority == 3):?>
                <div class="s_high">H</div>
            <?php elseif($t->priority == 2):?>
                <div class="s_medium">M</div>
            <?php else:?>
                <div class="s_low">L</div>
            <?php endif;?>
        </td>
        <td>
            <a href="<?= Url::toRoute(['/tasks', 'id' => $t->id]) ?>"><?= $t->name ?></a>
        </td>
        <td>
            <?php $spec = \modules\departments\models\Specialization::find()->where(['id' => $t->specialization_id])->one();?>
            <?php echo  $spec->name; ?>
        </td>
        <td>
            <?php echo $t->recommended_time?>h
        </td>
        <td>
            <?php echo $t->market_rate?>$</td>
        <td>
            active
        </td>
    </tr>
<?php endforeach; ?>