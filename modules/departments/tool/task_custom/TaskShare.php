<?php

/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 02.02.2016
 * Time: 17:06
 */

namespace modules\departments\tool\task_custom;

use modules\departments\models\Benefit;
use modules\departments\models\Industry;
use modules\tasks\models\Task;
use modules\tasks\models\UserTool;
use Yii;
use yii\helpers\ArrayHelper;

class TaskShare extends TaskIdeaMilestone
{
    protected $user_tool_id;
    public function __construct($user_tool_id,$file_name, $task, $task_videos, $task_notes, $task_links, $files)
    {
        $this->user_tool_id = $user_tool_id;
        parent::__construct($file_name, $task, $task_videos, $task_notes, $task_links, $files);
    }
    public function render($config = []) {

        return parent::render(
            [
                'user_tool_id' => $this->user_tool_id,
            ]
        );
    }
}