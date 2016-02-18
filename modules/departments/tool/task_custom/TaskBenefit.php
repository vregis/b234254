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

class TaskBenefit extends TaskIdeaMilestone
{
    protected $user_tool_id;
    public function __construct($user_tool_id,$file_name, $task, $task_videos, $task_notes, $task_links, $files)
    {
        $this->user_tool_id = $user_tool_id;
        parent::__construct($file_name, $task, $task_videos, $task_notes, $task_links, $files);
    }
    public function render($config = []) {

        $benefit = Benefit::find()->where(['user_tool_id' => $this->user_tool_id])->one();
        if(!$benefit) {
            $benefit = new Benefit();
            $benefit->user_tool_id = $this->user_tool_id;
        }

        if($benefit->load(Yii::$app->request->post()) && $benefit->save()) {
            $tool = UserTool::getCurrentUserTool();
            if($tool && $tool->status == UserTool::STATUS_IDEA_FILLED) {
                $tool->status = UserTool::STATUS_IDEA_BENEFITS_FILLED;
                $tool->save(false);
            }
            Yii::$app->controller->redirect(['/departments/task','id' => Task::$task_idea_share_id]);
        }

        return parent::render(
            [
                'benefit' => $benefit,
            ]
        );
    }
}