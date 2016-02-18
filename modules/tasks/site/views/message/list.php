<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 11.01.2016
 * Time: 15:19
 */
?>

<? foreach($group_messages as $data => $group_message) : ?>
    <div class="daySepar"><span><?=$data;?></span><div class="line"></div></div>
    <? foreach($group_message as $message) : ?>
        <?php $messageDate = new DateTime($message->date);  ?>
        <li class="task-user-message <?php echo $message->user_id == Yii::$app->user->id ? 'my' : 'other' ?>">
            <table>
                <tr>
                    <?php if($message->user_id == Yii::$app->user->id): ?>
                        <td class="time"><?php echo $messageDate->format("h:i A"); ?></td>
                        <td><div class="message"><?= $message->message ?></div></td>
                    <?php else: ?>
                        <td><div class="message"><?= $message->message ?></div></td>
                        <td class="time"><?php echo $messageDate->format("h:i A"); ?></td>
                    <?php endif; ?>
                </tr>
            </table>
        </li>
    <? endforeach; ?>
    <div class="clearfix"></div>
<? endforeach; ?>
