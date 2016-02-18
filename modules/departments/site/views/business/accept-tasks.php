<?php

use yii\helpers\Url;
use modules\milestones\models\Milestone;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\departments\models\Idea;
use modules\user\models\User;
$this->registerCssFile("/css/business.css");

$msgJs = <<<JS
        function fontSize() {
            if($('html').width() < 767) {
                var width = 520; // ширина, от которой идет отсчет
                var fontSize = 10; // минимальный размер шрифта
                var bodyWidth = $('html').width();
                var multiplier = bodyWidth / width;
                if ($('html').width() >= width) fontSize = Math.floor(fontSize * multiplier);
                $('.tables-business').css({fontSize: fontSize+'px'});
            }
            else {
                $('.tables-business').css({fontSize: '14px'});
            }
        }
        $(function() { fontSize(); });
        $(window).resize(function() { fontSize(); });
JS;
$this->registerJs($msgJs);
?>
<div class="col-md-12 tables-business">
    <div style="margin: 0 auto; max-width: 1000px">
        <h3 class="page-title">
            Delegated tasks
        </h3>

        <table class="table table-light">
            <thead>
            <tr>
                <th> Name </th>
            </tr>
            </thead>
            <tbody>
            <? foreach($tasks as $task) : ?>
                    <tr>
                        <td style="text-transform: uppercase">
                            <a target="_blank" href="<?= Url::toRoute(['/tasks', 'id' => $task->task, 'task_user_id' => $task->task_user_id, 'delegate_task_id' => $task->id]) ?>" class="btn blue"><?= $task->name ?></a>
                        </td>
                    </tr>
            <? endforeach; ?>
            </tbody>
        </table>
    </div>
</div>