<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 02.02.2016
 * Time: 17:14
 */

namespace modules\departments\tool\task_custom;


use modules\departments\models\Goal;
use Yii;
use yii\base\Component;

class TaskPersonGoal extends TaskCustom
{
    public function __construct($task)
    {
        parent::__construct('person_goal', $task);
    }
    public function render($config = []) {
        $goal = Goal::find()->where(['user_id' => Yii::$app->user->id])->one();
        if (is_null($goal)) {
            $goal = new Goal();
            $goal->count_money = 1000000;
        }
        return parent::render(
            [
                'task' =>  $this->m_task,
                'goal' => $goal
            ]
        );
    }
}