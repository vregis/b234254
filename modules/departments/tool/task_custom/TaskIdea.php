<?php

/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 02.02.2016
 * Time: 17:06
 */

namespace modules\departments\tool\task_custom;

use modules\departments\models\Idea;
use modules\departments\models\Industry;
use modules\tasks\models\Task;
use modules\tasks\models\UserTool;
use modules\user\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class TaskIdea extends TaskIdeaMilestone
{
    public function __construct($file_name, $task, $task_videos, $task_notes, $task_links, $files)
    {
        parent::__construct($file_name, $task, $task_videos, $task_notes, $task_links, $files);
    }
    public function render($config = []) {

        $idea = new Idea();
        $industries = Industry::find()->all();

        if($idea->load(Yii::$app->request->post()) && $idea->validate()) {
            $tool = UserTool::createUserTool();
            $tool->status = UserTool::STATUS_IDEA_FILLED;
            $tool->save(false);
            Yii::$app->session['tool_id'] = $tool->id;

            $user = User::find()->where(['id' => Yii::$app->user->id])->one();
            if($user->user_type == 1){
                $user->user_type = 2;
                $user->save();
            }


            $idea->user_tool_id = $tool->id;
            $idea->create_date = ''.date('Y-m-d');
            $idea->save(false);
            Yii::$app->controller->redirect(['/departments/task','id' => Task::$task_idea_benefits_id]);
        }

        return parent::render(
            [
                'idea' => $idea,
                'industries' => $industries,
            ]
        );
    }
}